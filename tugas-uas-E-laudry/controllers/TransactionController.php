<?php
/**
 * Transaction Controller
 */

declare(strict_types=1);

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    
    /**
     * List all transactions
     */
    public function index(): void
    {
        $this->setTitle('Daftar Transaksi');
        $this->setMenu('transactions');
        
        $status = $this->get('status');
        
        if ($status && array_key_exists($status, Transaction::STATUSES)) {
            $transactions = Transaction::byStatus($status);
        } else {
            $transactions = Transaction::all();
        }
        
        $this->view('transactions/index', [
            'transactions' => $transactions,
            'currentStatus' => $status,
            'statuses' => Transaction::STATUSES
        ]);
    }
    
    /**
     * Show create form
     */
    public function create(): void
    {
        $this->setTitle('Transaksi Baru');
        $this->setMenu('transactions');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('transactions/create', [
            'customers' => Customer::all(),
            'packages' => Package::active()
        ]);
    }
    
    /**
     * Store new transaction
     */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/transaction');
        }
        
        $customerId = (int) $this->post('customer_id', 0);
        $promoCode = $this->sanitize($this->post('promo_code', ''));
        $notes = $this->sanitize($this->post('notes', ''));
        
        // Check for new customer
        if ($customerId === 0) {
            $customerName = $this->sanitize($this->post('customer_name', ''));
            $customerPhone = $this->sanitize($this->post('customer_phone', ''));
            $customerAddress = $this->sanitize($this->post('customer_address', ''));
            
            if (empty($customerName) || empty($customerPhone)) {
                Session::flash('error', 'Nama dan telepon pelanggan harus diisi');
                $this->redirect('/transaction/create');
            }
            
            $customerId = Customer::create([
                'name' => $customerName,
                'phone' => $customerPhone,
                'address' => $customerAddress
            ]);
        }
        
        // Get items
        $packageIds = $this->post('package_id', []);
        $quantities = $this->post('quantity', []);
        
        if (empty($packageIds) || !is_array($packageIds)) {
            Session::flash('error', 'Minimal pilih satu paket layanan');
            $this->redirect('/transaction/create');
        }
        
        // Start transaction
        Database::beginTransaction();
        
        try {
            // Calculate subtotal
            $subtotal = 0;
            $items = [];
            
            foreach ($packageIds as $index => $packageId) {
                $package = Package::find((int) $packageId);
                if (!$package) continue;
                
                $qty = (float) ($quantities[$index] ?? 1);
                if ($qty <= 0) continue;
                
                $itemSubtotal = $package['price'] * $qty;
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'package_id' => (int) $packageId,
                    'quantity' => $qty,
                    'price' => $package['price'],
                    'subtotal' => $itemSubtotal
                ];
            }
            
            if (empty($items)) {
                throw new Exception('Tidak ada item yang valid');
            }
            
            // Check promo
            $promoId = null;
            $discount = 0;
            
            if (!empty($promoCode)) {
                $promoResult = Promo::validate($promoCode, $subtotal);
                if ($promoResult['valid']) {
                    $promoId = $promoResult['promo']['id'];
                    $discount = Promo::calculateDiscount($promoResult['promo'], $subtotal);
                }
            }
            
            $total = max(0, $subtotal - $discount);
            
            // Create transaction
            $transactionId = Transaction::create([
                'customer_id' => $customerId,
                'user_id' => Session::userId(),
                'promo_id' => $promoId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'notes' => $notes
            ]);
            
            // Add items
            foreach ($items as $item) {
                Transaction::addItem($transactionId, $item);
            }
            
            Database::commit();
            
            Session::flash('success', 'Transaksi berhasil dibuat');
            $this->redirect('/transaction/show/' . $transactionId);
            
        } catch (Exception $e) {
            Database::rollback();
            Session::flash('error', 'Gagal membuat transaksi: ' . $e->getMessage());
            $this->redirect('/transaction/create');
        }
    }
    
    /**
     * Show transaction detail
     */
    public function show(int $id): void
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/transaction');
        }
        
        $items = Transaction::getItems($id);
        
        $this->setTitle('Detail Transaksi');
        $this->setMenu('transactions');
        
        $this->view('transactions/show', [
            'transaction' => $transaction,
            'items' => $items,
            'statuses' => Transaction::STATUSES
        ]);
    }
    
    /**
     * Print receipt
     */
    public function print(int $id): void
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/transaction');
        }
        
        $items = Transaction::getItems($id);
        
        $this->data['transaction'] = $transaction;
        $this->data['items'] = $items;
        $this->data['settings'] = Setting::all();
        
        $this->view('transactions/print', [], 'print');
    }
    
    /**
     * Update status
     */
    public function status(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/transaction/show/' . $id);
        }
        
        $transaction = Transaction::find($id);
        if (!$transaction) {
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/transaction');
        }
        
        $newStatus = $this->post('status', '');
        
        if (!array_key_exists($newStatus, Transaction::STATUSES)) {
            Session::flash('error', 'Status tidak valid');
            $this->redirect('/transaction/show/' . $id);
        }
        
        Transaction::updateStatus($id, $newStatus);
        Session::flash('success', 'Status berhasil diubah');
        $this->redirect('/transaction/show/' . $id);
    }
    
    /**
     * Move to next status
     */
    public function next(int $id): void
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
            }
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/transaction');
        }
        
        $result = Transaction::nextStatus($id);
        
        if ($this->isAjax()) {
            $updated = Transaction::find($id);
            $this->json([
                'success' => $result,
                'status' => $updated['status'],
                'label' => Transaction::getStatusLabel($updated['status']),
                'color' => Transaction::getStatusColor($updated['status'])
            ]);
        }
        
        if ($result) {
            Session::flash('success', 'Status berhasil diubah');
        } else {
            Session::flash('error', 'Status tidak dapat diubah');
        }
        
        $this->redirect('/transaction/show/' . $id);
    }
    
    /**
     * Delete transaction
     */
    public function delete(int $id): void
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/transaction');
        }
        
        Transaction::delete($id);
        Session::flash('success', 'Transaksi berhasil dihapus');
        $this->redirect('/transaction');
    }
}

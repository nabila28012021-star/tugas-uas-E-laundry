<?php
/**
 * Tracking Controller (Public)
 */

declare(strict_types=1);

class TrackingController extends Controller
{
    /**
     * Show tracking form
     */
    public function index(): void
    {
        $this->setTitle('Lacak Laundry');
        $this->view('tracking/index', [], 'public');
    }
    
    /**
     * Search transaction by invoice code
     */
    public function search(): void
    {
        $invoiceCode = $this->sanitize($this->get('code', $this->post('code', '')));
        
        if (empty($invoiceCode)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Masukkan kode resi']);
            }
            Session::flash('error', 'Masukkan kode resi');
            $this->redirect('/tracking');
        }
        
        $transaction = Transaction::findByInvoice($invoiceCode);
        
        if (!$transaction) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
            }
            Session::flash('error', 'Transaksi tidak ditemukan');
            $this->redirect('/tracking');
        }
        
        $items = Transaction::getItems($transaction['id']);
        
        if ($this->isAjax()) {
            $this->json([
                'success' => true,
                'transaction' => $transaction,
                'items' => $items,
                'status' => [
                    'label' => Transaction::getStatusLabel($transaction['status']),
                    'color' => Transaction::getStatusColor($transaction['status']),
                    'icon' => Transaction::getStatusIcon($transaction['status'])
                ],
                'statuses' => Transaction::STATUSES
            ]);
        }
        
        $this->setTitle('Hasil Pencarian');
        $this->view('tracking/result', [
            'transaction' => $transaction,
            'items' => $items,
            'statuses' => Transaction::STATUSES
        ], 'public');
    }
}

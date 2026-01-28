<?php
/**
 * Customer Controller
 */

declare(strict_types=1);

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    
    /**
     * List all customers
     */
    public function index(): void
    {
        $this->setTitle('Data Pelanggan');
        $this->setMenu('customers');
        
        $customers = Customer::all();
        
        $this->view('customers/index', [
            'customers' => $customers
        ]);
    }
    
    /**
     * Show create form
     */
    public function create(): void
    {
        $this->setTitle('Tambah Pelanggan');
        $this->setMenu('customers');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('customers/create');
    }
    
    /**
     * Store new customer
     */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/customer');
        }
        
        $data = [
            'name' => $this->sanitize($this->post('name', '')),
            'phone' => $this->sanitize($this->post('phone', '')),
            'address' => $this->sanitize($this->post('address', ''))
        ];
        
        if (empty($data['name']) || empty($data['phone'])) {
            Session::flash('error', 'Nama dan nomor telepon harus diisi');
            $this->redirect('/customer/create');
        }
        
        Customer::create($data);
        Session::flash('success', 'Pelanggan berhasil ditambahkan');
        $this->redirect('/customer');
    }
    
    /**
     * Show edit form
     */
    public function edit(int $id): void
    {
        $customer = Customer::find($id);
        if (!$customer) {
            Session::flash('error', 'Pelanggan tidak ditemukan');
            $this->redirect('/customer');
        }
        
        $this->setTitle('Edit Pelanggan');
        $this->setMenu('customers');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('customers/edit', [
            'customer' => $customer
        ]);
    }
    
    /**
     * Update customer
     */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/customer');
        }
        
        $customer = Customer::find($id);
        if (!$customer) {
            Session::flash('error', 'Pelanggan tidak ditemukan');
            $this->redirect('/customer');
        }
        
        $data = [
            'name' => $this->sanitize($this->post('name', '')),
            'phone' => $this->sanitize($this->post('phone', '')),
            'address' => $this->sanitize($this->post('address', ''))
        ];
        
        if (empty($data['name']) || empty($data['phone'])) {
            Session::flash('error', 'Nama dan nomor telepon harus diisi');
            $this->redirect('/customer/edit/' . $id);
        }
        
        Customer::update($id, $data);
        Session::flash('success', 'Pelanggan berhasil diupdate');
        $this->redirect('/customer');
    }
    
    /**
     * Delete customer
     */
    public function delete(int $id): void
    {
        $customer = Customer::find($id);
        if (!$customer) {
            Session::flash('error', 'Pelanggan tidak ditemukan');
            $this->redirect('/customer');
        }
        
        if (Customer::hasTransactions($id)) {
            Session::flash('error', 'Pelanggan tidak dapat dihapus karena sudah memiliki transaksi');
            $this->redirect('/customer');
        }
        
        Customer::delete($id);
        Session::flash('success', 'Pelanggan berhasil dihapus');
        $this->redirect('/customer');
    }
    
    /**
     * Search customers (AJAX)
     */
    public function search(): void
    {
        $keyword = $this->get('q', '');
        $customers = Customer::search($keyword);
        
        $this->json([
            'success' => true,
            'data' => $customers
        ]);
    }
}

<?php
/**
 * Promo Controller
 */

declare(strict_types=1);

class PromoController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    
    /**
     * List all promos
     */
    public function index(): void
    {
        $this->setTitle('Kode Promo');
        $this->setMenu('promos');
        
        $promos = Promo::all();
        
        $this->view('promos/index', [
            'promos' => $promos
        ]);
    }
    
    /**
     * Show create form
     */
    public function create(): void
    {
        $this->setTitle('Tambah Promo');
        $this->setMenu('promos');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('promos/create');
    }
    
    /**
     * Store new promo
     */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/promo');
        }
        
        $data = [
            'code' => $this->sanitize($this->post('code', '')),
            'name' => $this->sanitize($this->post('name', '')),
            'discount_type' => $this->post('discount_type', 'percent'),
            'discount_value' => (float) $this->post('discount_value', 0),
            'min_purchase' => (float) $this->post('min_purchase', 0),
            'max_discount' => $this->post('max_discount') ? (float) $this->post('max_discount') : null,
            'valid_from' => $this->post('valid_from', date('Y-m-d')),
            'valid_until' => $this->post('valid_until', date('Y-m-d')),
            'is_active' => $this->post('is_active', 0) ? 1 : 0
        ];
        
        if (empty($data['code']) || empty($data['name']) || $data['discount_value'] <= 0) {
            Session::flash('error', 'Kode, nama, dan nilai diskon harus diisi dengan benar');
            $this->redirect('/promo/create');
        }
        
        if (Promo::codeExists($data['code'])) {
            Session::flash('error', 'Kode promo sudah digunakan');
            $this->redirect('/promo/create');
        }
        
        Promo::create($data);
        Session::flash('success', 'Promo berhasil ditambahkan');
        $this->redirect('/promo');
    }
    
    /**
     * Show edit form
     */
    public function edit(int $id): void
    {
        $promo = Promo::find($id);
        if (!$promo) {
            Session::flash('error', 'Promo tidak ditemukan');
            $this->redirect('/promo');
        }
        
        $this->setTitle('Edit Promo');
        $this->setMenu('promos');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('promos/edit', [
            'promo' => $promo
        ]);
    }
    
    /**
     * Update promo
     */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/promo');
        }
        
        $promo = Promo::find($id);
        if (!$promo) {
            Session::flash('error', 'Promo tidak ditemukan');
            $this->redirect('/promo');
        }
        
        $data = [
            'code' => $this->sanitize($this->post('code', '')),
            'name' => $this->sanitize($this->post('name', '')),
            'discount_type' => $this->post('discount_type', 'percent'),
            'discount_value' => (float) $this->post('discount_value', 0),
            'min_purchase' => (float) $this->post('min_purchase', 0),
            'max_discount' => $this->post('max_discount') ? (float) $this->post('max_discount') : null,
            'valid_from' => $this->post('valid_from', date('Y-m-d')),
            'valid_until' => $this->post('valid_until', date('Y-m-d')),
            'is_active' => $this->post('is_active', 0) ? 1 : 0
        ];
        
        if (empty($data['code']) || empty($data['name']) || $data['discount_value'] <= 0) {
            Session::flash('error', 'Kode, nama, dan nilai diskon harus diisi dengan benar');
            $this->redirect('/promo/edit/' . $id);
        }
        
        if (Promo::codeExists($data['code'], $id)) {
            Session::flash('error', 'Kode promo sudah digunakan');
            $this->redirect('/promo/edit/' . $id);
        }
        
        Promo::update($id, $data);
        Session::flash('success', 'Promo berhasil diupdate');
        $this->redirect('/promo');
    }
    
    /**
     * Delete promo
     */
    public function delete(int $id): void
    {
        $promo = Promo::find($id);
        if (!$promo) {
            Session::flash('error', 'Promo tidak ditemukan');
            $this->redirect('/promo');
        }
        
        Promo::delete($id);
        Session::flash('success', 'Promo berhasil dihapus');
        $this->redirect('/promo');
    }
    
    /**
     * Toggle active status
     */
    public function toggle(int $id): void
    {
        $promo = Promo::find($id);
        if (!$promo) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Promo tidak ditemukan']);
            }
            Session::flash('error', 'Promo tidak ditemukan');
            $this->redirect('/promo');
        }
        
        Promo::toggleActive($id);
        
        if ($this->isAjax()) {
            $this->json(['success' => true, 'message' => 'Status berhasil diubah']);
        }
        
        Session::flash('success', 'Status promo berhasil diubah');
        $this->redirect('/promo');
    }
    
    /**
     * Validate promo code (AJAX)
     */
    public function validate(): void
    {
        $code = $this->get('code', '');
        $subtotal = (float) $this->get('subtotal', 0);
        
        $result = Promo::validate($code, $subtotal);
        
        if ($result['valid']) {
            $discount = Promo::calculateDiscount($result['promo'], $subtotal);
            $this->json([
                'success' => true,
                'promo' => $result['promo'],
                'discount' => $discount,
                'discount_formatted' => Transaction::formatMoney($discount)
            ]);
        } else {
            $this->json([
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
}

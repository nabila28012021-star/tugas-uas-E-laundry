<?php
/**
 * User Controller
 */

declare(strict_types=1);

class UserController extends Controller
{
    public function __construct()
    {
        $this->requireAdmin();
    }
    
    /**
     * List all users
     */
    public function index(): void
    {
        $this->setTitle('Manajemen User');
        $this->setMenu('users');
        
        $users = User::allExcept(Session::userId());
        
        $this->view('users/index', [
            'users' => $users
        ]);
    }
    
    /**
     * Show create form
     */
    public function create(): void
    {
        $this->setTitle('Tambah User');
        $this->setMenu('users');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('users/create');
    }
    
    /**
     * Store new user
     */
    public function store(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/user');
        }
        
        $data = [
            'username' => $this->sanitize($this->post('username', '')),
            'password' => $this->post('password', ''),
            'name' => $this->sanitize($this->post('name', '')),
            'role' => $this->post('role', 'kasir'),
            'is_active' => $this->post('is_active', 0) ? 1 : 0
        ];
        
        if (empty($data['username']) || empty($data['password']) || empty($data['name'])) {
            Session::flash('error', 'Username, password, dan nama harus diisi');
            $this->redirect('/user/create');
        }
        
        if (User::usernameExists($data['username'])) {
            Session::flash('error', 'Username sudah digunakan');
            $this->redirect('/user/create');
        }
        
        User::create($data);
        Session::flash('success', 'User berhasil ditambahkan');
        $this->redirect('/user');
    }
    
    /**
     * Show edit form
     */
    public function edit(int $id): void
    {
        $user = User::find($id);
        if (!$user) {
            Session::flash('error', 'User tidak ditemukan');
            $this->redirect('/user');
        }
        
        $this->setTitle('Edit User');
        $this->setMenu('users');
        
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('users/edit', [
            'user' => $user
        ]);
    }
    
    /**
     * Update user
     */
    public function update(int $id): void
    {
        if (!$this->isPost()) {
            $this->redirect('/user');
        }
        
        $user = User::find($id);
        if (!$user) {
            Session::flash('error', 'User tidak ditemukan');
            $this->redirect('/user');
        }
        
        $data = [
            'username' => $this->sanitize($this->post('username', '')),
            'name' => $this->sanitize($this->post('name', '')),
            'role' => $this->post('role', 'kasir'),
            'is_active' => $this->post('is_active', 0) ? 1 : 0
        ];
        
        $password = $this->post('password', '');
        if (!empty($password)) {
            $data['password'] = $password;
        }
        
        if (empty($data['username']) || empty($data['name'])) {
            Session::flash('error', 'Username dan nama harus diisi');
            $this->redirect('/user/edit/' . $id);
        }
        
        if (User::usernameExists($data['username'], $id)) {
            Session::flash('error', 'Username sudah digunakan');
            $this->redirect('/user/edit/' . $id);
        }
        
        User::update($id, $data);
        Session::flash('success', 'User berhasil diupdate');
        $this->redirect('/user');
    }
    
    /**
     * Delete user
     */
    public function delete(int $id): void
    {
        $user = User::find($id);
        if (!$user) {
            Session::flash('error', 'User tidak ditemukan');
            $this->redirect('/user');
        }
        
        if ($user['id'] === Session::userId()) {
            Session::flash('error', 'Anda tidak dapat menghapus akun sendiri');
            $this->redirect('/user');
        }
        
        User::delete($id);
        Session::flash('success', 'User berhasil dihapus');
        $this->redirect('/user');
    }
}

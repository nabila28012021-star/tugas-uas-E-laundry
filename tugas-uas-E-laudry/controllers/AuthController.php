<?php
/**
 * Authentication Controller
 */

declare(strict_types=1);

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function login(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->setTitle('Login');
        $this->data['csrf_token'] = $this->generateCsrf();
        $this->view('auth/login', [], 'auth');
    }
    
    /**
     * Process login
     */
    public function authenticate(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/auth/login');
        }
        
        $username = $this->sanitize($this->post('username', ''));
        $password = $this->post('password', '');
        
        if (empty($username) || empty($password)) {
            Session::flash('error', 'Username dan password harus diisi');
            $this->redirect('/auth/login');
        }
        
        $user = User::authenticate($username, $password);
        
        if ($user) {
            Session::login($user);
            Session::flash('success', 'Selamat datang, ' . $user['name']);
            $this->redirect('/dashboard');
        } else {
            Session::flash('error', 'Username atau password salah');
            $this->redirect('/auth/login');
        }
    }
    
    /**
     * Logout
     */
    public function logout(): void
    {
        Session::logout();
        Session::flash('success', 'Anda telah keluar dari sistem');
        $this->redirect('/auth/login');
    }
}

<?php
/**
 * Dashboard Controller
 */

declare(strict_types=1);

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }
    
    /**
     * Dashboard index
     */
    public function index(): void
    {
        $this->setTitle('Dashboard');
        $this->setMenu('dashboard');
        
        // Statistics
        $stats = [
            'total_transactions' => Transaction::count(),
            'pending_transactions' => Transaction::count('baru') + Transaction::count('dicuci') + Transaction::count('disetrika'),
            'ready_pickup' => Transaction::count('siap_ambil'),
            'completed_today' => Transaction::count('selesai'),
            'total_customers' => Customer::count(),
            'total_packages' => Package::count(),
            'today_revenue' => Transaction::todayRevenue(),
            'monthly_revenue' => Transaction::monthlyRevenue(),
        ];
        
        // Recent transactions
        $recentTransactions = Transaction::all(10);
        
        // Pending transactions
        $pendingTransactions = Transaction::pending();
        
        // Status counts
        $statusCounts = [];
        foreach (Transaction::STATUSES as $status => $config) {
            $statusCounts[$status] = [
                'count' => Transaction::count($status),
                'label' => $config['label'],
                'color' => $config['color'],
                'icon' => $config['icon']
            ];
        }
        
        $this->view('dashboard/index', [
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'pendingTransactions' => $pendingTransactions,
            'statusCounts' => $statusCounts
        ]);
    }
}

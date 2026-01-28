<?php
/**
 * Transaction Model
 */

declare(strict_types=1);

class Transaction
{
    // Status constants
    public const STATUS_BARU = 'baru';
    public const STATUS_DICUCI = 'dicuci';
    public const STATUS_DISETRIKA = 'disetrika';
    public const STATUS_SIAP_AMBIL = 'siap_ambil';
    public const STATUS_SELESAI = 'selesai';
    
    // Status configuration
    public const STATUSES = [
        'baru' => ['label' => 'Baru', 'color' => 'secondary', 'icon' => 'fa-inbox', 'next' => 'dicuci'],
        'dicuci' => ['label' => 'Dicuci', 'color' => 'info', 'icon' => 'fa-tint', 'next' => 'disetrika'],
        'disetrika' => ['label' => 'Disetrika', 'color' => 'primary', 'icon' => 'fa-fire', 'next' => 'siap_ambil'],
        'siap_ambil' => ['label' => 'Siap Ambil', 'color' => 'warning', 'icon' => 'fa-box', 'next' => 'selesai'],
        'selesai' => ['label' => 'Selesai', 'color' => 'success', 'icon' => 'fa-check-circle', 'next' => null]
    ];
    
    /**
     * Find transaction by ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetch(
            "SELECT t.*, c.name as customer_name, c.phone as customer_phone, c.address as customer_address,
                    u.name as user_name, p.code as promo_code, p.name as promo_name
             FROM transactions t
             LEFT JOIN customers c ON t.customer_id = c.id
             LEFT JOIN users u ON t.user_id = u.id
             LEFT JOIN promos p ON t.promo_id = p.id
             WHERE t.id = ?",
            [$id]
        );
    }
    
    /**
     * Find transaction by invoice code
     */
    public static function findByInvoice(string $invoiceCode): ?array
    {
        return Database::fetch(
            "SELECT t.*, c.name as customer_name, c.phone as customer_phone, c.address as customer_address,
                    u.name as user_name
             FROM transactions t
             LEFT JOIN customers c ON t.customer_id = c.id
             LEFT JOIN users u ON t.user_id = u.id
             WHERE t.invoice_code = ?",
            [$invoiceCode]
        );
    }
    
    /**
     * Get all transactions
     */
    public static function all(int $limit = 100): array
    {
        return Database::fetchAll(
            "SELECT t.*, c.name as customer_name, c.phone as customer_phone, u.name as user_name
             FROM transactions t
             LEFT JOIN customers c ON t.customer_id = c.id
             LEFT JOIN users u ON t.user_id = u.id
             ORDER BY t.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }
    
    /**
     * Get transactions by status
     */
    public static function byStatus(string $status): array
    {
        return Database::fetchAll(
            "SELECT t.*, c.name as customer_name, c.phone as customer_phone, u.name as user_name
             FROM transactions t
             LEFT JOIN customers c ON t.customer_id = c.id
             LEFT JOIN users u ON t.user_id = u.id
             WHERE t.status = ?
             ORDER BY t.created_at DESC",
            [$status]
        );
    }
    
    /**
     * Get pending transactions (not completed)
     */
    public static function pending(): array
    {
        return Database::fetchAll(
            "SELECT t.*, c.name as customer_name, c.phone as customer_phone, u.name as user_name
             FROM transactions t
             LEFT JOIN customers c ON t.customer_id = c.id
             LEFT JOIN users u ON t.user_id = u.id
             WHERE t.status != 'selesai'
             ORDER BY t.entry_date ASC"
        );
    }
    
    /**
     * Generate invoice code
     */
    public static function generateInvoiceCode(): string
    {
        $date = date('Ymd');
        $prefix = "INV-{$date}-";
        
        $lastInvoice = Database::fetch(
            "SELECT invoice_code FROM transactions 
             WHERE invoice_code LIKE ? 
             ORDER BY invoice_code DESC LIMIT 1",
            [$prefix . '%']
        );
        
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice['invoice_code'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad((string) $newNumber, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Create new transaction
     */
    public static function create(array $data): int
    {
        $data['invoice_code'] = self::generateInvoiceCode();
        $data['entry_date'] = date('Y-m-d H:i:s');
        $data['estimated_date'] = date('Y-m-d H:i:s', strtotime('+2 days'));
        $data['status'] = self::STATUS_BARU;
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return Database::insert('transactions', $data);
    }
    
    /**
     * Update transaction
     */
    public static function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return Database::update('transactions', $data, 'id = ?', [$id]);
    }
    
    /**
     * Update transaction status
     */
    public static function updateStatus(int $id, string $status): int
    {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($status === self::STATUS_SELESAI) {
            $data['completed_date'] = date('Y-m-d H:i:s');
        }
        
        return Database::update('transactions', $data, 'id = ?', [$id]);
    }
    
    /**
     * Move to next status
     */
    public static function nextStatus(int $id): bool
    {
        $transaction = self::find($id);
        if (!$transaction) return false;
        
        $currentStatus = $transaction['status'];
        $nextStatus = self::STATUSES[$currentStatus]['next'] ?? null;
        
        if ($nextStatus) {
            self::updateStatus($id, $nextStatus);
            return true;
        }
        
        return false;
    }
    
    /**
     * Delete transaction
     */
    public static function delete(int $id): int
    {
        return Database::delete('transactions', 'id = ?', [$id]);
    }
    
    /**
     * Get transaction items
     */
    public static function getItems(int $transactionId): array
    {
        return Database::fetchAll(
            "SELECT ti.*, p.name as package_name, p.type as package_type
             FROM transaction_items ti
             LEFT JOIN packages p ON ti.package_id = p.id
             WHERE ti.transaction_id = ?",
            [$transactionId]
        );
    }
    
    /**
     * Add transaction item
     */
    public static function addItem(int $transactionId, array $data): int
    {
        $data['transaction_id'] = $transactionId;
        $data['subtotal'] = $data['quantity'] * $data['price'];
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return Database::insert('transaction_items', $data);
    }
    
    /**
     * Recalculate transaction totals
     */
    public static function recalculate(int $id): void
    {
        $items = self::getItems($id);
        $subtotal = array_sum(array_column($items, 'subtotal'));
        
        $transaction = self::find($id);
        $discount = 0;
        
        if ($transaction['promo_id']) {
            $promo = Promo::find($transaction['promo_id']);
            if ($promo) {
                $discount = Promo::calculateDiscount($promo, $subtotal);
            }
        }
        
        $total = max(0, $subtotal - $discount);
        
        self::update($id, [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ]);
    }
    
    /**
     * Count transactions
     */
    public static function count(?string $status = null): int
    {
        if ($status) {
            return Database::count('transactions', 'status = ?', [$status]);
        }
        return Database::count('transactions');
    }
    
    /**
     * Get today's revenue
     */
    public static function todayRevenue(): float
    {
        $result = Database::fetch(
            "SELECT COALESCE(SUM(total), 0) as revenue 
             FROM transactions 
             WHERE DATE(entry_date) = CURDATE()"
        );
        return (float) $result['revenue'];
    }
    
    /**
     * Get monthly revenue
     */
    public static function monthlyRevenue(): float
    {
        $result = Database::fetch(
            "SELECT COALESCE(SUM(total), 0) as revenue 
             FROM transactions 
             WHERE MONTH(entry_date) = MONTH(CURDATE()) 
             AND YEAR(entry_date) = YEAR(CURDATE())"
        );
        return (float) $result['revenue'];
    }
    
    /**
     * Get status label
     */
    public static function getStatusLabel(string $status): string
    {
        return self::STATUSES[$status]['label'] ?? $status;
    }
    
    /**
     * Get status color
     */
    public static function getStatusColor(string $status): string
    {
        return self::STATUSES[$status]['color'] ?? 'secondary';
    }
    
    /**
     * Get status icon
     */
    public static function getStatusIcon(string $status): string
    {
        return self::STATUSES[$status]['icon'] ?? 'fa-circle';
    }
    
    /**
     * Format money
     */
    public static function formatMoney(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

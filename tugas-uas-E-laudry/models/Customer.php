<?php
/**
 * Customer Model
 */

declare(strict_types=1);

class Customer
{
    /**
     * Find customer by ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetch(
            "SELECT * FROM customers WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Get all customers
     */
    public static function all(): array
    {
        return Database::fetchAll(
            "SELECT * FROM customers ORDER BY name ASC"
        );
    }
    
    /**
     * Search customers
     */
    public static function search(string $keyword): array
    {
        $keyword = "%{$keyword}%";
        return Database::fetchAll(
            "SELECT * FROM customers WHERE name LIKE ? OR phone LIKE ? ORDER BY name ASC",
            [$keyword, $keyword]
        );
    }
    
    /**
     * Create new customer
     */
    public static function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return Database::insert('customers', $data);
    }
    
    /**
     * Update customer
     */
    public static function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return Database::update('customers', $data, 'id = ?', [$id]);
    }
    
    /**
     * Delete customer
     */
    public static function delete(int $id): int
    {
        return Database::delete('customers', 'id = ?', [$id]);
    }
    
    /**
     * Count customers
     */
    public static function count(): int
    {
        return Database::count('customers');
    }
    
    /**
     * Check if customer has transactions
     */
    public static function hasTransactions(int $id): bool
    {
        return Database::count('transactions', 'customer_id = ?', [$id]) > 0;
    }
    
    /**
     * Get customer with transaction count
     */
    public static function withTransactionCount(int $id): ?array
    {
        return Database::fetch(
            "SELECT c.*, COUNT(t.id) as transaction_count 
             FROM customers c 
             LEFT JOIN transactions t ON c.id = t.customer_id 
             WHERE c.id = ? 
             GROUP BY c.id",
            [$id]
        );
    }
}

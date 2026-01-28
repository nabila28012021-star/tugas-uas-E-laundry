<?php
/**
 * Package Model
 */

declare(strict_types=1);

class Package
{
    /**
     * Find package by ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetch(
            "SELECT * FROM packages WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Get all packages
     */
    public static function all(): array
    {
        return Database::fetchAll(
            "SELECT * FROM packages ORDER BY name ASC"
        );
    }
    
    /**
     * Get active packages only
     */
    public static function active(): array
    {
        return Database::fetchAll(
            "SELECT * FROM packages WHERE is_active = 1 ORDER BY name ASC"
        );
    }
    
    /**
     * Get packages by type
     */
    public static function byType(string $type): array
    {
        return Database::fetchAll(
            "SELECT * FROM packages WHERE type = ? AND is_active = 1 ORDER BY name ASC",
            [$type]
        );
    }
    
    /**
     * Create new package
     */
    public static function create(array $data): int
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return Database::insert('packages', $data);
    }
    
    /**
     * Update package
     */
    public static function update(int $id, array $data): int
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return Database::update('packages', $data, 'id = ?', [$id]);
    }
    
    /**
     * Delete package
     */
    public static function delete(int $id): int
    {
        return Database::delete('packages', 'id = ?', [$id]);
    }
    
    /**
     * Toggle active status
     */
    public static function toggleActive(int $id): int
    {
        return Database::query(
            "UPDATE packages SET is_active = NOT is_active, updated_at = NOW() WHERE id = ?",
            [$id]
        )->rowCount();
    }
    
    /**
     * Count packages
     */
    public static function count(): int
    {
        return Database::count('packages');
    }
    
    /**
     * Check if package is used in transactions
     */
    public static function hasTransactions(int $id): bool
    {
        return Database::count('transaction_items', 'package_id = ?', [$id]) > 0;
    }
    
    /**
     * Format price for display
     */
    public static function formatPrice(float $price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
    
    /**
     * Get type label
     */
    public static function getTypeLabel(string $type): string
    {
        return match($type) {
            'kg' => 'Per Kg',
            'satuan' => 'Per Satuan',
            default => $type
        };
    }
}

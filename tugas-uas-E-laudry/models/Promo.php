<?php
/**
 * Promo Model
 */

declare(strict_types=1);

class Promo
{
    /**
     * Find promo by ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetch(
            "SELECT * FROM promos WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Find promo by code
     */
    public static function findByCode(string $code): ?array
    {
        return Database::fetch(
            "SELECT * FROM promos WHERE code = ? AND is_active = 1",
            [strtoupper($code)]
        );
    }
    
    /**
     * Get all promos
     */
    public static function all(): array
    {
        return Database::fetchAll(
            "SELECT * FROM promos ORDER BY created_at DESC"
        );
    }
    
    /**
     * Get active and valid promos
     */
    public static function active(): array
    {
        return Database::fetchAll(
            "SELECT * FROM promos 
             WHERE is_active = 1 
             AND valid_from <= CURDATE() 
             AND valid_until >= CURDATE() 
             ORDER BY name ASC"
        );
    }
    
    /**
     * Create new promo
     */
    public static function create(array $data): int
    {
        $data['code'] = strtoupper($data['code']);
        $data['created_at'] = date('Y-m-d H:i:s');
        return Database::insert('promos', $data);
    }
    
    /**
     * Update promo
     */
    public static function update(int $id, array $data): int
    {
        if (isset($data['code'])) {
            $data['code'] = strtoupper($data['code']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        return Database::update('promos', $data, 'id = ?', [$id]);
    }
    
    /**
     * Delete promo
     */
    public static function delete(int $id): int
    {
        return Database::delete('promos', 'id = ?', [$id]);
    }
    
    /**
     * Toggle active status
     */
    public static function toggleActive(int $id): int
    {
        return Database::query(
            "UPDATE promos SET is_active = NOT is_active, updated_at = NOW() WHERE id = ?",
            [$id]
        )->rowCount();
    }
    
    /**
     * Validate promo code
     */
    public static function validate(string $code, float $subtotal): array
    {
        $promo = self::findByCode($code);
        
        if (!$promo) {
            return ['valid' => false, 'message' => 'Kode promo tidak ditemukan'];
        }
        
        $today = date('Y-m-d');
        if ($today < $promo['valid_from'] || $today > $promo['valid_until']) {
            return ['valid' => false, 'message' => 'Kode promo sudah kadaluarsa'];
        }
        
        if ($subtotal < $promo['min_purchase']) {
            return [
                'valid' => false, 
                'message' => 'Minimum pembelian Rp ' . number_format($promo['min_purchase'], 0, ',', '.')
            ];
        }
        
        return ['valid' => true, 'promo' => $promo];
    }
    
    /**
     * Calculate discount
     */
    public static function calculateDiscount(array $promo, float $subtotal): float
    {
        if ($promo['discount_type'] === 'percent') {
            $discount = $subtotal * ($promo['discount_value'] / 100);
            if ($promo['max_discount'] && $discount > $promo['max_discount']) {
                $discount = $promo['max_discount'];
            }
        } else {
            $discount = $promo['discount_value'];
        }
        
        return min($discount, $subtotal);
    }
    
    /**
     * Check if code exists
     */
    public static function codeExists(string $code, ?int $exceptId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM promos WHERE code = ?";
        $params = [strtoupper($code)];
        
        if ($exceptId) {
            $sql .= " AND id != ?";
            $params[] = $exceptId;
        }
        
        $result = Database::fetch($sql, $params);
        return (int) $result['count'] > 0;
    }
    
    /**
     * Count promos
     */
    public static function count(): int
    {
        return Database::count('promos');
    }
}

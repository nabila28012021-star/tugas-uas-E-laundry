<?php
/**
 * User Model
 */

declare(strict_types=1);

class User
{
    /**
     * Find user by ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetch(
            "SELECT * FROM users WHERE id = ?",
            [$id]
        );
    }
    
    /**
     * Find user by username
     */
    public static function findByUsername(string $username): ?array
    {
        return Database::fetch(
            "SELECT * FROM users WHERE username = ?",
            [$username]
        );
    }
    
    /**
     * Authenticate user
     */
    public static function authenticate(string $username, string $password): ?array
    {
        $user = self::findByUsername($username);
        
        if ($user && password_verify($password, $user['password']) && $user['is_active']) {
            return $user;
        }
        
        return null;
    }
    
    /**
     * Get all users
     */
    public static function all(): array
    {
        return Database::fetchAll(
            "SELECT * FROM users ORDER BY name ASC"
        );
    }
    
    /**
     * Get all users except current
     */
    public static function allExcept(int $exceptId): array
    {
        return Database::fetchAll(
            "SELECT * FROM users WHERE id != ? ORDER BY name ASC",
            [$exceptId]
        );
    }
    
    /**
     * Create new user
     */
    public static function create(array $data): int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return Database::insert('users', $data);
    }
    
    /**
     * Update user
     */
    public static function update(int $id, array $data): int
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return Database::update('users', $data, 'id = ?', [$id]);
    }
    
    /**
     * Delete user
     */
    public static function delete(int $id): int
    {
        return Database::delete('users', 'id = ?', [$id]);
    }
    
    /**
     * Check if username exists
     */
    public static function usernameExists(string $username, ?int $exceptId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE username = ?";
        $params = [$username];
        
        if ($exceptId) {
            $sql .= " AND id != ?";
            $params[] = $exceptId;
        }
        
        $result = Database::fetch($sql, $params);
        return (int) $result['count'] > 0;
    }
    
    /**
     * Count users
     */
    public static function count(): int
    {
        return Database::count('users');
    }
}

<?php
/**
 * Session Management Class
 */

declare(strict_types=1);

class Session
{
    /**
     * Set session value
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Check if session key exists
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
    
    /**
     * Destroy all session data
     */
    public static function destroy(): void
    {
        session_unset();
        session_destroy();
    }
    
    /**
     * Set flash message
     */
    public static function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }
    
    /**
     * Get and clear flash message
     */
    public static function getFlash(string $type): ?string
    {
        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    
    /**
     * Get all flash messages and clear them
     */
    public static function getAllFlash(): array
    {
        $messages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $messages;
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Get current user ID
     */
    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Get current user role
     */
    public static function userRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Check if current user is admin
     */
    public static function isAdmin(): bool
    {
        return self::userRole() === 'admin';
    }
    
    /**
     * Set user session after login
     */
    public static function login(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
    }
    
    /**
     * Clear user session on logout
     */
    public static function logout(): void
    {
        self::destroy();
    }
}

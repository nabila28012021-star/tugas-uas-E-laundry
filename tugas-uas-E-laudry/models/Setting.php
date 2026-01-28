<?php
/**
 * Setting Model
 */

declare(strict_types=1);

class Setting
{
    private static array $cache = [];
    
    /**
     * Get setting value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }
        
        $result = Database::fetch(
            "SELECT value FROM settings WHERE key_name = ?",
            [$key]
        );
        
        $value = $result ? $result['value'] : $default;
        self::$cache[$key] = $value;
        
        return $value;
    }
    
    /**
     * Set setting value
     */
    public static function set(string $key, mixed $value): void
    {
        $exists = Database::fetch(
            "SELECT id FROM settings WHERE key_name = ?",
            [$key]
        );
        
        if ($exists) {
            Database::update('settings', ['value' => $value], 'key_name = ?', [$key]);
        } else {
            Database::insert('settings', [
                'key_name' => $key,
                'value' => $value,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        self::$cache[$key] = $value;
    }
    
    /**
     * Get all settings
     */
    public static function all(): array
    {
        $results = Database::fetchAll("SELECT * FROM settings ORDER BY key_name ASC");
        $settings = [];
        
        foreach ($results as $row) {
            $settings[$row['key_name']] = $row['value'];
            self::$cache[$row['key_name']] = $row['value'];
        }
        
        return $settings;
    }
    
    /**
     * Get app name
     */
    public static function appName(): string
    {
        return self::get('app_name', 'Laundry Tunas Bangsa');
    }
    
    /**
     * Get company name
     */
    public static function companyName(): string
    {
        return self::get('company_name', 'Laundry Express');
    }
    
    /**
     * Get company address
     */
    public static function companyAddress(): string
    {
        return self::get('company_address', '');
    }
    
    /**
     * Get company phone
     */
    public static function companyPhone(): string
    {
        return self::get('company_phone', '');
    }
    
    /**
     * Get estimation days
     */
    public static function estimationDays(): int
    {
        return (int) self::get('estimation_days', 2);
    }
}

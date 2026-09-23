<?php

declare(strict_types=1);

namespace App\Support;

/**
 * MasterMenu — Single source of truth for all navigable menu items.
 *
 * Used by:
 *  - UserGroup management (checklist UI)
 *  - Dashboard popup menu (filtered by user's allowed_menus)
 *  - Middleware (route access check)
 */
final class MasterMenu
{
    /**
     * All available menu items in the application.
     *
     * @return array<string, array{icon: string, label: string, description: string, route: string}>
     */
    public static function all(): array
    {
        return [
            'dashboard'    => ['icon' => '🏠', 'label' => 'Dashboard',       'description' => 'Halaman utama & ringkasan',        'route' => 'dashboard'],
            'menu.index'   => ['icon' => '🍜', 'label' => 'Kelola Menu',     'description' => 'Lihat & kelola daftar menu',       'route' => 'menu.index'],
            'menu.create'  => ['icon' => '➕', 'label' => 'Tambah Menu',     'description' => 'Buat item menu baru',              'route' => 'menu.create'],
            'categories'   => ['icon' => '📦', 'label' => 'Kategori',        'description' => 'Organisir menu per kategori',      'route' => 'categories.index'],
            'media.upload' => ['icon' => '🖼️', 'label' => 'Upload Media',    'description' => 'Foto & gambar untuk menu',         'route' => '#'],
            'reports'      => ['icon' => '📊', 'label' => 'Analitik',        'description' => 'Statistik & grafik performa',      'route' => '#'],
            'orders'       => ['icon' => '🧾', 'label' => 'Pesanan',         'description' => 'Riwayat transaksi pesanan',        'route' => '#'],
            'groups.index' => ['icon' => '👥', 'label' => 'Kelola Group',    'description' => 'Atur group & akses user',          'route' => 'groups.index'],
            'settings'     => ['icon' => '⚙️', 'label' => 'Pengaturan',      'description' => 'Konfigurasi aplikasi',             'route' => '#'],
            'menu.share'   => ['icon' => '🔗', 'label' => 'Bagikan Menu',    'description' => 'Link publik untuk pelanggan',      'route' => '#'],
        ];
    }

    /**
     * Get a single menu item definition by key.
     */
    public static function get(string $key): ?array
    {
        return static::all()[$key] ?? null;
    }

    /**
     * Filter master menu by an array of allowed keys.
     * If $allowedKeys is null → return all (no restriction).
     *
     * @param  array<string>|null $allowedKeys
     * @return array<string, array{icon: string, label: string, description: string, route: string}>
     */
    public static function filter(?array $allowedKeys): array
    {
        if ($allowedKeys === null) {
            return static::all();
        }

        return array_filter(
            static::all(),
            fn ($key) => in_array($key, $allowedKeys, true),
            ARRAY_FILTER_USE_KEY,
        );
    }
}

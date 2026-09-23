<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Default Menu Categories ──────────────────────────
        $categories = [
            ['name' => 'Makanan',  'icon' => '🍜', 'sort_order' => 1],
            ['name' => 'Minuman',  'icon' => '🥤', 'sort_order' => 2],
            ['name' => 'Dessert',  'icon' => '🍰', 'sort_order' => 3],
            ['name' => 'Snack',    'icon' => '🍿', 'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            MenuCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'icon' => $cat['icon'], 'sort_order' => $cat['sort_order']],
            );
        }

        // ── Default User Groups ──────────────────────────────
        $groups = [
            [
                'name'          => 'Admin',
                'description'   => 'Akses penuh ke semua fitur',
                'allowed_menus' => [
                    'dashboard','menu.index','menu.create','categories',
                    'media.upload','reports','orders','groups.index','settings','menu.share',
                ],
            ],
            [
                'name'          => 'Manager',
                'description'   => 'Kelola menu dan laporan',
                'allowed_menus' => [
                    'dashboard','menu.index','menu.create','categories','media.upload','reports','orders',
                ],
            ],
            [
                'name'          => 'Staff',
                'description'   => 'Hanya lihat menu',
                'allowed_menus' => ['dashboard','menu.index'],
            ],
        ];

        foreach ($groups as $group) {
            UserGroup::firstOrCreate(
                ['name' => $group['name']],
                ['description' => $group['description'], 'allowed_menus' => $group['allowed_menus']],
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_category_id', 'name', 'description',
        'price', 'image_path', 'is_available', 'sort_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    /** Format harga ke Rupiah */
    public function formattedPrice(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }
}

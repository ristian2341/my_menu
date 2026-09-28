<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * UserMenu — Master data menu navigasi user.
 *
 * @property int         $id
 * @property string      $code_menu
 * @property string      $nama
 * @property int|null    $parent_id
 * @property bool        $is_header
 * @property string|null $url
 * @property bool        $can_create
 * @property bool        $can_update
 * @property bool        $can_delete
 * @property bool        $can_view
 * @property bool        $is_active
 * @property int         $sort_order
 * @property string|null $icon
 */
class UserMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code_menu',
        'nama',
        'parent_id',
        'is_header',
        'url',
        'can_create',
        'can_update',
        'can_delete',
        'can_view',
        'is_active',
        'sort_order',
        'icon',
    ];

    protected $casts = [
        'is_header'  => 'boolean',
        'can_create' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
        'can_view'   => 'boolean',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    // ── Relasi ──────────────────────────────────────────────

    /** Menu induk */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(UserMenu::class, 'parent_id');
    }

    /** Menu anak (sub-menu) */
    public function children(): HasMany
    {
        return $this->hasMany(UserMenu::class, 'parent_id')->orderBy('sort_order');
    }

    /** Sub-menu aktif */
    public function activeChildren(): HasMany
    {
        return $this->hasMany(UserMenu::class, 'parent_id')
                    ->where('is_active', true)
                    ->orderBy('sort_order');
    }

    // ── Scopes ──────────────────────────────────────────────

    /** Hanya menu aktif */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** Hanya root menu (tidak punya parent) */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /** Hanya menu yang bukan header */
    public function scopeNotHeader(Builder $query): Builder
    {
        return $query->where('is_header', false);
    }

    // ── Helpers ─────────────────────────────────────────────

    /** Apakah ini menu root (tanpa parent) */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /** Label status untuk tampilan */
    public function statusLabel(): string
    {
        return $this->is_active ? 'Aktif' : 'Non-Aktif';
    }

    /** Badge class CSS berdasarkan status */
    public function statusBadgeClass(): string
    {
        return $this->is_active ? 'badge-active' : 'badge-inactive';
    }
}

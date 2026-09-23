<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserGroup extends Model
{
    protected $fillable = ['name', 'description', 'allowed_menus'];

    protected $casts = ['allowed_menus' => 'array'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_group_user');
    }

    /**
     * Check if this group allows access to a specific menu key.
     */
    public function allows(string $menuKey): bool
    {
        return in_array($menuKey, $this->allowed_menus ?? [], true);
    }
}

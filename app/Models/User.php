<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** User belongs to many UserGroups */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'user_group_user');
    }

    /**
     * Get all allowed menu keys across all groups the user belongs to.
     * Returns null (= all menus allowed) if user has no groups assigned.
     *
     * @return array<string>|null
     */
    public function allowedMenus(): ?array
    {
        $groups = $this->groups()->get();

        if ($groups->isEmpty()) {
            return null; // No restriction — show all menus
        }

        return $groups
            ->pluck('allowed_menus')
            ->flatten()
            ->unique()
            ->values()
            ->all();
    }

    /** Check if user can access a specific menu key */
    public function canAccessMenu(string $menuKey): bool
    {
        $allowed = $this->allowedMenus();

        return $allowed === null || in_array($menuKey, $allowed, true);
    }
}


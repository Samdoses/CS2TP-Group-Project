<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'FirstName',
        'LastName',
        'email',
        'admin_username',
        'admin_password',
        'is_head_admin',
    ];

    protected $hidden = [
        'admin_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_head_admin' => 'boolean',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->admin_password;
    }

    public function activities(): HasMany
    {
        return $this->hasMany(AdminActivity::class, 'admin_id', 'admin_id');
    }

    public function targetedActivities(): HasMany
    {
        return $this->hasMany(AdminActivity::class, 'target_admin_id', 'admin_id');
    }

    public function latestActivity(): HasOne
    {
        return $this->hasOne(AdminActivity::class, 'admin_id', 'admin_id')->latestOfMany();
    }

    public function isHeadAdmin(): bool
    {
        return (bool) $this->is_head_admin;
    }
}

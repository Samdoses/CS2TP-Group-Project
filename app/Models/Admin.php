<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'email',
        'admin_username',
        'admin_password',
    ];

    protected $hidden = [
        'admin_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->admin_password;
    }
}

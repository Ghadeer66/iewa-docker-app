<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

     /**
     * Guard name used by Spatie Permission.
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'personal_code',
        'position',
        'password',
        'business_name',
        'business_type',
        'business_phone',
        'business_address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Check if user is a business
    public function isBusiness()
    {
        return $this->hasRole('business');
    }

    // Check if user is an admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Check if user is a client
    public function isClient()
    {
        return $this->hasRole('client');
    }
}

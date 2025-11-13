<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'business_address',
        'belongs_to'
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

    /**
     * If this user belongs to a business (i.e. is a client),
     * return the parent business user.
     */
    public function parentBusiness()
    {
        return $this->belongsTo(self::class, 'belongs_to');
    }

    /**
     * If this user is a business, return its client users.
     */
    public function clients()
    {
        return $this->hasMany(self::class, 'belongs_to');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function parent_business()
    {
        // assuming 'belongs_to' stores the business user ID
        return $this->belongsTo(User::class, 'belongs_to');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function purchaseCredit()
    {
        return $this->hasOne(ClientPurchaseCredit::class);
    }

    public function subsidy()
    {
        return $this->hasOne(ClientSubsidy::class);
    }
}

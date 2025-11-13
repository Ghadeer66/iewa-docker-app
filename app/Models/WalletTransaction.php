<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = ['wallet_id', 'type', 'amount', 'description','to_wallet_id'];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiverWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}

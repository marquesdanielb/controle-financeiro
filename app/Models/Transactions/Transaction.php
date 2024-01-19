<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Transactions\Wallet;

class Transaction extends Model
{
    public $incrementing = false;

    protected $table = "wallets_transactions";

    protected $fillable = [
        'id', 'payee_id', 'payer_id', 'amount'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}

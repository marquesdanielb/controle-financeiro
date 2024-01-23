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
        'id',
        'payee_wallet_id',
        'payer_wallet_id',
        'amount'
    ];

    public function walletPayer(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payer_wallet_id');
    }

    public function walletPayee(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'payee_wallet_id');
    }
}

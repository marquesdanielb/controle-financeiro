<?php

namespace App\Events;

use App\Models\Transactions\Transaction;

class SendNotification extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public Transaction $transaction,
    ) {}
}

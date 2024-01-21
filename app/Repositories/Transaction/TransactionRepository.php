<?php

namespace App\Repositories\Transaction;

use App\Exceptions\NotEnoughMoney;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use PHPUnit\Framework\InvalidDataProviderException;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TransactionDeniedException;

class TransactionRepository
{
    public function handle(array $data): array
    {
        if (!$this->guardCanTransfer()) {
            throw new TransactionDeniedException("Retailer is not authorized to make transactions", 401);
        }

        $model = $this->getProvider($data['provider']);

        $user = $model->findOrFail($data['payee_id']);

        if (!$this->checkUserBalance($user, $data['amount'])) {
            throw new NotEnoughMoney("There is not enough money for this transaction", 422);
        }

        // $user->wallet->transaction()->create([

        // ]);

        return [];
    }

    public function guardCanTransfer(): bool
    {
        if (Auth::guard('users')->check()) {
            return true;
        } else if (Auth::guard('retailer')->check()) {
            return false;
        } else {
            throw new InvalidDataProviderException("Provider Not found");
        }
    }

    public function getProvider(string $provider): AuthenticatableContract
    {
        if ($provider == "user") {
            return new User();
        } else if ($provider == "retailer") {
            return new Retailer();
        } else {
            throw new InvalidDataProviderException("Provider not found");
        }
    }

    private function checkUserBalance($user, $money): bool
    {
        return $user->wallet->balance >= $money;
    }
}

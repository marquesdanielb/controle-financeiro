<?php

namespace App\Repositories\Transaction;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use PHPUnit\Framework\InvalidDataProviderException;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public function handle(array $data): array
    {
        if (!$this->guardCanTransfer()) {
            throw new \Exception("Retailer is not authorized to make transactions", 401);
        }

        $model = $this->getProvider($data['provider']);

        $user = $model->findOrFail($data['payee_id']);

        $user->wallet->transaction()->create([

        ]);

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
}

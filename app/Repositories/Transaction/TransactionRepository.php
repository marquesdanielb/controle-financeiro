<?php

namespace App\Repositories\Transaction;

use App\Exceptions\NotEnoughMoney;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use PHPUnit\Framework\InvalidDataProviderException;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TransactionDeniedException;
use App\Models\Transactions\Transaction;
use App\Models\Transactions\Wallet;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TransactionRepository
{
    public function handle(array $data): Transaction
    {
        if (!$this->guardCanTransfer()) {
            throw new TransactionDeniedException('Retailer is not authorized to make transactions', 401);
        }

        if (!$payee = $this->retrivePayee($data)) {
            throw new InvalidDataProviderException('Provider Not found');
        }

        $myWallet = Auth::guard($data['provider'])->user()->wallet;
        if (!$this->checkUserBalance($myWallet, $data['amount'])) {
            throw new NotEnoughMoney('There is not enough money for this transaction', 422);
        }

        return $this->makeTransaction($payee, $data);
    }

    private function guardCanTransfer(): bool
    {
        if (Auth::guard('users')->check()) {
            return true;
        } else if (Auth::guard('retailers')->check()) {
            return false;
        } else {
            throw new InvalidDataProviderException("Provider Not found");
        }
    }

    private function getProvider(string $provider): AuthenticatableContract
    {
        if ($provider == 'users') {
            return new User();
        } else if ($provider == 'retailer') {
            return new Retailer();
        } else {
            throw new InvalidDataProviderException('Provider not found');
        }
    }

    private function checkUserBalance(Wallet $wallet, $money): bool
    {
        return $wallet->balance >= $money;
    }

    private function makeTransaction($payee, array $data)
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'payer_wallet_id' => Auth::guard($data['provider'])->user()->wallet->id,
            'payee_wallet_id' => $payee->wallet->id,
            'amount' => $data['amount']
        ];

        return DB::transaction(function () use ($payload) {
            $transaction = Transaction::create($payload);

            $transaction->walletPayer->withdraw($payload['amount']);
            $transaction->walletPayee->deposit($payload['amount']);

            return $transaction;
        });
    }

    /**
     * Both functions should trigger an exception
     * when something goes bad
     *
     * @param array $data
     * @return void
     */
    private function retrivePayee(array $data)
    {
        try {
            $model = $this->getProvider($data['provider']);
            return $model->findOrFail($data['payee_id']);
        } catch (InvalidDataProviderException | \Exception $e) {
            return false;
        }
    }
}

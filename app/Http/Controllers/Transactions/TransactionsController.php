<?php

namespace App\Http\Controllers\Transactions;

use App\Exceptions\IdleServiceException;
use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\InvalidDataProviderException;
use App\Exceptions\TransactionDeniedException;
use App\Exceptions\NotEnoughMoney;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    public function __construct(
        private TransactionRepository $repository
    ){}


    public function postTransaction(Request $request)
    {
        $this->validate($request, [
            "provider"=> "required|in:users,retailers",
            "payee_id"=> "required",
            "amount"=> "required|numeric",
        ]);

        $fields = $request->only(["provider", "payee_id", "amount"]);

        try {
            $result = $this->repository->handle($fields);
            return response()->json($result);
        } catch (InvalidDataProviderException | NotEnoughMoney $exception) {
        return response()->json(['errors' => ['main' => $exception->getMessage()]], 422);
        } catch (TransactionDeniedException | IdleServiceException $exception) {
            return response()->json(['errors'=> ['main'=> $exception->getMessage()]], 401);
        } catch (\Exception $exception) {
            Log::critical('[Transaction goes bad, please contact your manager]', [
                'message' => $exception->getMessage()
            ]);
        }
    }
}

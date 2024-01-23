<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\InvalidDataProviderException;
use App\Exceptions\TransactionDeniedException;
use App\Exceptions\NotEnoughMoney;

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
        } catch (TransactionDeniedException $exception) {
            return response()->json(['errors'=> ['main'=> $exception->getMessage()]], 401);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}

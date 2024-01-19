<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\InvalidDataProviderException;

class TransactionsController extends Controller
{
    public function __construct(
        private TransactionRepository $repository
    ){}


    public function postTransaction(Request $request)
    {
        $this->validate($request, [
            "provider"=> "required|in:user,retailer",
            "payee_id"=> "required",
            "amount"=> "required|numeric",
        ]);

        $fields = $request->only(["provider", "payee_id", "amount"]);

        try {
            $result = $this->repository->handle($fields);
        } catch (InvalidDataProviderException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], 422);
        } catch (\Exception $exception) {
            return response()->json(['errors'=> ['main'=> $exception->getMessage()]], 401);
        }

        return response()->json($result);
    }
}

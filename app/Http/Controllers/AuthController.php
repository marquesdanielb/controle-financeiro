<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticable as AuthenticableContract;
use PHPUnit\Framework\InvalidDataProviderException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthRepository $repository
    ) {}

    public function postAuthenticate(Request $request, string $provider)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $fields = $request->only(['email', 'password']);

        try {
            $result = $this->repository->authenticate($provider, $fields);
            return response()->json($result);
        } catch (InvalidDataProviderException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], 422);
        } catch (AuthorizationException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], 401);
        }
    }
}

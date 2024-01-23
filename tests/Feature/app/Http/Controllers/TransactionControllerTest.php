<?php

namespace Feature\app\Http\Controllers;

use App\Models\Retailer;
use Laravel\Lumen\Testing\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Models\User;

class TransactionControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function createApplication()
    {
        return require './bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUserShouldBeExistingOnProviderToTransfer()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'provider' => 'users',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(422);
    }

    public function testUserShouldNotSendWrongProvider()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'provider' => 'badprovider',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'users')
            ->post(route('postTransaction'), $payload);

            $request->assertResponseStatus(422);
    }

    public function testUserShouldBeAValidUserToTransfer()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'provider' => 'users',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(422);
    }

    public function testRetailerShouldNotTransfer()
    {
        $this->artisan('passport:install');
        $user = Retailer::factory()->create();
        $payload = [
            'provider' => 'users',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'retailers')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(401);
    }

    public function testUserShouldHaveMoneyToPerformSomeTransaction()
    {
        $this->artisan('passport:install');
        $userPayer = User::factory()->create();
        $userPayed = User::factory()->create();
        $payload = [
            'provider' => 'users',
            'payee_id' => $userPayed->id,
            'amount' => 500
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(422);
    }

    public function testUserCanTransferMoney()
    {
        $this->artisan('passport:install');
        $userPayer = User::factory()->create();
        $userPayer->wallet->deposit(1000);
        $userPayed = User::factory()->create();

        $payload = [
            'provider' => 'users',
            'payee_id' => $userPayed->id,
            'amount' => 500
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(200);
        $request->seeInDatabase('wallets', [
            'id' => $userPayer->wallet->id,
            'balance' => 500
        ]);
        $request->seeInDatabase('wallets', [
            'id' => $userPayed->wallet->id,
            'balance' => 500
        ]);
    }
}

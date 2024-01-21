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
            'provider' => 'user',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(404);
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
            'provider' => 'user',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(404);
    }

    public function testRetailerShouldNotTransfer()
    {
        $this->artisan('passport:install');
        $user = Retailer::factory()->create();
        $payload = [
            'provider' => 'user',
            'payee_id' => 'chegueiaquichefe',
            'amount' => 500
        ];

        $request = $this->actingAs($user, 'retailer')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(401);
    }

    public function testUserShouldHaveMoneyToPerformSomeTransaction()
    {
        $this->artisan('passport:install');
        $userPayer = User::factory()->create();
        $userPayed = User::factory()->create();
        $payload = [
            'provider' => 'user',
            'payee_id' => $userPayed->id,
            'amount' => 500
        ];

        $request = $this->actingAs($userPayer, 'users')
            ->post(route('postTransaction'), $payload);

        $request->assertResponseStatus(422);
    }
}

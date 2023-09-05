<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    private $userRoute = '/api/user/';
    private $headers = [
        'accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install', ['--no-interaction' => true,]);
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_get_all_user_logged_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $this->get($this->userRoute, $this->headers)->assertStatus(200);
    }

    public function test_get_all_user_logged_data_out(): void
    {
        $this->get($this->userRoute, $this->headers)->assertStatus(401);
    }

    public function test_create_user_success(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'name' => 'teste name',
            'email' => 'teste@teste.com',
            'password' => '12345678',
        ];

        $this->postJson($this->userRoute, $data, $this->headers)->assertStatus(200);
    }

    public function test_create_user_invalid_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'name' => 'teste name',
            'email' => 'teste@teste.com',
            'password' => '123',
        ];

        $this->postJson($this->userRoute, $data, $this->headers)->assertStatus(422);
    }

    public function test_create_user_unauthenticated_user_failed(): void
    {
        $data = [
            'name' => 'teste name',
            'email' => 'teste@teste.com',
            'password' => '12345678',
        ];

        $this->postJson($this->userRoute, $data, $this->headers)->assertStatus(401);
    }

    public function test_update_user_success(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'name' => 'teste name',
            'email' => 'teste2@teste.com',
            'password' => '1234587854',
        ];

        $this->putJson($this->userRoute . User::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(200);
    }

    public function test_update_user_invalid_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'email' => 'teste2@teste.com',
            'password' => '1234587854',
        ];

        $this->putJson($this->userRoute . User::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(422);
    }

    public function test_update_user_unauthenticated_user_failed(): void
    {
        $data = [
            'name' => 'teste name',
            'email' => 'teste2@teste.com',
            'password' => '1234587854',
        ];

        $this->putJson($this->userRoute . User::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(401);
    }

    public function test_update_user_nonexistent_failed(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'name' => 'teste name',
            'email' => 'teste2@teste.com',
            'password' => '1234587854',
        ];

        $this->putJson($this->userRoute . (User::orderBy('id', 'desc')->first()->id + 1), $data, $this->headers)->assertStatus(404);
    }

    public function test_delete_user_success(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $this->deleteJson($this->userRoute . User::orderBy('id', 'desc')->first()->id, [], $this->headers)->assertStatus(200);
    }

    public function test_delete_user_unauthenticated_user_failed(): void
    {
        $this->deleteJson($this->userRoute . User::orderBy('id', 'desc')->first()->id, [], $this->headers)->assertStatus(401);
    }

    public function test_delete_user_nonexistent_failed(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $this->deleteJson($this->userRoute . (User::orderBy('id', 'desc')->first()->id + 1), [], $this->headers)->assertStatus(404);
    }

}

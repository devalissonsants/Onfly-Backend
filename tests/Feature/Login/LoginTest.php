<?php

namespace Tests\Feature\Login;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    private $loginRoute = 'api/auth/login';
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

    public function test_authentication_success(): void
    {
        $credentials = DB::table('oauth_clients')->orderBy('id', 'desc')->first();
        $data = [
            'grant_type' => 'password',
            'username' => 'suporte@gmail.com',
            'password' => '12345678',
            'client_id' => $credentials->id,
            'client_secret' => $credentials->secret,
            'scope' => ''
        ];

        $this->postJson($this->loginRoute, $data, $this->headers)->assertStatus(200);
    }

    public function test_authentication_failed(): void
    {
        $credentials = DB::table('oauth_clients')->orderBy('id', 'desc')->first();
        $data = [
            'grant_type' => 'password',
            'username' => 'fake@gmail.com',
            'password' => '12345678',
            'client_id' => $credentials->id,
            'client_secret' => $credentials->secret,
            'scope' => ''
        ];

        $this->postJson($this->loginRoute, $data, $this->headers)->assertStatus(422);
    }

    public function test_authentication_send_invalid_data(): void
    {
        $credentials = DB::table('oauth_clients')->orderBy('id', 'desc')->first();
        $data = [
            'grant_type' => 'password',
            'username' => 'fake@gmail.com',
            'password' => '12345678',
            'client_id' => $credentials->id,
            'client_secret' => $credentials->secret,
            'scope' => ''
        ];

        $this->postJson($this->loginRoute, $data, $this->headers)->assertStatus(422);
    }
}

<?php

namespace Tests\Feature\Outlay;

use App\Models\Outlay;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Laravel\Passport\Passport;

class OutlayTest extends TestCase
{
    use RefreshDatabase, WithFaker, DatabaseMigrations;

    private $outlayRoute = '/api/outlay/';
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

    public function test_get_all_outlay_logged_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $this->get($this->outlayRoute, $this->headers)->assertStatus(200);
    }

    public function test_get_all_outlay_logged_data_out(): void
    {
        $this->get($this->outlayRoute, $this->headers)->assertStatus(401);
    }

    public function test_create_outlay_success(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'description' => 'Descrição',
            'outlay_date' => now()->format('Y-m-d'),
            'amount' => 1,
            'user_id' => User::orderBy('id', 'desc')->first()->id,
        ];

        $this->postJson($this->outlayRoute, $data, $this->headers)->assertStatus(200);
    }

    public function test_create_outlay_invalid_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'outlay_date' => date('Y-m-d', strtotime('+1 days')),
            'amount' => -1,
            'user_id' => null,
        ];

        $this->postJson($this->outlayRoute, $data, $this->headers)->assertStatus(422);
    }

    public function test_create_outlay_unauthenticated_user_failed(): void
    {
        $data = [
            'description' => 'Descrição',
            'outlay_date' => now()->format('Y-m-d'),
            'amount' => 1,
            'user_id' => User::orderBy('id', 'desc')->first()->id,
        ];

        $this->postJson($this->outlayRoute, $data, $this->headers)->assertStatus(401);
    }

    public function test_update_outlay_success(): void
    {
        Passport::actingAs(
            User::orderBy('id', 'asc')->first(),
            ['create-servers']
        );

        $data = [
            'description' => 'Descrição 2',
            'outlay_date' => now()->format('Y-m-d'),
            'amount' => 2,
            'user_id' => User::orderBy('id', 'asc')->first()->id,
        ];

        $this->putJson($this->outlayRoute . Outlay::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(200);
    }

    public function test_update_outlay_invalid_data(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'outlay_date' => date('Y-m-d', strtotime('+1 days')),
            'amount' => -1,
            'user_id' => null,
        ];

        $this->putJson($this->outlayRoute . Outlay::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(422);
    }

    public function test_update_outlay_unauthenticated_user_failed(): void
    {
        $data = [
            'description' => 'Descrição',
            'outlay_date' => now()->format('Y-m-d'),
            'amount' => 1,
            'user_id' => User::orderBy('id', 'desc')->first()->id,
        ];

        $this->putJson($this->outlayRoute . Outlay::orderBy('id', 'desc')->first()->id, $data, $this->headers)->assertStatus(401);
    }

    public function test_update_outlay_nonexistent_failed(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $data = [
            'description' => 'Descrição',
            'outlay_date' => now()->format('Y-m-d'),
            'amount' => 1,
            'user_id' => User::orderBy('id', 'desc')->first()->id,
        ];

        $this->putJson($this->outlayRoute . (Outlay::orderBy('id', 'desc')->first()->id + 1), $data, $this->headers)->assertStatus(404);
    }

    public function test_delete_outlay_success(): void
    {
        Passport::actingAs(
            User::orderBy('id', 'asc')->first(),
            ['create-servers']
        );

        $this->deleteJson($this->outlayRoute . Outlay::orderBy('id', 'desc')->first()->id, [], $this->headers)->assertStatus(200);
    }

    public function test_delete_outlay_unauthenticated_user_failed(): void
    {
        $this->deleteJson($this->outlayRoute . Outlay::orderBy('id', 'desc')->first()->id, [], $this->headers)->assertStatus(401);
    }

    public function test_delete_outlay_nonexistent_failed(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $this->deleteJson($this->outlayRoute . (Outlay::orderBy('id', 'desc')->first()->id + 1), [], $this->headers)->assertStatus(404);
    }

}

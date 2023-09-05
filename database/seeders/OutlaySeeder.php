<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OutlaySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('outlays')->insert([
            'outlay_date' => now()->format('Y-m-d'),
            'description' => 'description',
            'amount' => 1,
            'user_id' => User::orderBy('id', 'desc')->first()->id,
        ]);
    }
}

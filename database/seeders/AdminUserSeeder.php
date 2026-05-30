<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@suzuki.com',
        ], [
            'name' => 'Administrator',
            'password' => bcrypt('password'),
            'branch' => 'admin',
            'is_admin' => true,
        ]);
    }
}

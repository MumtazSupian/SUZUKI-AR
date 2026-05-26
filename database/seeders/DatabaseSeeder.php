<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $branches = ['bp', 'cinere', 'jatiasih', 'cianjur', 'ciawi'];

        foreach ($branches as $branch) {
            User::firstOrCreate(
                ['email' => $branch . '@suzuki.com'],
                [
                    'name' => strtoupper($branch) . ' User',
                    'password' => bcrypt('password'),
                    'branch' => $branch,
                ]
            );
        }
    }
}

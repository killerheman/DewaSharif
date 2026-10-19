<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Tester Team', 'email' => 'tester@hostlok.com', 'role' => 'customer', 'phone' => '0000000002'],
        ];

        foreach ($users as $user) {
            \App\Models\User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => \Illuminate\Support\Facades\Hash::make('Host@1'),
                    'role' => $user['role'],
                    'phone' => $user['phone'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@dewa.com'],
            [
                'name'              => 'Super Admin',
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'password'          => Hash::make('Dewa@707'),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
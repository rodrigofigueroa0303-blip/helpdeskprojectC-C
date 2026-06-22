<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cyc.cl'], // se busca por email
            [
                'name' => 'Administrador CYC',
                'password' => Hash::make('password'), // clave: password
                'role' => 'admin',
            ]
        );
    }
}

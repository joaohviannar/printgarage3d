<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@printgarage3d.com.br'],
            [
                'name' => 'Administrador Print Garage',
                'password' => Hash::make('PrintGarage@2026'),
                'perfil' => 'admin',
                'ativo' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}

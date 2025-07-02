<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuario administrador por defecto
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@laravel.com',
            'password' => Hash::make('123456'),
        ]);

        // Crear usuario de prueba
        User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@laravel.com',
            'password' => Hash::make('demo123'),
        ]);
    }
}


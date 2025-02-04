<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'silarac@utn.edu.ec',
            'password' => Hash::make('admin123'), 
        ]);
        $admin->assignRole('admin');

        // Crear usuario normal
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'), 
        ]);
        $user->assignRole('user');

        // Crear usuario Bodeguero
        $bodeguero = User::create([
            'name' => 'Bodeguero User',
            'email' => 'jordanA@example.com',
            'password' => Hash::make('bodega123'),
        ]);
        $bodeguero->assignRole('bodeguero');

        // Crear usuario Vendedor
        $vendedor = User::create([
            'name' => 'Vendedor User',
            'email' => 'vendedor@example.com',
            'password' => Hash::make('vendedor123'),
        ]);
        $vendedor->assignRole('vendedor');

    }
}

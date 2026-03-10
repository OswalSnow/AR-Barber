<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barberos = [
            ['name' => 'Alberto', 'email' => 'alberto@barberia.com'],
            ['name' => 'Angel Venegas', 'email' => 'angel@barberia.com'],
            ['name' => 'Anibal', 'email' => 'anibal@barberia.com'],
            ['name' => 'Kinich', 'email' => 'kinich@barberia.com'],
        ];

        foreach ($barberos as $b) {
            \App\Models\User::create([
                'name' => $b['name'],
                'email' => $b['email'],
                'password' => bcrypt('betocontrasena'), // contraseña database
                'role' => 'barber',
            ]);
        }
        
        // admins
       \App\Models\User::create([
            'name' => 'Eric-Admin',
            'email' => 'dueno@barberia.com',
            'password' => bcrypt('betosuper'),
            'role' => 'admin', 
        ]);

        \App\Models\User::create([
            'name' => 'Carmine-Admin',
            'email' => 'due@barberia.com',
            'password' => bcrypt('owncat'),
            'role' => 'admin', 
        ]);

        
    }
}

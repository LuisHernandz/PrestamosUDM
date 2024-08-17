<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $userData = [
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'roles_rol_id' => 1
        ];

        $userId = DB::table('usuarios')->insertGetId($userData);

        $adminData = [
            'adm_nombre' => 'Administrador',
            'adm_apellidos' => 'Admin',
            'generos_gen_id' => 1,
            'usuarios_id' => $userId,
        ];

        DB::table('administradores')->insert($adminData);
    }
}

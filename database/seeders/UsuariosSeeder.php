<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'user_data' => [
                    'name' => 'José Cruz Ruiz Miron',
                    'email' => 'jcruiz@prueba.com',
                    'area_id' => 1,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Claudia López',
                    'email' => 'clopez@prueba.com',
                    'area_id' => 1,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Berenice Guillaumin',
                    'email' => 'bguillaumin@prueba.com',
                    'area_id' => 1,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'José Mario Barragan Esparza',
                    'email' => 'jmbarragan@prueba.com',
                    'area_id' => 1,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Karina Macías Hernández',
                    'email' => 'kmacias@prueba.com',
                    'area_id' => 1,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Félix Alarcón',
                    'email' => 'falarcon@prueba.com',
                    'area_id' => 2,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Adrian Stivalet',
                    'email' => 'astivalet@prueba.com',
                    'area_id' => 2,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Vicky Flores',
                    'email' => 'vflores@prueba.com',
                    'area_id' => 2,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Aaron Salazar',
                    'email' => 'asalazar@prueba.com',
                    'area_id' => 2,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Claudia Méndez',
                    'email' => 'cmendez@prueba.com',
                    'area_id' => 2,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Joel Clemente Serrano',
                    'email' => 'jclemente@prueba.com',
                    'area_id' => 3,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Leticia Sedas Vargas',
                    'email' => 'lsedas@prueba.com',
                    'area_id' => 3,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Lorena Rivera Ruiz',
                    'email' => 'lrivera@prueba.com',
                    'area_id' => 3,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Maria Reyna Sánchez',
                    'email' => 'mreyna@prueba.com',
                    'area_id' => 4,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Miguel Ángel Hernández',
                    'email' => 'mhernandez@prueba.com',
                    'area_id' => 4,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Doralicia Riaño',
                    'email' => 'driaño@prueba.com',
                    'area_id' => 4,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Manuel Eduardo Cruz Couttolenc',
                    'email' => 'mcruz@prueba.com',
                    'area_id' => 4,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Eladio Bello',
                    'email' => 'ebello@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Javier Chavarria',
                    'email' => 'jchavarria@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Patricia Morales Huesca',
                    'email' => 'pmorales@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Arturo Ortega',
                    'email' => 'aortega@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Rolando Arteaga Cárdenas',
                    'email' => 'rarteaga@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
            [
                'user_data' => [
                    'name' => 'Juan Uscanga',
                    'email' => 'juscanga@prueba.com',
                    'area_id' => 5,
                    'password' => bcrypt('123456789'),
                ],
            ],
        ];

        foreach ($usuarios as $usuario) {
            $user = User::create($usuario['user_data']);
        }
    }
}

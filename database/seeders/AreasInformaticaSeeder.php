<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AreasInformatica;

class AreasInformaticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'name' => 'Coordinación de Informática',
            ],
            [
                'name' => 'Redes y Telecomunicaciones',
            ],
            [
                'name' => 'Desarrollo de sistemas',
            ],
            [
                'name' => 'Diseño e Identidad',
            ],
            [
                'name' => 'Operaciones y Servicios',
            ],
        ];

        foreach ($areas as $area) {
            AreasInformatica::create($area);
        }
    }
}
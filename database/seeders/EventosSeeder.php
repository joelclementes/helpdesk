<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventos = [
            [
                'evento_data' => [
                    'id' => 1,
                    'name' => 'Entrega Medalla al Mérito Legislativo',
                    'date' => '2025-08-15',
                    'activo' => 0
                ]
            ],
            [
                'evento_data' => [
                    'id' => 2,
                    'name' => 'Ceremonia de Toma de Protesta',
                    'date' => '2025-08-18',
                    'activo' => 0
                ]
            ],
            [
                'evento_data' => [
                    'id' => 3,
                    'name' => 'Reunión de Comisiones Unidas',
                    'date' => '2025-08-20',
                    'activo' => 0
                ]
            ],
            [
                'evento_data' => [
                    'id' => 4,
                    'name' => 'Conferencia sobre Transparencia Legislativa',
                    'date' => '2025-09-15',
                    'activo' => 1
                ]
            ],
            [
                'evento_data' => [
                    'id' => 5,
                    'name' => 'Taller de Capacitación para Diputados',
                    'date' => '2025-09-25',
                    'activo' => 1
                ]
            ],
            [
                'evento_data' => [
                    'id' => 6,
                    'name' => 'Presentación del Informe Anual',
                    'date' => '2025-09-30',
                    'activo' => 1
                ]
            ],
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento['evento_data']);
        }
    }
}

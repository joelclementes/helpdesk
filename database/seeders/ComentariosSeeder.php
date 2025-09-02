<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comentario;

class ComentariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comentarios = [
            [
                'comentario_data' => [
                    'reporte_id' => 1,
                    'user_id' => 2,
                    'comentario' => 'Se está analizando el problema. Es posible formatear el equipo.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ],
            [
               
                'comentario_data' => [
                    'reporte_id' => 1,
                    'user_id' => 21,
                    'comentario' => 'Se formateó el equipo y se reinstaló el sistema operativo. El problema fue resuelto.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario['comentario_data']);
        }
    }
}

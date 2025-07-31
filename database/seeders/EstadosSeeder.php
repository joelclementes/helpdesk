<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'name' => 'Pendiente',
            ],
            [
                'name' => 'Atendido',
            ],
            [
                'name' => 'Cerrado',
            ],
            [
                'name' => 'Cancelado',
            ],
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
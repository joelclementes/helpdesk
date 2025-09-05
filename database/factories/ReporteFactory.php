<?php

namespace Database\Factories;

use App\Models\Reporte;
use App\Models\Categoria;
use App\Models\Estado;
use App\Models\DepartamentoCongreso;
use App\Models\AreasInformatica;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporte>
 */
class ReporteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-5 days', 'now');
        $estadoId = $this->faker->numberBetween(1, 4); // 1-4 según EstadosSeeder
        
        // Si el estado es "Cerrado" (id: 3), generar fecha de cierre
        $closedAt = null;
        if ($estadoId == 3) {
            $closedAt = $this->faker->dateTimeBetween($createdAt, 'now');
        }

        return [
            'solicitante' => $this->faker->name(),
            'descripcion' => $this->faker->paragraph(2),
            'categoria_id' => $this->faker->numberBetween(1, 53), // Basado en CategoriasSeeder
            'estado_id' => $estadoId,
            'departamento_congreso_id' => $this->faker->numberBetween(1, 119), // Basado en DepartamentosCongresoSeeder
            'capturo_user_id' => $this->faker->numberBetween(2, 3), // Basado en UsuariosSeeder
            'area_informatica_id' => $this->faker->numberBetween(1, 5), // Basado en AreasInformaticaSeeder
            'tecnico_user_id' => $this->faker->numberBetween(4, 23), // Técnico asignado
            'closed_at' => $closedAt,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Estado para reportes pendientes
     */
    public function pendiente()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado_id' => 1, // Pendiente
                'closed_at' => null,
            ];
        });
    }

    /**
     * Estado para reportes atendidos
     */
    public function atendido()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado_id' => 2, // Atendido
                'closed_at' => null,
            ];
        });
    }

    /**
     * Estado para reportes cerrados
     */
    public function cerrado()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado_id' => 3, // Cerrado
                'closed_at' => $this->faker->dateTimeBetween($attributes['created_at'], 'now'),
            ];
        });
    }

    /**
     * Estado para reportes cancelados
     */
    public function cancelado()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado_id' => 4, // Cancelado
                'closed_at' => $this->faker->dateTimeBetween($attributes['created_at'], 'now'),
            ];
        });
    }

    /**
     * Reportes recientes (últimas 2 semanas)
     */
    public function reciente()
    {
        return $this->state(function (array $attributes) {
            $createdAt = $this->faker->dateTimeBetween('-2 weeks', 'now');
            return [
                'created_at' => $createdAt,
                'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
            ];
        });
    }

    /**
     * Reportes antiguos (más de 3 meses)
     */
    public function antiguo()
    {
        return $this->state(function (array $attributes) {
            $createdAt = $this->faker->dateTimeBetween('-1 year', '-3 months');
            return [
                'created_at' => $createdAt,
                'updated_at' => $this->faker->dateTimeBetween($createdAt, '-2 months'),
            ];
        });
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detalle_Venta>
 */
class Detalle_VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "cantidad" => $this->faker->numberBetween(1, 10),
            "estado" => $this->faker->randomElement(["activo", "inactivo"]),
            "id_producto" => \App\Models\Producto::factory(),
            "id_venta" => \App\Models\Venta::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Venta;
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
            "id_producto" => Producto::inRandomOrder()->first()->id,
            "id_venta" => Venta::inRandomOrder()->first()->id,
        ];
    }
}

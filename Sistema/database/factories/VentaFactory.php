<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "metodo_pago" => $this->faker->randomElement(["efectivo", "tarjeta", "qr", "cupon"]),
            "id_usuario" => User::inRandomOrder()->first()->id,
            "total" => $this->faker->randomFloat(3, 10, 99),
            "estado" => $this->faker->randomElement(["pagado", "fallo", "pendiente"]),
        ];
    }
}

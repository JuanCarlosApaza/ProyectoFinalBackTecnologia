<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promociones>
 */
class PromocionesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "imagen"=>$this->faker->imageURL(),
            "estado"=>$this->faker->boolean(),
            "id_producto"=>\App\Models\Producto::factory(),

        ];
    }
}

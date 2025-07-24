<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre" => $this->faker->company(),
            "logo" => $this->faker->imageUrl(),
            "direccion" => $this->faker->address(),
            "telefono" => $this->faker->phoneNumber(),
            "estado" => $this->faker->randomElement(["activo", "inactivo", "con procesos"]),
        ];
    }
}

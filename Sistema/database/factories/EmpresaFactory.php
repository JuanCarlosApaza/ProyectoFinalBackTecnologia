<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
            "direccion" => $this->faker->address(),
            "id_usuario" => User::inRandomOrder()->first()->id,

            "telefono" => $this->faker->phoneNumber(),
            "estado" => $this->faker->randomElement(["activo", "inactivo", "con procesos"]),
        ];
    }
}

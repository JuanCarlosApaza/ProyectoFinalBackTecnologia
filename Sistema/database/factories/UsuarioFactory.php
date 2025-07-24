<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre"=>$this->faker->name,
            "apellido"=>$this->faker->lastName(),
            "telefono"=>$this->faker->phoneNumber(),
            "direccion"=>$this->faker->address(),
            "estado"=>$this->faker->randomElement(["pendiente","inactivo","activo"]),
            "correo"=>$this->faker->email(),
            "clave"=>$this->faker->password(),
        ];
    }
}

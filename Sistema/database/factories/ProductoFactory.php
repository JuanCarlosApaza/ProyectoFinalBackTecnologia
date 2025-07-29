<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Categoria;
use \App\Models\Empresa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
    $categoriaIds = Categoria::pluck('id')->toArray();
    $empresaIds = Empresa::pluck('id')->toArray();

        return [
            "nombre" => $this->faker->name,
            "id_empresa" => $this->faker->randomElement($empresaIds),
            "id_categoria" => $this->faker->randomElement($categoriaIds),
            "precio" => $this->faker->randomFloat(2, 0, 100),
            "cantidad" => $this->faker->numberBetween(10, 100),
            "descripcion" => $this->faker->catchPhrase(),
            "estado" => $this->faker->randomElement(["vencido", "agotado", "stock"]),
            "descuento" => $this->faker->randomElement([0, 0, 10]),
        ];
    }
}

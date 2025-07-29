<?php

namespace Database\Seeders;

use App\Models\Detalle_Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Detalle_VentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Detalle_Venta::factory()->count(5)->create();
    }
}

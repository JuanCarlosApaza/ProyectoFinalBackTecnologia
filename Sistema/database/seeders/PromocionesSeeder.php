<?php

namespace Database\Seeders;

use App\Models\Promociones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromocionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promociones::factory()->count(30)->create();
    }
}

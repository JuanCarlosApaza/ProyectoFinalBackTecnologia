<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('estado');
            $table->string('imagen')->nullable();
            $table->decimal('precio',8,2);
            $table->integer('cantidad');
            $table->foreignId('id_categoria')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('id_empresa')->constrained('empresas')->onDelete('cascade');
            $table->integer('descuento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

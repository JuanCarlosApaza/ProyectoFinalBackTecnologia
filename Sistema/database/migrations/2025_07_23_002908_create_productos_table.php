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
            $table->string('imagen');
            $table->decimal('precio',8,2);
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_empresa')->references('id')->on('empresas');
            $table->foreign('id_categoria')->references('id')->on('categorias');
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

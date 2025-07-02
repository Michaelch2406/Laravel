<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id(); // ID auto-incremental
            $table->string('nombre', 100); // Nombre del contacto
            $table->string('usuario', 50); // Usuario/nickname
            $table->string('telefono', 20); // Número de teléfono
            $table->text('mensaje'); // Mensaje del contacto
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactos');
    }
};


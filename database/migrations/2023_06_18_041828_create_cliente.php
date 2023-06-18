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
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('cedula', 25);
            $table->string('nombre', 255);
            $table->string('apellido', 255);
            $table->text('direccion');
            $table->date('fecha_nacimiento');
            $table->string('telefono', 25);
            $table->string('email', 255);

            $table->unsignedInteger('id_categoria_cliente');
            $table->foreign('id_categoria_cliente')
            ->references('id_categoria_cliente')
            ->on('categoria_cliente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
};

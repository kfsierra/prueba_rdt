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
        Schema::create('factura_producto', function (Blueprint $table) {

            $table->unsignedInteger('num_factura');
            $table->foreign('num_factura')
            ->references('num_factura')
            ->on('factura');

            $table->unsignedInteger('id_producto');
            $table->foreign('id_producto')
            ->references('id_producto')
            ->on('producto');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_producto');
    }
};

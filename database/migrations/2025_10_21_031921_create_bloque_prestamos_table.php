<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloquePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloquePrestamos', function (Blueprint $table) {
            $table->id('idBloquePrestamo');
            $table->unsignedBigInteger('idPrestamo');
            $table->unsignedBigInteger('idBloque');
            //$table->timestamps();

           $table->foreign('idPrestamo')
                  ->references('idPrestamo')
                  ->on('prestamos')
                  ->onDelete('cascade');

            $table->foreign('idBloque')
                  ->references('idBloque')
                  ->on('bloques')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloquePrestamos');
    }
}

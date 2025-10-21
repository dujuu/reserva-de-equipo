<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('idEquipo');
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->string('categoria');
            $table->string('estado');
            //$table->string('tipo');
            $table->timestamps(); // opcional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};


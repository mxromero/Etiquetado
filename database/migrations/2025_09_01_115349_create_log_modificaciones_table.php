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
        Schema::create('log_modificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('usuario'); // nombre o id del usuario que modifica
            $table->string('material')->nullable();
            $table->string('orden_previsional')->nullable();
            $table->date('fecha')->nullable();
            $table->json('campos_anteriores'); // guarda los valores antiguos
            $table->json('campos_nuevos');     // guarda los valores nuevos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_modificaciones');
    }
};

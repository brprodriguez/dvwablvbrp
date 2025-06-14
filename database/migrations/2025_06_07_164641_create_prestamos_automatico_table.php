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
        Schema::create('prestamoautomaticos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->integer('plazo');
            $table->date('fecha_inicio'); // Nuevo campo
            $table->string('perfil_riesgo'); // Nuevo campo
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // si usas autenticación
            $table->string('estado')->nullable(); // Nuevo campo
            $table->string('observaciones')->nullable(); // Nuevo campo
            $table->string('termsycond')->nullable(); // Nuevo campo
            
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
        Schema::dropIfExists('prestamoautomaticos');
    }
};

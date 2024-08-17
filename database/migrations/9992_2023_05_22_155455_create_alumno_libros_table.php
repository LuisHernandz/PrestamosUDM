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
        Schema::create('alumno_libros', function (Blueprint $table) {
            $table->id('pre_id');

            $table -> date('pre_fechaSalida');
            $table -> time('pre_horaSalida');
            
            $table -> unsignedBigInteger('alumnos_id');
            $table -> foreign('alumnos_id')
                    -> references('id')
                    -> on('alumnos')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');            
                    
            $table -> unsignedBigInteger('libros_lib_id');
            $table -> foreign('libros_lib_id')
                    -> references('lib_id')
                    -> on('libros')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');
            
            $table -> date('pre_fechaEntrada');
            $table -> time('pre_horaEntrada');

            $table -> text('observaciones');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_libros');
    }
};

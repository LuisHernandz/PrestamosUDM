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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id('pre_id');

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
                
            $table -> unsignedBigInteger('solicitud_sol_id');
            $table -> foreign('solicitud_sol_id') 
                    -> references('sol_id')
                    -> on('solicitudes')
                    -> onUpdate('cascade')
                    -> onDelete('cascade'); 

            $table->date('fechaInicio'); 
            $table->date('fechaFinal') -> nullable(); 
            $table->time('horaInicio') -> nullable();
            $table->time('horaFinal') -> nullable();
            $table -> string('estado') -> nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};

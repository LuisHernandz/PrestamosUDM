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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id('sol_id');
            $table->timestamps();

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
                    
            $table -> string('sol_estado') -> nullable();
            $table -> string('sol_motivo') -> nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};

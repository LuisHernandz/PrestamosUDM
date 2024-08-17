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
        Schema::create('alumnos', function (Blueprint $table) {

        $table -> id();

        $table -> string('alu_matricula');
        $table -> string('alu_nombre', 200);
        $table -> string('alu_apellidos', 200);
        $table -> string('curp', 18);

        $table -> unsignedBigInteger('generos_gen_id');
        $table -> foreign('generos_gen_id')
                -> references('gen_id')
                -> on('generos')
                -> onDelete('cascade')
                -> onUpdate('cascade');

        $table -> string('alu_telefono', 15);
        $table -> string('alu_domicilio', 200);
        
        $table -> unsignedBigInteger('carrera_nivels_id');
        $table -> foreign('carrera_nivels_id')
                -> references('id')
                -> on('carrera_nivels')
                -> onDelete('cascade')
                -> onUpdate('cascade');

        $table -> unsignedBigInteger('grados_gra_id');
        $table -> foreign('grados_gra_id')
                -> references('gra_id')
                -> on('grados')
                -> onDelete('cascade')
                -> onUpdate('cascade');

        $table -> unsignedBigInteger('grupos_gru_id');
        $table -> foreign('grupos_gru_id')
                -> references('gru_id')
                -> on('grupos')
                -> onDelete('cascade')
                -> onUpdate('cascade');
        
        $table -> unsignedBigInteger('usuarios_id') -> nullable();
        $table -> foreign('usuarios_id')
                -> references('id')
                -> on('usuarios')
                -> onDelete('cascade')
                -> onUpdate('cascade');

        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};

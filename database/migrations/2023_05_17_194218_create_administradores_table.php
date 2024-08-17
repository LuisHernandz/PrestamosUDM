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
        Schema::create('administradores', function (Blueprint $table) {
            $table->id('adm_id');

            $table -> string('adm_nombre', 200);
            $table -> string('adm_apellidos', 200);
            
            $table -> unsignedBigInteger('generos_gen_id');
            $table -> foreign('generos_gen_id') 
                -> references('gen_id') 
                -> on('generos')
                -> onUpdate('cascade')
                -> onDelete('cascade');

            $table -> unsignedBigInteger('usuarios_id');
            $table -> foreign('usuarios_id') 
            -> references('id') 
            -> on('usuarios')
            -> onUpdate('cascade')
            -> onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};

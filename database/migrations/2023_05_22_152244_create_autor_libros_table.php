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
        Schema::create('autor_libros', function (Blueprint $table) {
            $table->id();

            $table -> unsignedBigInteger('autores_aut_id') -> nullable();
            $table -> foreign('autores_aut_id') 
                    -> references('aut_id') 
                    -> on('autores')
                    -> onUpdate('cascade')
                    -> onDelete('set null');            
                    
            $table -> unsignedBigInteger('libros_lib_id');
            $table -> foreign('libros_lib_id') 
                    -> references('lib_id') 
                    -> on('libros')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autor_libros');
    }
};

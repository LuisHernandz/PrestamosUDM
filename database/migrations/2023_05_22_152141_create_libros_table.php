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
        Schema::create('libros', function (Blueprint $table) {
            $table->id('lib_id');
 
            $table -> string('lib_titulo');
            $table -> text('lib_descripcion') -> nullable();
            $table -> integer('lib_ejemplares') -> nullable();
            $table -> integer('lib_eDisponibles') -> nullable();          
            $table -> string('lib_foto') -> nullable();  
            $table -> integer('lib_aPublicacion') -> nullable();
            $table -> string('lib_archivo') -> nullable();
                    
            $table -> unsignedBigInteger('editoriales_edi_id') -> nullable();
            $table -> foreign('editoriales_edi_id') 
                    -> references('edi_id')
                    -> on('editoriales')
                    -> onUpdate('cascade')
                    -> onDelete('set null');

            $table -> unsignedBigInteger('carreraNiveles_id');
            $table -> foreign('carreraNiveles_id')
                    ->references('id')
                    ->on('carrera_nivels')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');

                    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};

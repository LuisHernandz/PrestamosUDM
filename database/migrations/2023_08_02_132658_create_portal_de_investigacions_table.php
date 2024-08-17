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
        Schema::create('portal_de_investigacions', function (Blueprint $table) {
            $table->id();

            $table -> string('pdi_nombre');
            $table -> string('pdi_descripcion') -> nullable();
            $table -> string('pdi_imagen') -> nullable();
            $table -> string('pdi_enlace');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_de_investigacions');
    }
};

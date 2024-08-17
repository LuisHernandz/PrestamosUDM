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
        Schema::create('carrera_nivels', function (Blueprint $table) {
            $table->id();
            
            $table -> unsignedBigInteger('carreras_car_id');
            $table -> foreign('carreras_car_id') 
                    -> references('car_id') 
                    -> on('carreras')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');            
                    
            $table -> unsignedBigInteger('nivel_niv_id');
            $table -> foreign('nivel_niv_id') 
                    -> references('niv_id') 
                    -> on('nivel')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrera_nivels');
    }
};

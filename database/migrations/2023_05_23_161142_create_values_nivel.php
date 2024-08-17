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
        Schema::table('nivel', function (Blueprint $table) {

            DB::table('nivel') -> insert([
                'niv_nombre' => 'Bachillerato',
            ]);

            DB::table('nivel') -> insert([
                'niv_nombre' => 'Licenciatura',
            ]);
            
            DB::table('nivel') -> insert([
                'niv_nombre' => 'Especialidad',
            ]);
            
            DB::table('nivel') -> insert([
                'niv_nombre' => 'Maestría',
            ]);
            
            DB::table('nivel') -> insert([
                'niv_nombre' => 'Doctorado',
            ]);

            DB::table('nivel') -> insert([
                'niv_nombre' => 'Todos',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nivel', function(Blueprint $table){
            
        });
    }
};

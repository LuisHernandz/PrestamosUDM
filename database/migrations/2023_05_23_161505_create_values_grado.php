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
        Schema::table('grados', function (Blueprint $table) {

            DB::table('grados') -> insert([
                'gra_nombre' => 'Primer semestre',
            ]);

            DB::table('grados') -> insert([
                'gra_nombre' => 'Segundo semestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Tercer semestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Cuarto semestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Quinto semestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Sexto semestre',
            ]);


            DB::table('grados') -> insert([
                'gra_nombre' => 'Primer cuatrimestre',
            ]);

            DB::table('grados') -> insert([
                'gra_nombre' => 'Segundo cuatrimestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Tercer cuatrimestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Cuarto cuatrimestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Quinto cuatrimestre',
            ]);
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Sexto cuatrimestre',
            ]);            
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Séptimo cuatrimestre',
            ]);            
            
            DB::table('grados') -> insert([
                'gra_nombre' => 'Octavo cuatrimestre',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grados', function(Blueprint $table){
            
        });
    }
};

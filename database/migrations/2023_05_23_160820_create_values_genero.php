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
        Schema::table('generos', function (Blueprint $table) {

            DB::table('generos') -> insert([
                'gen_nombre' => 'Masculino',
            ]);

            DB::table('generos') -> insert([
                'gen_nombre' => 'Femenino',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generos', function(Blueprint $table){
            
        });
    }
};

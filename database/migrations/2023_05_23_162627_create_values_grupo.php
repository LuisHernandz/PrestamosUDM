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
        Schema::table('grupos', function (Blueprint $table) {

            DB::table('grupos') -> insert([
                'gru_nombre' => 'A',
            ]);

            DB::table('grupos') -> insert([
                'gru_nombre' => 'B',
            ]);
            
            DB::table('grupos') -> insert([
                'gru_nombre' => 'C',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupos', function(Blueprint $table){
            
        });
    }
};

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
        Schema::table('carrera_nivels', function (Blueprint $table) {

            //Carreras de nivel bachillerato =====================================================

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '1',
                'carreras_car_id' => '1',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '1',
                'carreras_car_id' => '2',
            ]);
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '1',
                'carreras_car_id' => '3',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '1',
                'carreras_car_id' => '4',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '1',
                'carreras_car_id' => '33',
            ]);
 
            //Carreras de licenciatura =====================================================

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '5',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '6',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '7',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '8',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '9',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '10',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '11',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '12',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '13',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '14',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '15',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '16',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '17',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '18',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '19',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '20',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '2',
                'carreras_car_id' => '33',
            ]);

            //Carreras de especialidad =================================================

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '3',
                'carreras_car_id' => '30',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '3',
                'carreras_car_id' => '31',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '3',
                'carreras_car_id' => '32',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '3',
                'carreras_car_id' => '33',
            ]);

            //Carreras de maestría =================================================

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '21',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '22',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '23',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '24',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '25',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '26',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '27',
            ]);            
            
            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '28',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '4',
                'carreras_car_id' => '33',
            ]);

    //Carrera de doctorado =================================================

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '5',
                'carreras_car_id' => '29',
            ]);

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '5',
                'carreras_car_id' => '33',
            ]);

            //Todas==============================================================================0

            DB::table('carrera_nivels') -> insert([
                'nivel_niv_id' => '6',
                'carreras_car_id' => '33',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrera_nivels', function(Blueprint $table){
            
        });
    }
};

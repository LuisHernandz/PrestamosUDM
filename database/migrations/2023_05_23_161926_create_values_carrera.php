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
        Schema::table('carreras', function (Blueprint $table) {

            DB::table('carreras') -> insert([
                'car_nombre' => 'Técnico en efermería',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Técnico en trabajo social',
            ]);
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Técnico en programación',
            ]);
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Técnico en recursos humanos',
            ]);            
            
            //Licenciaturas==================================================================================================================

            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en enfermería',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en psicología',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en trabajo social',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Ingenieria en sistemas computacionales',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en informática administrativa',
            ]);
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en contaduría e informática',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en administración de empresas',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en mercadotecnia y publicidad',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en derecho',
            ]);
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en criminología y criminalística',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en arquitectura',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en diseño gráfico',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en turismo',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en hotelería',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en gastronomía',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Licenciatura en profesionalización en enfermería',
            ]);

            //Maestrias =============================================================================================================================

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en administración en sistemas de salud',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en trabajo social',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en ciencias de la cumputación con formación en base de datos',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en juicios orales',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en administración estratégica',
            ]);

            // DB::table('carreras') -> insert([
            //     'car_nombre' => 'Maestría en criminología',
            // ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en derecho civil',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en ciencias de la educación',
            ]);            
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Maestría en educación especial',
            ]);

            //Doctorado ======================================================================
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Doctorado en educación',
            ]);

            //Especialidad ===================================================================================
            
            DB::table('carreras') -> insert([
                'car_nombre' => 'Especialidad en efermería neonatal',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Especialidad en efermería quirúrgica',
            ]);

            DB::table('carreras') -> insert([
                'car_nombre' => 'Especialidad en efermería geriátrica',
            ]);

            //TODOS ================================================================================================================

            DB::table('carreras') -> insert([
                'car_nombre' => 'Todas',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carreras', function(Blueprint $table){
            
        });
    }
};

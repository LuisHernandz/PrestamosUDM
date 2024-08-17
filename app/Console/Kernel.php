<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// 

use App\Notifications\DiasFaltantesNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

use App\Models\User;
use App\Models\Rol;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\CarreraNivel;
use App\Models\Grado;
use App\Models\Grupo;
use App\Models\Nivel;
use App\Models\Alumno;
use App\Models\Administrador;
use App\Models\Autor;
use App\Models\Editorial;
use App\Models\Libro;
use App\Models\AutorLibro;
use App\Models\Solicitudes;
use App\Models\Prestamos;
use App\Models\PortalDeInvestigacion;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    
     protected function schedule(Schedule $schedule): void {
        // Obtener datos de los préstamos
        $prestamos = DB::table('prestamos as p')
            ->select('u.id', 'p.*', 'a.alu_nombre', 'l.*')
            ->leftJoin('alumnos as a', 'p.alumnos_id', '=', 'a.id')
            ->leftJoin('libros as l', 'p.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('usuarios as u', 'a.usuarios_id', '=', 'u.id')
            ->get();
    
        foreach ($prestamos as $prestamo) {
            $prestamo->fechaInicial = Carbon::createFromDate(2023, 8, 12); // Ajusta la fecha final
    
            // Calcular la fecha un día antes de la fechaInicial
            $fechaNotificacion = $prestamo->fechaInicial->subDay();
    
            // Programar la notificación un día antes de la fechaInicial
            $schedule->call(function () use ($prestamo, $fechaNotificacion) {
                $usuario = User::find($prestamo->id);
    
                if ($usuario) {
                    $usuario->notify(new DiasFaltantesNotification($fechaNotificacion));
                }
            })->dailyAt('12:00'); // Ajustar la hora a la que deseas enviar la notificación
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

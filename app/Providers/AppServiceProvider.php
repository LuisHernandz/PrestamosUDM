<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


use Illuminate\Support\Facades\DB;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $usuarios = DB::select("SELECT a.adm_id, a.adm_nombre, a.adm_apellidos, a.usuarios_id, usuarios.id, usuarios.email, usuarios.foto
        FROM administradores a
        LEFT JOIN usuarios ON a.usuarios_id = usuarios.id");

        $usuariosB = DB::select("SELECT b.bib_id, b.bib_nombre, b.bib_apellidos, b.usuarios_id, usuarios.id, usuarios.email, usuarios.foto
        FROM bibliotecarios b
        LEFT JOIN usuarios ON b.usuarios_id = usuarios.id");

        // $usuariosA = DB::select("SELECT a.id, a.alu_nombre, a.alu_apellidos, a.usuarios_id, usuarios.id, usuarios.email, usuarios.foto
        // FROM alumnos a
        // LEFT JOIN usuarios ON a.usuarios_id = usuarios.id");

        $usuariosA = DB::select(
            "SELECT a.id, a.alu_nombre, a.alu_apellidos, a.usuarios_id, a.carrera_nivels_id, usuarios.id, usuarios.email, usuarios.foto, cn.*, c.*, n.*
            FROM alumnos a
            LEFT JOIN usuarios ON a.usuarios_id = usuarios.id
            LEFT JOIN carrera_nivels cn ON cn.id = a.carrera_nivels_id
            LEFT JOIN carreras c ON c.car_id = cn.carreras_car_id
            LEFT JOIN nivel n ON n.niv_id = cn.nivel_niv_id"
        );

        View::share('administradores', $usuarios);
        View::share('bibliotecarios', $usuariosB);
        View::share('alumnos', $usuariosA);
        session(['alumnos' => $usuariosA]);

        View::composer('*', function ($view) {
            $notificacionesNoLeidas = 0;
            if (auth()->check()) {
                $notificacionesNoLeidas = auth()->user()->unreadNotifications->count();
            }
            $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
        });

    }
}

<?php

use Illuminate\Support\Facades\Route;

// CONTROLADORES

use App\Http\Controllers\BaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BibliotecarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ExcelCSVController;
use App\Http\Controllers\BackupController;


Route::view('/error', 'error.index')->name('custom.error');


/////////////// RUTAS INDEPENDIENTES ///////////////
    // RUTA /ACCESO 

        Route::get('/acceso', [SessionsController::class, 'index'])
        -> middleware('guest') // No permitir el ingreso a esta ruta cuando se esta autentificado (haber iniciado sesión)
        -> name('login.index');

        Route::post('/acceso', [SessionsController::class, 'store'])
        -> name('login.store');

    // RUTA /LOGOUT (Cerrar sesión)

        Route::get('/logout', [SessionsController::class, 'destroy'])
        -> middleware('auth') // No permitir el ingreso a esta ruta, a menos de que se haya inciado sesión
        -> name('login.destroy');

    // RUTA /VERIFICACIÓN

        Route::get('/verificación', [UsuariosController::class, 'index_verificacion'])
        -> middleware('guest')
        -> name('/verificacion.index');

        Route::post('/verificación', [UsuariosController::class, 'store_verificacion'])
        -> name('/verificacion.store');

        Route::get('/verificación/codigo/', [UsuariosController::class, 'index_codigo'])
        -> middleware('guest')
        -> name('/verificacion/codigo.index');

        Route::post('/verificación/codigo/', [UsuariosController::class, 'store_codigo'])
        -> name('/verificacion/codigo.store');

        Route::get('/restablecer_contraseña', [UsuariosController::class, 'index_cambiar'])
        -> middleware('guest')
        -> name('/cambiar.index');

        Route::post('/restablecer_contraseña', [UsuariosController::class, 'store_cambiar'])
        -> name('/cambiar.store');

    // RUTA /REGISTRO

    Route::get('/registro', [AlumnoController::class, 'create'])
    -> middleware('guest')
    ->name('registro.create');

    Route::post('/registro', [AlumnoController::class, 'store'])
    ->name('registro.store');

    Route::get('/registro/confirmación', [AlumnoController::class, 'confirmacion_create'])
    -> middleware('guest')
    ->name('registro/confirmacion.create');

    Route::post('/registro/confirmación', [AlumnoController::class, 'confirmacion_store'])
    ->name('registro/confirmacion.store');

    Route::get('/registro/exitoso', [AlumnoController::class, 'exito_create'])
    -> middleware('guest')
    ->name('registro/exitoso.create');


/////////////// RUTAS DE ALUMNO ///////////////

// RUTA /
 
    Route::get('/', [AlumnoController::class, 'index'])
        -> middleware('auth') // No permitir el ingreso a esta ruta, a menos de que se haya inciado sesión
        -> middleware('auth.alumno') // No permitir el ingreso a esta ruta, a menos de que se haya iniciado sesión como administrador, en caso contrario dirigir a /login
        -> name('/inicio');

// RUTA /LIBROS/FISICOS

    Route::get('/libros/fisicos', [AlumnoController::class, 'index_librosFisicos'])
        -> name('/libros/fisicos.index')
        -> middleware('auth')
        -> middleware('auth.alumno');

// RUTA /LIBROS/DIGITALES

    Route::get('/libros/digitales', [AlumnoController::class, 'index_librosDigitales'])
        -> name('/libros/digitales.index')
        -> middleware('auth')
        -> middleware('auth.alumno');

// PUBLICACIONES

    Route::get('/publicaciones', [AlumnoController::class, 'index_publicaciones'])
        ->middleware('auth')
        ->middleware('auth.alumno')
        ->name('/publicaciones.index'); 

// PORTAL DE INVESTIGACIÓN

    Route::get('/portal', [AlumnoController::class, 'index_portal'])
        ->middleware('auth')
        ->middleware('auth.alumno')
        ->name('/portal.index');

// PERFIL ALUMNO

    Route::get('/perfil/{id}', [AlumnoController::class, 'profile_show'])
        ->middleware('auth')
        ->name('/perfil.show');

    Route::patch('/perfil/{id}', [AlumnoController::class, 'profile_update'])
        ->name('/perfil.update');

    Route::post('/perfil/image/{id}', [AlumnoController::class, 'profile_imageUpdate'])
        ->name('/perfil/image.update');

/////////////// RUTAS DE ADMINISTRADOR ///////////////

// RUTA /ADMIN 

    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('auth')
        ->middleware('auth.admin') // No permitir el ingreso a esta ruta, a menos de que se haya iniciado sesión como administrador, en caso contrario dirigir a /
        ->name('admin.index'); 

// RUTA ADMIN/USUARIOS/ALUMNOS

    // USUARIOS -> ALUMNOS

    Route::get('/admin/usuarios/alumnos', [AdminController::class, 'index_alumnos'])
        ->middleware('auth')
        ->middleware('auth.admin') 
        ->name('admin/usuarios/alumnos.index'); 

    Route::get('/admin/usuarios/alumnos/registrar', [AdminController::class, 'create_alumnos'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/usuarios/alumnos.create');

    Route::post('/admin/usuarios/alumnos/registrar', [AdminController::class, 'store_alumnos'])
        ->name('admin/usuarios/alumnos.store');
        
    Route::get('/admin/usuarios/alumnos/modificar/{id}', [AdminController::class, 'show_alumnos'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/usuarios/alumnos.show');

    Route::patch('/admin/usuarios/alumnos/modificar/{id}', [AdminController::class, 'update_alumnos'])
        ->name('admin/usuarios/alumnos.update');

    Route::delete('/admin/usuarios/alumnos/eliminar/{id}',[AdminController::class, 'destroy_alumnos'])
        ->name('admin/usuarios/alumnos.destroy');

// RUTA ADMIN/USUARIOS/BIBLIOTECARIOS

    Route::get('/admin/usuarios/bibliotecarios', [AdminController::class, 'index_bibliotecarios'])
        ->middleware('auth')
        ->middleware('auth.admin') 
        ->name('/admin/usuarios/bibliotecarios.index');

    Route::get('/admin/usuarios/bibliotecarios/registrar', [AdminController::class, 'create_bibliotecarios'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/usuarios/bibliotecarios.create');

    Route::post('/admin/usuarios/bibliotecarios/registrar', [AdminController::class, 'store_bibliotecarios'])
        ->name('/admin/usuarios/bibliotecarios.store');

    Route::get('/admin/usuarios/bibliotecarios/modificar/{id}', [AdminController::class, 'show_bibliotecarios'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/usuarios/bibliotecarios.show');

    Route::patch('/admin/usuarios/bibliotecarios/modificar/{id}', [AdminController::class, 'update_bibliotecarios'])
        ->name('/admin/usuarios/bibliotecarios.update');

    Route::delete('/admin/usuarios/bibliotecarios/eliminar/{id}',[AdminController::class, 'destroy_bibliotecarios'])
        ->name('/admin/usuarios/bibliotecarios.destroy');

// RUTA ADMIN/CARRERAS

    Route::get('admin/carreras/index/{id}', [AdminController::class, 'carrera_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/carreras.index');

    Route::post('admin/carreras/registrar',[AdminController::class, 'carrera_store'])
        ->name('admin/carreras.store');

    Route::patch('admin/carreras/modificar', [AdminController::class, 'carrera_update'])
        ->name('admin/carreras.update');

    Route::delete('admin/carreras/eliminar/{id}', [AdminController::class, 'carrera_destroy'])
        ->name('admin/carreras.destroy'); 

// RUTA ADMIN/LIBROS

    // AUTORES
    Route::get('/admin/libros/autores',[AdminController::class, 'autores_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/libros/autores.index');

    Route::post('/admin/libros/autores/register',[AdminController::class, 'autores_store'])
        ->name('/admin/libros/autores.store');

    Route::patch('/admin/libros/autores/modificar',[AdminController::class, 'autores_update'])
        ->name('/admin/libros/autores.update');

    Route::delete('/admin/libros/autores/delete/{id}',[AdminController::class, 'autores_destroy'])
        ->name('admin/libros/autores.destroy');

    // EDITORIALES

    Route::get('/admin/libros/editoriales',[AdminController::class, 'editoriales_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/libros/editoriales.index');

    Route::post('/admin/libros/editoriales/register',[AdminController::class, 'editoriales_store'])
        ->name('/admin/libros/editoriales.store');

    Route::patch('/admin/libros/editoriales/update',[AdminController::class, 'editoriales_update'])
        ->name('/admin/libros/editoriales.update');

    Route::delete('/admin/libros/editoriales/delete/{id}',[AdminController::class, 'editoriales_destroy'])
        ->name('/admin/libros/editoriales.destroy');

    // INVENTARIO (LIBROS FISICOS)

    Route::get('/admin/libros/inventario/index',[AdminController::class, 'inventario_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/libros/inventario.index');

    Route::get('/admin/libros/inventario/registrar', [AdminController::class, 'inventario_create'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/libros/inventario.create');

    Route::post('/admin/libros/inventario/register', [AdminController::class, 'inventario_store'])
        ->name('/admin/libros/inventario.store');

    Route::get('/admin/libros/inventario/update/{id}', [AdminController::class, 'inventario_show'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/libros/inventario.show');

    Route::patch('/admin/libros/inventario/update/{id}', [AdminController::class, 'inventario_update'])
        ->name('/admin/libros/inventario.update');

    Route::delete('/admin/libros/inventario/delete/{id}', [AdminController::class, 'inventario_destroy'])
        ->name('/admin/libros/inventario.destroy');

    // INVENTARIO (LIBROS PDF)

    Route::get('/admin/libros/inventario/digitales/create', [AdminController::class, 'inventarioDigitales_create'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/libros/inventario/digitales/create');

    Route::post('/admin/libros/inventario/digitales/store', [AdminController::class, 'inventarioDigitales_store'])
        ->name('admin/libros/inventario/digitales/store');

    Route::get('/admin/libros/inventario/digitales/update/{id}', [AdminController::class, 'inventarioDigitales_show'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/libros/inventario/digitales.show');

    Route::patch('/admin/libros/inventario/digitales/update/{id}', [AdminController::class, 'inventarioDigitales_update'])
        ->name('admin/libros/inventario/digitales.update');

    Route::delete('/admin/libros/inventario/digitales/destroy/{id}', [AdminController::class, 'inventarioDigitales_destroy'])
        ->name('admin/libros/inventario/digitales.destroy');

            // PDFs

            Route::get('/admin/libros/inventario/pdf/filtro',[AdminController::class, 'filtroLibrosPDF_index'])
                ->name('/admin/libros/inventario/pdf/filtro.index');
    
            Route::post('/admin/libros/inventario/pdf/filtro',[AdminController::class, 'librosPDF_index'])
                ->name('/admin/libros/inventario/pdf/filtro.store');

            // Peticion para obtener carreras
            Route::match(['get', 'post'], '/obtenerCarrerasPDF', [AdminController::class, 'obtenerCarrerasPDF'])
                ->name('/obtenerCarrerasPDF') 
                ->middleware('auth');

// RUTA ADMIN/PUBLICACIONES

    Route::get('/admin/publicaciones/index', [AdminController::class, 'publicaciones_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/publicaciones.index');

    Route::post('/admin/publicaciones/nueva-publicacion', [AdminController::class, 'publicaciones_store'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/publicaciones.store');

    Route::patch('/admin/publicacion/update', [AdminController::class, 'publicaciones_update'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/publicaciones.update');


    Route::delete('/admin/publicacion/destroy/{id}', [AdminController::class, 'publicaciones_destroy'])
    ->middleware('auth')
    ->middleware('auth.admin')
    ->name('/admin/publicaciones.destroy');

// RUTA ADMIN/VISITAS

    Route::get('/admin/visitas/index', [AdminController::class, 'logins_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/visitas.index');

    Route::get('/admin/visitas/pdf', [AdminController::class, 'loginsPDF_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/visitas/pdf.index');


    Route::post('/admin/visitas/pdf', [AdminController::class, 'loginsPDF_store'])
        ->name('/admin/visitas/pdf.store');


// RUTA ADMIN/PORTAL DE INVESTIGACIÓN

    Route::get('/admin/portal', [AdminController::class, 'index_portal'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/portal.index');

    Route::get('/admin/portal-de-investigacion', [AdminController::class, 'portal_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('/admin/portal-de-investigacion.index');

    Route::post('/admin/portal-de-investigacion/store', [AdminController::class, 'portal_store'])
        ->name('/admin/portal-de-investigacion.store');

    Route::patch('/admin/portal-de-investigacion/update', [AdminController::class, 'portal_update'])
        ->name('/admin/portal-de-investigacion.update');

    Route::delete('/admin/portal-de-investigacion/destroy/{id}', [AdminController::class, 'portal_destroy'])
        ->name('/admin/portal-de-investigacion.destroy');

// RUTA ADMIN/PERFIL

    Route::get('admin/perfil/{id}', [AdminController::class, 'profile_show'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/perfil.show');

    Route::patch('admin/perfil/{id}', [AdminController::class, 'profile_update'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/perfil.update');

    Route::post('admin/perfil/image/{id}', [AdminController::class, 'profile_imageUpdate'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/perfil/image.update');

// RUTA ADMIN/EDICION-PDF

    Route::get('admin/edicion-pdf/', [AdminController::class, 'pdfPortada_index'])
    ->middleware('auth')
    ->middleware('auth.admin')
    ->name('admin/edicion-pdf.index');

    Route::get('admin/edicion-pdf/encabezado', [AdminController::class, 'pdfPortadaEncabezado_index'])
    ->middleware('auth')
    ->middleware('auth.admin')
    ->name('admin/edicion-pdf/encabezado.index');

    Route::post('admin/edicion-pdf/encabezado', [AdminController::class, 'pdfPortadaEncabezado_store'])
    ->name('admin/edicion-pdf/encabezado.store'); 

    Route::delete('admin/edicion-pdf/encabezado/eliminar/{id}',[AdminController::class, 'pdfPortadaEncabezado_destroy'])
    ->name('admin/edicion-pdf/encabezado/eliminar.destroy');

    Route::get('admin/edicion-pdf/pie', [AdminController::class, 'pdfPortadaPie_index'])
    ->middleware('auth')
    ->middleware('auth.admin')
    ->name('admin/edicion-pdf/pie.index');

    Route::post('admin/edicion-pdf/pie', [AdminController::class, 'pdfPortadaPie_store'])
    ->name('admin/edicion-pdf/pie.store'); 

    Route::delete('admin/edicion-pdf/pie/eliminar/{id}',[AdminController::class, 'pdfPortadaPie_destroy'])
    ->name('admin/edicion-pdf/pie/eliminar.destroy');

    Route::get('admin/edicion-pdf/portada', [AdminController::class, 'pdfPortadaCuerpo_index'])
        ->middleware('auth')
        ->middleware('auth.admin')
        ->name('admin/edicion-pdf/portada.index');
    
    Route::get('admin/edicion-pdf/portada', [AdminController::class, 'pdfPortadaCuerpo_index'])
        ->middleware('auth')
        ->name('admin/edicion-pdf/portada.index'); 
    
    Route::post('admin/edicion-pdf/portada', [AdminController::class, 'pdfPortadaCuerpo_store'])
        ->middleware('auth')
        ->name('admin/edicion-pdf/portada.store'); 

/////////////// RUTAS DE BIBLIOTECARIO ///////////////

    // RUTA /BIBLIOTECARIO

        Route::get('/bibliotecario', [BibliotecarioController::class, 'index'])
            ->middleware('auth')
            ->middleware('auth.bibliotecario')
            ->name('bibliotecario.index');

    // RUTA BIBLIOTECARIO/USUARIOS/ALUMNOS

        Route::get('/bibliotecario/usuarios/alumnos', [BibliotecarioController::class, 'index_alumnos'])
            ->middleware('auth')
            ->middleware('auth.bibliotecario')
            ->name('bibliotecario/usuarios/alumnos.index');

        Route::get('/bibliotecario/usuarios/alumnos/registrar', [BibliotecarioController::class, 'create_alumnos'])
            ->middleware('auth')
            ->middleware('auth.bibliotecario')
            ->name('bibliotecario/usuarios/alumnos.create');

        Route::post('/bibliotecario/usuarios/alumnos/registrar', [BibliotecarioController::class, 'store_alumnos'])
            ->name('bibliotecario/usuarios/alumnos.store');

        Route::get('/bibliotecario/usuarios/alumnos/modificar/{id}', [BibliotecarioController::class, 'show_alumnos'])
            ->middleware('auth')
            ->middleware('auth.bibliotecario')
            ->name('bibliotecario/usuarios/alumnos.show');

        Route::patch('/bibliotecario/usuarios/alumnos/modificar/{id}', [BibliotecarioController::class, 'update_alumnos'])
            ->name('bibliotecario/usuarios/alumnos.update');

        Route::delete('/bibliotecario/usuarios/alumnos/eliminar/{id}',[BibliotecarioController::class, 'destroy_alumnos'])
            ->name('bibliotecario/usuarios/alumnos.destroy');


// RUTA BIBLIOTECARIO/CARRERAS

    Route::get('bibliotecario/carreras/index/{id}', [BibliotecarioController::class, 'carrera_index'])
        ->name('bibliotecario/carreras.index');

    Route::post('bibliotecario/carreras/registrar',[BibliotecarioController::class, 'carrera_store'])
        ->name('bibliotecario/carreras.store');

    Route::patch('bibliotecario/carreras/modificar', [BibliotecarioController::class, 'carrera_update'])
        ->name('bibliotecario/carreras.update');

    Route::delete('bibliotecario/carreras/eliminar/{id}', [BibliotecarioController::class, 'carrera_destroy'])
        ->name('bibliotecario/carreras.destroy');

// RUTA BIBLIOTECARIO/LIBROS

    // INVENTARIO

    Route::get('/bibliotecario/libros/inventario/index',[BibliotecarioController::class, 'inventario_index'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/libros/inventario.index');

    Route::get('/bibliotecario/libros/inventario/registrar', [BibliotecarioController::class, 'inventario_create'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/libros/inventario.create');

    Route::post('/bibliotecario/libros/inventario/register', [BibliotecarioController::class, 'inventario_store'])
        ->name('/bibliotecario/libros/inventario.store');

    Route::get('/bibliotecario/libros/inventario/update/{id}', [BibliotecarioController::class, 'inventario_show'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/libros/inventario.show');

    Route::patch('/bibliotecario/libros/inventario/update/{id}', [BibliotecarioController::class, 'inventario_update'])
        ->name('/bibliotecario/libros/inventario.update');

    Route::delete('/bibliotecario/libros/inventario/delete/{id}', [BibliotecarioController::class, 'inventario_destroy'])
        ->name('/bibliotecario/libros/inventario.destroy');

        // PDFs

        Route::get('/bibliotecario/libros/inventario/pdf/filtro',[BibliotecarioController::class, 'filtroLibrosPDF_index'])
            ->name('/bibliotecario/libros/inventario/pdf/filtro.index');

        Route::post('/bibliotecario/libros/inventario/pdf/filtro',[BibliotecarioController::class, 'librosPDF_index'])
            ->name('/bibliotecario/libros/inventario/pdf/filtro.store');
    
    // INVENTARIO (LIBROS PDF)

    Route::get('/bibliotecario/libros/inventario/digitales/create', [BibliotecarioController::class, 'inventarioDigitales_create'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')
    ->name('bibliotecario/libros/inventario/digitales/create');

    Route::post('/bibliotecario/libros/inventario/digitales/store', [BibliotecarioController::class, 'inventarioDigitales_store'])
        ->name('bibliotecario/libros/inventario/digitales/store');

    Route::get('/bibliotecario/libros/inventario/digitales/update/{id}', [BibliotecarioController::class, 'inventarioDigitales_show'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('bibliotecario/libros/inventario/digitales.show');

    Route::patch('/bibliotecario/libros/inventario/digitales/update/{id}', [BibliotecarioController::class, 'inventarioDigitales_update'])
        ->name('bibliotecario/libros/inventario/digitales.update');

    Route::delete('/bibliotecario/libros/inventario/digitales/destroy/{id}', [BibliotecarioController::class, 'inventarioDigitales_destroy'])
        ->name('bibliotecario/libros/inventario/digitales.destroy');
        

// AUTORES

    Route::get('/bibliotecario/libros/autores',[BibliotecarioController::class, 'autores_index'])
        ->name('/bibliotecario/libros/autores.index');

    Route::post('/bibliotecario/libros/autores/register',[BibliotecarioController::class, 'autores_store'])
        ->name('/bibliotecario/libros/autores.store');

    Route::patch('/bibliotecario/libros/autores/modificar',[BibliotecarioController::class, 'autores_update'])
        ->name('/bibliotecario/libros/autores.update');

    Route::delete('/bibliotecario/libros/autores/delete/{id}',[BibliotecarioController::class, 'autores_destroy'])
        ->name('bibliotecario/libros/autores.destroy');

// EDITORIALES

    Route::get('/bibliotecario/libros/editoriales',[BibliotecarioController::class, 'editoriales_index'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/libros/editoriales.index');

    Route::post('/bibliotecario/libros/editoriales/register',[BibliotecarioController::class, 'editoriales_store'])
        ->name('/bibliotecario/libros/editoriales.store');

    Route::patch('/bibliotecario/libros/editoriales/update',[BibliotecarioController::class, 'editoriales_update'])
        ->name('/bibliotecario/libros/editoriales.update');

    Route::delete('/bibliotecario/libros/editoriales/delete/{id}',[BibliotecarioController::class, 'editoriales_destroy'])
        ->name('/bibliotecario/libros/editoriales.destroy');

// RUTA /SOLICITUDES

    Route::post('/bibliotecario/prestamos/registro/{id}', [BibliotecarioController::class, 'prestamoAceptado_store'])
    ->name('/bibliotecario/prestamos/registro.store');

// RUTA /PRESTAMOS

    Route::post('/bibliotecario/solicitudes/registro', [BibliotecarioController::class, 'solicitudes_store'])
    ->name('/bibliotecario/solicitudes/registro.store');

// PERFIL

    Route::get('bibliotecario/perfil/{id}', [BibliotecarioController::class, 'profile_show'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('bibliotecario/perfil.show');

    Route::patch('bibliotecario/perfil/{id}', [BibliotecarioController::class, 'profile_update'])
        ->name('bibliotecario/perfil.update');

    Route::post('bibliotecario/perfil/image/{id}', [BibliotecarioController::class, 'profile_imageUpdate'])
        ->name('bibliotecario/perfil/image.update');


//RUTA PARA BIBLIOTECARIO (PORTAL DE INVESTIGACION)

    Route::get('/bibliotecario/portal', [BibliotecarioController::class, 'index_portal'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('bibliotecario/portal.index');

    Route::get('/bibliotecario/portal-de-investigacion', [BibliotecarioController::class, 'portal_index'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/portal-de-investigacion.index');

    Route::post('/bibliotecario/portal-de-investigacion/store', [BibliotecarioController::class, 'portal_store'])
        ->name('/bibliotecario/portal-de-investigacion.store');

    Route::patch('/bibliotecario/portal-de-investigacion/update', [BibliotecarioController::class, 'portal_update'])
        ->name('/bibliotecario/portal-de-investigacion.update');

    Route::delete('/bibliotecario/portal-de-investigacion/destroy/{id}', [BibliotecarioController::class, 'portal_destroy'])
        ->name('/bibliotecario/portal-de-investigacion.destroy');


//////////////////////////APARTADO DE PUBLICACIONES/////////////////////////////////////////////////////////////77
    Route::get('/bibliotecario/publicaciones/index', [BibliotecarioController::class, 'publicaciones_index'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/publicaciones.index');

    Route::post('/bibliotecario/publicaciones/nueva-publicacion', [BibliotecarioController::class, 'publicaciones_store'])
        ->middleware('auth')
        ->middleware('auth.bibliotecario')
        ->name('/bibliotecario/publicaciones.store');

    Route::patch('/bibliotecario/publicacion/update', [BibliotecarioController::class, 'publicaciones_update'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')
    ->name('/bibliotecario/publicaciones.update');


    Route::delete('/bibliotecario/publicacion/destroy/{id}', [BibliotecarioController::class, 'publicaciones_destroy'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')
    ->name('/bibliotecario/publicaciones.destroy');


// RUTA BIBLIOTECARIO/VISITAS

    Route::get('/bibliotecario/visitas/index', [BibliotecarioController::class, 'logins_index'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')
    ->name('/bibliotecario/visitas.index');

    Route::get('/bibliotecario/visitas/pdf', [BibliotecarioController::class, 'loginsPDF_index'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')
    ->name('/bibliotecario/visitas/pdf.index');


    Route::post('/bibliotecario/visitas/pdf', [BibliotecarioController::class, 'loginsPDF_store'])
    ->name('/bibliotecario/visitas/pdf.store');

// RUTA BIBLIOTECARIO/EDICION-PDF

    Route::get('bibliotecario/edicion-pdf/', [BibliotecarioController::class, 'pdfPortada_index'])
        ->middleware('auth')
        ->name('bibliotecario/edicion-pdf.index');

    Route::get('bibliotecario/edicion-pdf/encabezado', [BibliotecarioController::class, 'pdfPortadaEncabezado_index'])
        ->middleware('auth')
        ->name('bibliotecario/edicion-pdf/encabezado.index');

    Route::post('bibliotecario/edicion-pdf/encabezado', [BibliotecarioController::class, 'pdfPortadaEncabezado_store'])
        ->name('bibliotecario/edicion-pdf/encabezado.store'); 

    Route::delete('bibliotecario/edicion-pdf/encabezado/eliminar/{id}',[BibliotecarioController::class, 'pdfPortadaEncabezado_destroy'])
        ->name('bibliotecario/edicion-pdf/encabezado/eliminar.destroy');

    Route::get('bibliotecario/edicion-pdf/pie', [BibliotecarioController::class, 'pdfPortadaPie_index'])
        ->middleware('auth')
        ->name('bibliotecario/edicion-pdf/pie.index'); 

    Route::post('bibliotecario/edicion-pdf/pie', [BibliotecarioController::class, 'pdfPortadaPie_store'])
        ->name('bibliotecario/edicion-pdf/pie.store'); 

    Route::delete('bibliotecario/edicion-pdf/pie/eliminar/{id}',[BibliotecarioController::class, 'pdfPortadaPie_destroy'])
        ->name('bibliotecario/edicion-pdf/pie/eliminar.destroy');

    Route::get('bibliotecario/edicion-pdf/portada', [BibliotecarioController::class, 'pdfPortadaCuerpo_index'])
        ->middleware('auth')
        ->name('bibliotecario/edicion-pdf/portada.index'); 
        
     Route::post('bibliotecario/edicion-pdf/portada', [BibliotecarioController::class, 'pdfPortadaCuerpo_store'])
        ->middleware('auth')
        ->name('bibliotecario/edicion-pdf/portada.store'); 

// SOLICITUDES

Route::get('/bibliotecario/solicitudes', [BibliotecarioController::class, 'solicitudes_index'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')  
    ->name('/bibliotecario/solicitudes.index');

Route::get('/bibliotecario/prestamos', [BibliotecarioController::class, 'prestamos_index'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')  
    ->name('/bibliotecario/prestamos.index');

Route::post('/bibliotecario/prestamoConfirmado', [BibliotecarioController::class, 'prestamoConfirmado_store'])
    ->middleware('auth')
    ->middleware('auth.bibliotecario')  
    ->name('/bibliotecario/prestamoConfirmado.store');

// ¿?
Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers'], function () {
        Route::get('general', 'AdminController@general');
    });

    
//backup
Route::get('/generar-backup', [BackupController::class, 'Backup'])->name('generar-backup');

//Ruta para enviar datos al JS

Route::get('/datos-js', [RegisterController::class, 'obtenerDatosJS']);

// PETICIONES AJAX

    Route::match(['get', 'post'], '/obtener-opciones/admin', [AdminController::class, 'obtenerOpcionesAdmin'])
    ->name('/obtener-opciones/admin');

    Route::match(['get', 'post'], '/obtener-opciones', [AlumnoController::class, 'obtenerOpciones'])
    ->name('/obtener-opciones');
    // ->middleware('auth')
    // ->middleware('auth.alumno');

    Route::match(['get', 'post'], '/obtener-opciones/inventario', [AlumnoController::class, 'obtenerOpcionesInventario'])
    ->name('/obtener-opciones/inventario');
    // ->middleware('auth')
    // ->middleware('auth.alumno');

    Route::match(['get', 'post'], '/obtener-opciones', [AlumnoController::class, 'obtenerOpciones'])
    ->name('/obtener-opciones');
    // ->middleware('auth')
    // ->middleware('auth.alumno');

    Route::match(['get', 'post'], '/obtener-libros', [AlumnoController::class, 'obtenerLibros'])
    ->name('/obtener-libros')
    ->middleware('auth')
    ->middleware('auth.alumno');

    Route::match(['get', 'post'], '/obtener-librosAlumno', [AlumnoController::class, 'obtenerLibrosAlumno'])
    ->name('/obtener-librosAlumno')
    ->middleware('auth')
    ->middleware('auth.alumno');

    Route::match(['get', 'post'], '/buscarLibros', [AlumnoController::class, 'buscarLibros'])
    ->name('/buscarLibros')
    ->middleware('auth')
    ->middleware('auth.alumno');


    // REPORTES

    Route::get('excel-csv-file', [ExcelCSVController::class, 'index']);
    Route::post('import-excel-csv-file', [ExcelCSVController::class, 'importExcelCSV']);
    Route::get('export-excel-csv-file', [ExcelCSVController::class, 'exportExcelCSV'])
            ->name('export-excel-csv-file');
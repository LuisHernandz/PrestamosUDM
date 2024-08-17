<?php

namespace App\Http\Controllers;

// Emails
use App\Mail\CodigoRegistroMailable;

// Modelos
use App\Models\Alumno;
use App\Models\Libro;
use App\Models\User;
use App\Models\Rol;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\Grado;
use App\Models\Grupo;
use App\Models\Nivel;
use App\Models\CarreraNivel;

// Notificaciones
use App\Notifications\SolicitudAceptadaNotification;
use App\Notifications\SolicitudRechazadaNotification;
use App\Notifications\SolicitudEnviadaNotification;
use App\Notifications\PrestamoAceptadoNotification;
use App\Notifications\PrestamoCanceladoNotification;
use App\Notifications\PrestamoFinalizadoNotification;
use App\Notifications\DiasFaltantesNotification;

// Otros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AlumnoController extends Controller
{

/////////////////////////////////////////////////////// PRINCIPALES ///////////////////////////////////////////////////////

    public function index(){
        return view('home'); 
    } 

    public function create(){
        // Definimos variables de sesión para posteriormente verificar si se pueden acceder a ciertas rutas
        session(['email_confirmado' => false]);
        session(['codigo_enviado' => false]);

        $roles = Rol::all();
        $generos = Genero::all();
        $grados = Grado::all();
        $grupos = Grupo::all();
        $niveles = Nivel::all();
        $carreras = Carrera::all(); 

        $carreraNivel = DB::select("
            SELECT  cn.id, c.car_nombre, n.niv_nombre
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id;
        ");

        return view('alumno.create', ['roles' => $roles, 'generos' => $generos, 'grados' => $grados, 'grupos' => $grupos, 'niveles' => $niveles, 'carreras' => $carreras,'carreraNivel' => $carreraNivel]);
    }

    public function confirmacion_store(Request $request){
        // Verificación
        
        $campos = [
            'alu_nombre' => 'required |regex:/^[\pL\s]+$/u',
            'alu_apellidos' => 'required | regex:/^[\pL\s]+$/u',
            'alu_telefono' => 'required | regex:/^[0-9 \-]+$/ | min:10',
            'curp' => 'required | alpha_num | between:18,18',
            'alu_domicilio' => 'required',
            'alu_matricula' => 'required | numeric',
            'generos_gen_id' => 'required',
            'carrera_nivels_id' => 'required',
            'grados_gra_id' => 'required',
            'grupos_gru_id' => 'required',
            'email' => 'required | email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]+$/',
            'password_confirmation' => 'required'
            
        ];

        $mensajes = [
            'alu_nombre.required' => 'El nombre es requerido.',
            'alu_nombre.regex' => 'El nombre solo debe de contener letras.',            
            'alu_apellidos.required' => 'Los apellidos son requeridos.',
            'alu_apellidos.regex' => 'Los apellidos solo deben contener letras.',
            'alu_telefono.required' => 'El número de teléfono es requerido.',
            'alu_telefono.regex' => 'Solo se aceptan números.',
            'alu_telefono.min' => '10 dígitos como mínimo.',
            'curp.required' => 'La CURP es requerida',
            'curp.alpha_num' => 'Solo se aceptan letras y números.',
            'curp.between' => 'La CURP debe contener 18 caracteres',
            'curp.max' => 'La CURP debe contener 18 caracteres.',
            'alu_domicilio.required' => 'El domicilio es requerido.',
            'alu_matricula.required' => 'La matrícula es requerida.',
            'alu_matricula.numeric' => 'Solo se aceptan números.',
            'generos_gen_id' => 'Este campo es requerido.',
            'carrera_nivels_id' => 'Este campo es requerido.',
            'grados_gra_id' => 'Este campo es requerido.',
            'grupos_gru_id' => 'Este campo es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un formato válido de correo electrónico.',
            'password.required' => 'La contraseña es requerida.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener una combinación de letras, números y símbolos.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password_confirmation.required' => 'Debes confirmar tu contraseña.'
            
        ];

        $this -> validate($request, $campos, $mensajes);

        // Verificar si ese correo ya existe en la base de datos. 
        $usuario = User::where('email', $request->email)->first();

        // Almacenar los datos en la sesión
        $request->session()->put('datos_alumno', $request->all());

        // Generamos el código
        $codigo = rand(1000, 9999);
        session(['codigoGenerado' => $codigo]);

        // Si ya existe un usuario con ese correo...
        if ($usuario) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Este correo ya está en uso.']);
        } else {
            // Enviamos el correo con el codigo
            $correo = new CodigoRegistroMailable($codigo);
            Mail::to($request->email)->send($correo);

            // Marcar el estado de envío en la sesión
            session(['codigo_enviado' => true]);

            // Redirigimos
            return redirect()->route('registro/confirmacion.create')->with([
                'codigo' => $codigo,
            ]);
        }
    }

    public function confirmacion_create(Request $request){
        // Verificar si el codigo ya se envio
        if (session('codigo_enviado')) {
            return view('alumno.confirmacion');
        }else{
            return redirect()->route('login.index');
        }
    }

    public function store(Request $request){

        // Validación de respuesta
        $campos = [
            'respuesta' => 'required|numeric|digits:4',
        ];
        
        $mensajes = [
            'respuesta.required' => 'Por favor, proporciona el código.',
            'respuesta.numeric' => 'El código debe ser numérico.',
            'respuesta.digits' => 'El código debe tener 4 dígitos.',
        ];

        $this -> validate($request, $campos, $mensajes);
        
        // Obtener datos

        $respuesta = $request->respuesta;
        $codigo = session('codigoGenerado');
        
        // Verificar si la respuesta concuerda con el codigo
        
        if ($respuesta = $codigo){
            //

            $niv_id = $request -> input('nivel');
            $car_id = $request -> input('carrera_nivels_id');
            
            $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
            ->where('carreras_car_id', $car_id)   
            ->value('id');

            // Registrar al alumno
            $user = User::create(request(['email', 'password', 'roles_rol_id']));

            $alumno = new Alumno; // Crear nuevo registro
            $alumno -> alu_matricula = $request -> alu_matricula;
            $alumno -> alu_nombre = $request-> alu_nombre; // Asignar cada uno de los valores
            $alumno -> alu_apellidos = $request-> alu_apellidos;
            $alumno -> curp = $request -> curp; 
            $alumno -> generos_gen_id = $request -> generos_gen_id;
            $alumno -> alu_telefono = $request -> alu_telefono; 
            $alumno -> alu_domicilio = $request -> alu_domicilio; 
            $alumno -> carrera_nivels_id = $carreraNiveles_id;
            $alumno -> grados_gra_id = $request->grados_gra_id; 
            $alumno -> grupos_gru_id = $request->grupos_gru_id; 
            $alumno -> usuarios_id = $user -> id; 
            $alumno ->save(); // Guardar nuevo registro en la tabla de la base de datos

            session(['email_confirmado' => true]);

            return view('alumno.exito');
        }
        $mensaje = 'Código inválido, por favor inténtalo de nuevo.';

        return redirect()->route('registro/confirmacion.create')->with([
            'mensaje' => $mensaje,
        ]);
          
    }

    public function exito_create(){
        // Verificar si el email ya se verifico
        if (session('email_confirmado')) {
            return view('alumno.exito');
        }else{
            return redirect()->route('login.index');
        }
        
    }

/////////////////////////////////////////////////////// VISTA DE LIBROS FÍSICOS /////////////////////////////////////////////////////////////////////////////////////

    public function index_librosFisicos(){
        $niveles = Nivel::all();

        $libros = DB::table('autor_libros as al')
        ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
        ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
        ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
        ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
        ->whereNull('l.lib_archivo') 
        ->get();

        $alumnos = DB::select("SELECT a.id, a.alu_nombre, a.alu_apellidos, a.usuarios_id, a.carrera_nivels_id, usuarios.id, usuarios.email, usuarios.foto, cn.*, c.*, n.*
        FROM alumnos a
        LEFT JOIN usuarios ON a.usuarios_id = usuarios.id
        LEFT JOIN carrera_nivels cn ON cn.id = a.carrera_nivels_id 
        LEFT JOIN carreras c ON c.car_id = cn.carreras_car_id
        LEFT JOIN nivel n ON n.niv_id = cn.nivel_niv_id");

        $carrera_id = null;

        foreach ($alumnos as $usuario) {
            if (auth()->user()->id == $usuario->usuarios_id) {
                $carrera_id = $usuario->carreras_car_id;
                break; // Si encuentras la coincidencia, puedes detener el bucle 
            }
        } 


        // return view('alumno.libros.index', ['niveles' => $niveles, 'libros' => $libros, 'carrera_id' => $carrera_id]); 
        return view('alumno.libros.index', compact('niveles', 'libros', 'carrera_id'));

    }

    public function obtenerOpciones(Request $request){
        $opcionSeleccionada = $request->input('opcionSeleccionada');
        // $opcionSeleccionada = 1;

        $opcionesRelacionadas = DB::select("
            SELECT  cn.id, cn.carreras_car_id, c.car_nombre, n.niv_nombre, n.niv_id
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id
            WHERE c.car_nombre <> 'Todas' AND niv_id = :opcionSeleccionada;
            ", ['opcionSeleccionada' => $opcionSeleccionada]);

        $htmlOptions = ''; 

        foreach ($opcionesRelacionadas as $opcion) {
            $htmlOptions .= '<option value="' . $opcion->carreras_car_id . '">' . $opcion->car_nombre . '</option>';
        }

        return $htmlOptions;
    }

    public function obtenerOpcionesInventario(Request $request){
        $opcionSeleccionada = $request->input('opcionSeleccionada');
        // $opcionSeleccionada = 1;

        $opcionesRelacionadas = DB::select("
            SELECT  cn.id, cn.carreras_car_id, c.car_nombre, n.niv_nombre, n.niv_id
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id
            WHERE niv_id = :opcionSeleccionada;
            ", ['opcionSeleccionada' => $opcionSeleccionada]);

        $htmlOptions = ''; 

        foreach ($opcionesRelacionadas as $opcion) {
            $htmlOptions .= '<option value="' . $opcion->carreras_car_id . '">' . $opcion->car_nombre . '</option>';
        }

        return $htmlOptions;
    }

    public function obtenerLibrosAlumno(Request $request){
        $carrera_id = $request->input('carrera_id');

        $carrera = Carrera::find($carrera_id); // Buscar la carrera
        $carreraNombre = $carrera -> car_nombre;

        // return $carreraNombre;

        $libros = DB::table('autor_libros as al')
            ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
            ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
            ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
            ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
            ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
            ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
            ->where('c.car_id', '=', $carrera_id )
            ->whereNull('l.lib_archivo') 
            ->get();

        $datosLibro = [];
        $htmlOptions = [];

        foreach ($libros as $libro) {

            $lib_titulo = $libro->lib_titulo;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_titulo) > 30) {
                $lib_titulo = substr($lib_titulo, 0, 30) . '...';
            }

            $lib_autor = $libro->aut_nombre;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_autor) > 30) {
                $lib_autor = substr($lib_autor, 0, 30) . '...';
            }

            
            if ($libro -> lib_foto === 'Sin Imagen') {
                $lib_foto = 'uploads/SinImagen.png';
            } else {
                $lib_foto = $libro -> lib_foto;
            }
  
            $htmlOptions[] = [ 
                                '<div class="img-container">'.'<img src="'. asset('storage').'/' . $lib_foto . '">' . '</img>'.'</div>',
                                
                                '<p class="book-ejemplares">'. $libro->lib_ejemplares. '</p>',
                                '<p class="book-eDisponibles">'. $libro->lib_eDisponibles. '/</p>',
                               '<p class="book-title">' . $lib_titulo . '</p>', 
                               '<p class="book-author">' . $lib_autor . '</p>',
                                ];
                            //   {{ asset('storage').'/'.$libro -> lib_foto }}

            $datosLibro[] = $libro->lib_id;
        }


        
        return [$htmlOptions, $carreraNombre, $datosLibro];
    }

    public function obtenerLibros(Request $request){
        $opcionSeleccionada = $request->input('opcionSeleccionada');
        // $opcionSeleccionada = 6;

        $carrera = Carrera::find($opcionSeleccionada); // Buscar la carrera


        $carreraNombre = $carrera -> car_nombre;

        $libros = DB::table('autor_libros as al')
            ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
            ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
            ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
            ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
            ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
            ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
            ->where('c.car_id', '=', $opcionSeleccionada )
            ->whereNull('l.lib_archivo') 
            ->get();
        

        $datosLibro = [];
        $htmlOptions = []; 


        foreach ($libros as $libro) {

            $lib_titulo = $libro->lib_titulo;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_titulo) > 30) {
                $lib_titulo = substr($lib_titulo, 0, 30) . '...';
            }

            $lib_autor = $libro->aut_nombre;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_autor) > 30) {
                $lib_autor = substr($lib_autor, 0, 30) . '...';
            }

            if ($libro -> lib_foto === 'Sin Imagen') {
                $lib_foto = 'uploads/SinImagen.png';
            } else {
                $lib_foto = $libro -> lib_foto;
            } 
            
        
            $htmlOptions[] = [ 
                                '<div class="img-container">'.'<img src="'. asset('storage').'/' . $lib_foto . '">' . '</img>'.'</div>',
                                '<p class="book-ejemplares">'. $libro->lib_ejemplares. '</p>',
                                '<p class="book-eDisponibles">'. $libro->lib_eDisponibles. '/</p>',
                               '<p class="book-title">' . $lib_titulo . '</p>', 
                               '<p class="book-author">' . $lib_autor . '</p>',
                                ];
                            //   {{ asset('storage').'/'.$libro -> lib_foto }}

            $datosLibro[] = $libro->lib_id;
        }

        return [$htmlOptions, $carreraNombre, $datosLibro];

    }

    public function buscarLibros(Request $request){
        $dato = $request->input('query');


        $libros = DB::table('autor_libros as al')
        ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
        ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
        ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
        ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
        ->where(function ($query) use ($dato) {
            $query->where('l.lib_titulo', 'LIKE', '%' . $dato . '%')
                ->orWhere('a.aut_nombre', 'LIKE', '%' . $dato . '%');
        })
        ->whereNull('l.lib_archivo') // Agrega este filtro para lib_archivo nulo
        ->get();

            
        // return $libros;
        $datosLibro = [];
        $htmlOptions = [];

        foreach ($libros as $libro) {

            $lib_titulo = $libro->lib_titulo;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_titulo) > 30) {
                $lib_titulo = substr($lib_titulo, 0, 30) . '...';
            }

            $lib_autor = $libro->aut_nombre;
            // Verificar si el título supera los 30 caracteres y ajustarlo con puntos suspensivos si es necesario
            if (strlen($lib_autor) > 30) {
                $lib_autor = substr($lib_autor, 0, 30) . '...';
            }

            if ($libro -> lib_foto === 'Sin Imagen') {
                $lib_foto = 'uploads/SinImagen.png';
            } else {
                $lib_foto = $libro -> lib_foto;
            }
  
            $htmlOptions[] = [ 
                                '<div class="img-container">'.'<img src="'. asset('storage').'/' . $lib_foto . '">' . '</img>'.'</div>',
                                '<p class="book-ejemplares">'. $libro->lib_ejemplares. '</p>',
                                '<p class="book-eDisponibles">'. $libro->lib_eDisponibles. '/</p>',
                               '<p class="book-title">' . $lib_titulo . '</p>', 
                               '<p class="book-author">' . $lib_autor . '</p>',
                                ];
                            //   {{ asset('storage').'/'.$libro -> lib_foto }}

            $datosLibro[] = $libro->lib_id;
        }

        return [$htmlOptions, $datosLibro];

    }

    public function index_librosDigitales(){
        $niveles = Nivel::all();

        $libros = DB::table('autor_libros as al')
        ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
        ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
        ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
        ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
        ->whereNotNull('l.lib_archivo') 
        ->get();

 
        $alumnos = DB::select("SELECT a.id, a.alu_nombre, a.alu_apellidos, a.usuarios_id, a.carrera_nivels_id, usuarios.id, usuarios.email, usuarios.foto, cn.*, c.*, n.*
        FROM alumnos a
        LEFT JOIN usuarios ON a.usuarios_id = usuarios.id
        LEFT JOIN carrera_nivels cn ON cn.id = a.carrera_nivels_id 
        LEFT JOIN carreras c ON c.car_id = cn.carreras_car_id
        LEFT JOIN nivel n ON n.niv_id = cn.nivel_niv_id"); 

        $carrera_id = null;

        foreach ($alumnos as $usuario) {
            if (auth()->user()->id == $usuario->usuarios_id) {
                $carrera_id = $usuario->carreras_car_id;
                break; // Si encuentras la coincidencia, puedes detener el bucle
            }
        } 


        // return view('alumno.libros.index', ['niveles' => $niveles, 'libros' => $libros, 'carrera_id' => $carrera_id]); 
        return view('alumno.libros.index_digitales', compact('niveles', 'libros', 'carrera_id'));

    }


/////////////////////////////////////////////////////// APARTADO DEL PERFIL DE USUARIO //////////////////////////////////////////////////////////////////////////////

    public function profile_show($id){

        $usuario =  User::find($id);
        $usuarios_id = $usuario -> id;

        $generos = Genero::all(); 

        // $admin = Administrador::where('usuarios_id', $usuarios_id)->first();

        $alumnoCadena = DB::select("
            SELECT a.*, usuarios.id, usuarios.email, usuarios.foto, cn.*, c.*, n.*, generos.*
            FROM alumnos a
            LEFT JOIN usuarios ON a.usuarios_id = usuarios.id
            LEFT JOIN carrera_nivels cn ON cn.id = a.carrera_nivels_id 
            LEFT JOIN carreras c ON c.car_id = cn.carreras_car_id 
            LEFT JOIN nivel n ON n.niv_id = cn.nivel_niv_id
            LEFT JOIN generos ON a.generos_gen_id = generos.gen_id
            WHERE usuarios.id = $usuarios_id;
        ");

        $alumno = $alumnoCadena[0]; 

        $notificacionesSA = auth()->user()->notifications->where('type', SolicitudAceptadaNotification::class);
        $notificacionesSE = auth()->user()->notifications->where('type', SolicitudEnviadaNotification::class);
        $notificacionesSR = auth()->user()->notifications->where('type', SolicitudRechazadaNotification::class);
        $notificacionesPA = auth()->user()->notifications->where('type', PrestamoAceptadoNotification::class);
        $notificacionesPC = auth()->user()->notifications->where('type', PrestamoCanceladoNotification::class);  
        $notificacionesPF = auth()->user()->notifications->where('type', PrestamoFinalizadoNotification::class);  
        $notificacionesDF = auth()->user()->notifications->where('type', DiasFaltantesNotification::class); 

        auth()->user()->unreadNotifications->where('type', SolicitudAceptadaNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', SolicitudEnviadaNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', SolicitudRechazadaNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', PrestamoAceptadoNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', PrestamoCanceladoNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', PrestamoFinalizadoNotification::class)->markAsRead();
        auth()->user()->unreadNotifications->where('type', DiasFaltantesNotification::class)->markAsRead();

        return view('alumno.perfil.index', ['usuario' => $usuario, 'alumno' => $alumno, 'generos' => $generos, 'notificacionesSA' => $notificacionesSA, 'notificacionesSR' => $notificacionesSR, 'notificacionesPA' => $notificacionesPA, 'notificacionesPC' => $notificacionesPC,  'notificacionesPF' => $notificacionesPF, 'notificacionesDF' => $notificacionesDF, 'notificacionesSE' => $notificacionesSE ]); 

    }

    public function profile_update(Request $request, $id){

        // Modificar datos del Usuario
        $usuarioModificado = request() -> except(['_token','_method','alu_nombre', 'alu_apellidos', 'generos_gen_id', 'curp', 'alu_domicilio', 'alu_telefono']); 
            
        User::where('id','=',$id) -> update($usuarioModificado);

        // Modificar datos del Bibliotecario
        $alumnoModificado = request()-> except(['_token','_method','email']);

        Alumno::where('usuarios_id','=',$id) -> update($alumnoModificado);

        return redirect()->route('/perfil.show', ['id' => $id]) -> with('success', 'Datos actualizados con éxito.');
        

    }

    public function profile_imageUpdate(Request $request, $id){

        // Modificar datos del Usuario
        $newFoto = request() -> except(['_token','_method']);

        if($request -> hasFile('foto')){

            $usuario = User::findOrFail($id);
            Store::delete('public/'.$usuario -> foto);

            $newFoto['foto'] = $request -> file('foto') -> store('uploads', 'public');
        }

        User::where('id','=',$id) -> update($newFoto);

        return redirect()->route('bibliotecario/perfil.show', ['id' => $id]);
    }


/////////////////////////////////////////////////////// APARTADO DEL PORTAL DE INVESTIGACIÓN ////////////////////////////////////////////////////////////////////////

    public function index_portal(){

        $enlaces = DB::select("
            SELECT p.*
            FROM portal_de_investigacions p            
        ");

        return view('alumno.portal.index', compact('enlaces'));
    }


/////////////////////////////////////////////////////// APARTADO DEL PUBLICACIONES //////////////////////////////////////////////////////////////////////////////////

    public function index_publicaciones(){

        $publicaciones = DB::table('publicaciones as p')
        ->leftJoin('usuarios as u', 'p.usuarios_id', '=', 'u.id')
        ->leftJoin('bibliotecarios as b', 'u.id', '=', 'b.usuarios_id')
        ->leftJoin('administradores as a', 'u.id', '=', 'a.usuarios_id')
        ->leftJoin('roles as r', 'u.roles_rol_id', '=', 'r.rol_id')
        ->select('p.*', 'bib_nombre', 'bib_apellidos', 'adm_nombre', 'adm_apellidos', 'u.foto', 'r.rol_id')
        ->orderBy('id', 'desc') // Ordenar por fecha en orden descendente
        ->get();

        foreach ($publicaciones as $publicacion) {
            // Formatear el campo created_at usando Carbon
            $publicacion->created_at = Carbon::parse($publicacion->created_at)->format('d/m/Y H:i');
        }

        return view('alumno.publicaciones.index', ['publicaciones' => $publicaciones]);
    }
}

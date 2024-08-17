<?php

namespace App\Http\Controllers;

// Modelos
use App\Models\User;
use App\Models\Rol;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\CarreraNivel;
use App\Models\Grado;
use App\Models\Grupo;
use App\Models\Nivel;
use App\Models\Alumno;
use App\Models\Bibliotecario;
use App\Models\Administrador;
use App\Models\Autor;
use App\Models\Editorial;
use App\Models\Libro;
use App\Models\AutorLibro;
use App\Models\Publicacion;
use App\Models\PortalDeInvestigacion;
use App\Models\PdfEncabezado;
use App\Models\PdfPiePagina;
use App\Models\PdfImagenPortada;

// Otros
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;
use ConsoleTvs\Charts\Facades\Charts;
use Carbon\Carbon; 
use PDF;


class AdminController extends Controller
{

/////////////////////////////////////////////////////// VISTA PRINCIPAL DEL ADMINISTRADOR ///////////////////////////////////////////////////////

    public function index(){ 
        return view('admin.index');
    }   

/////////////////////////////////////////////////////// BIBLIOTECARIOS ///////////////////////////////////////////////////////
 
    public function index_bibliotecarios(){
        $usuarios = DB::table('bibliotecarios as b')
        ->leftJoin('generos as g', 'b.generos_gen_id', '=', 'g.gen_id')
        ->leftJoin('usuarios as u', 'b.usuarios_id', '=', 'u.id')
        ->leftJoin('roles as r', 'u.roles_rol_id', '=', 'r.rol_id')
        ->select('b.*', 'g.*', 'u.id', 'u.email', 'u.foto', 'r.rol_id', 'r.rol_nombre')
        ->paginate(5); 

        return view('admin.bibliotecarios.index',['usuarios' => $usuarios]);
    }

    public function create_bibliotecarios(){
        $generos = Genero::all();

        return view('admin.bibliotecarios.create', ['generos' => $generos]);
    }

    public function store_bibliotecarios(Request $request){

        $campos = [
            'bib_nombre' => 'required |regex:/^[\pL\s]+$/u',
            'bib_apellidos' => 'required | regex:/^[\pL\s]+$/u',
            'telefono' => 'required | regex:/^[0-9 \-]+$/ | min:10',
            'domicilio' => 'required',
            'generos_gen_id' => 'required',
            'email' => 'required | email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]+$/',
            'password_confirmation' => 'required',
        ];

        $mensajes = [
            'bib_nombre.required' => 'El nombre es requerido.',
            'bib_nombre.regex' => 'El nombre solo debe contener letras.',            
            'bib_apellidos.required' => 'Los apellidos son requeridos.',
            'bib_apellidos.regex' => 'Los apellidos solo deben contener letras.',
            'telefono.required' => 'El número de teléfono es requerido.',
            'telefono.regex' => 'Solo se aceptan números.',
            'telefono.min' => '10 dígitos como mínimo.',
            'domicilio.required' => 'El domicilio es requerido.',
            'generos_gen_id' => 'Este campo es requerido.',
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

        $user = User::create(request(['email', 'password', 'roles_rol_id']));

        $bibliotecario = new Bibliotecario; // Crear nuevo registro
        $bibliotecario -> bib_nombre = $request-> bib_nombre; // Asignar cada uno de los valores
        $bibliotecario -> bib_apellidos = $request-> bib_apellidos;
        $bibliotecario -> generos_gen_id = $request -> generos_gen_id;
        $bibliotecario -> telefono = $request -> telefono; 
        $bibliotecario -> domicilio = $request -> domicilio; 
        $bibliotecario -> usuarios_id = $user -> id; 
        $bibliotecario ->save(); // Guardar nuevo registro en la tabla de la base de datos
        
        return redirect()->route('/admin/usuarios/bibliotecarios.index')->with('success', 'Bibliotecario registrado con éxito.');
    }

    public function show_bibliotecarios($id){

        $usuario = User::find($id);
        $usuarios_id = $usuario -> id;
        $bibliotecario = Bibliotecario::where('usuarios_id', $usuarios_id)->first();

        $roles = Rol::all();
        $generos = Genero::all();

        $genero = Genero::where('gen_id', $bibliotecario -> generos_gen_id)->first();

        return view('admin.bibliotecarios.edit', ['usuario' => $usuario, 'bibliotecario' => $bibliotecario, 'generos' => $generos, 'genero' => $genero, 'roles' => $roles]);
    }

    public function update_bibliotecarios(Request $request, $id){
        $campos = [
            'bib_nombre' => 'required |regex:/^[\pL\s]+$/u',
            'bib_apellidos' => 'required | regex:/^[\pL\s]+$/u',
            'telefono' => 'required | regex:/^[0-9 \-]+$/ | min:10',
            'domicilio' => 'required',
            'generos_gen_id' => 'required',
            'email' => 'required | email',
        ];

        $mensajes = [
            'bib_nombre.required' => 'El nombre es requerido.',
            'bib_nombre.regex' => 'El nombre solo debe contener letras.',            
            'bib_apellidos.required' => 'Los apellidos son requeridos.',
            'bib_apellidos.regex' => 'Los apellidos solo deben contener letras.',
            'telefono.required' => 'El número de teléfono es requerido.',
            'telefono.regex' => 'Solo se aceptan números.',
            'telefono.min' => '10 dígitos como mínimo.',
            'domicilio.required' => 'El domicilio es requerido.',
            'generos_gen_id' => 'Este campo es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un formato válido de correo electrónico.',        
        ];

        $this -> validate($request, $campos, $mensajes);
        
        $usuarioModificado = request() -> except(['_token','_method','bib_nombre', 'bib_apellidos', 'domicilio', 'telefono', 'generos_gen_id']);
            
        User::where('id','=',$id) -> update($usuarioModificado);

        $bibliotecarioModificado = request()-> except(['_token','_method','email', 'roles_rol_id']);

        Bibliotecario::where('usuarios_id','=',$id) -> update($bibliotecarioModificado);

        return redirect() -> route('/admin/usuarios/bibliotecarios.index') -> with('success', 'Bibliotecario modificado con éxito.');

    }

    public function destroy_bibliotecarios($id){

        $usuario = User::findOrFail($id);

        if (!empty($usuario->foto)) {
            Storage::delete('public/' . $usuario->foto);
        }
    
        $usuario->delete();

        return redirect() -> route('/admin/usuarios/bibliotecarios.index') -> with('success', 'Bibliotecario eliminado con éxito.');
    }

/////////////////////////////////////////////////////// ALUMNOS ////////////////////////////////////////////////////////////////////////////////////////

    public function index_alumnos(Request $request){
 
        $busqueda = trim($request -> get('busqueda'));
        
        $usuarios = DB::table('alumnos as a')
        ->leftJoin('usuarios as u', 'a.usuarios_id', '=', 'u.id')
        ->leftJoin('roles as r', 'u.roles_rol_id', '=', 'r.rol_id')
        ->leftJoin('generos as g', 'a.generos_gen_id', '=', 'g.gen_id')
        ->leftJoin('carrera_nivels as cn', 'a.carrera_nivels_id', '=', 'cn.id')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->leftJoin('grados as gra', 'a.grados_gra_id', '=', 'gra.gra_id')
        ->leftJoin('grupos as gru', 'a.grupos_gru_id', '=', 'gru.gru_id')
        ->select('a.*', 'u.id', 'u.email', 'u.foto', 'r.rol_id', 'r.rol_nombre', 'g.gen_nombre', 'c.car_nombre', 'n.niv_nombre', 'gra.gra_nombre', 'gru.gru_nombre')
        ->where('alu_nombre', 'LIKE', '%'.$busqueda.'%')
        ->orWhere('alu_apellidos', 'LIKE', '%'.$busqueda.'%') 
        ->orWhere('alu_matricula', 'LIKE', '%'.$busqueda.'%')  
        ->orderBy('alu_nombre', 'asc')
        ->paginate(5);   
        

        return view('admin.alumnos.index', ['usuarios' => $usuarios, 'busqueda' => $busqueda]);
    } 
    
    public function create_alumnos(){  
        $roles = Rol::all();
        $generos = Genero::all();
        $grados = Grado::all();
        $grupos = Grupo::all();
        $niveles = Nivel::where('niv_nombre', '!=', 'Todos')->get();
        $carreras = Carrera::where('car_nombre', '!=', 'Todas')->get();

        $carreraNivel = DB::select("
            SELECT  cn.id, c.car_nombre, n.niv_nombre
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id;
        ");
        
        //return $carreraNivel;

        return view('admin.alumnos.create', ['roles' => $roles, 'generos' => $generos, 'grados' => $grados, 'grupos' => $grupos, 'niveles' => $niveles, 'carreras' => $carreras, 'carreraNivel' => $carreraNivel ]);
    }

    public function obtenerOpcionesAdmin(Request $request){ 
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

    public function store_alumnos(Request $request){

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

        //

        $niv_id = $request -> input('nivel');
        $car_id = $request -> input('carrera_nivels_id');
        
        $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
        ->where('carreras_car_id', $car_id)   
        ->value('id');

        // Si ya existe un usuario con ese correo...
        if ($usuario) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Este correo ya está en uso.']);
        }else{
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
            
            return redirect()->route('admin/usuarios/alumnos.index')->with('success', 'Alumno registrado con éxito.');
        }


    }

    public function show_alumnos($id){

        $roles = Rol::all();
        $generos = Genero::all();
        $grados = Grado::all();
        $grupos = Grupo::all();
        $niveles = Nivel::where('niv_nombre', '!=', 'Todos')->get();
        $carreras = Carrera::all();

        
        $usuario = User::find($id);
        $usuarios_id = $usuario -> id;

        $alumno = Alumno::where('usuarios_id', $usuarios_id)->first();

        $carreraNivel = DB::select("
            SELECT  cn.*, c.car_nombre, n.*
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id
            WHERE $alumno->carrera_nivels_id = cn.id;
        ");

        $carrera = $carreraNivel[0];
        $carrera_nivels = $carreraNivel[0]->niv_id;

        $nivel = Nivel::where('niv_id', $carrera_nivels)->first();
        $grado = Grado::where('gra_id', $alumno -> grados_gra_id)->first();
        $grupo = Grupo::where('gru_id', $alumno -> grupos_gru_id)->first();

        return view('admin.alumnos.edit', ['roles' => $roles, 'generos' => $generos, 'grados' => $grados, 'grado' => $grado, 'grupos' => $grupos, 'grupo' => $grupo, 'niveles' => $niveles, 'nivel' => $nivel, 'carreraNivel' => $carreraNivel,'carrera' => $carrera, 'carreras' => $carreras, 'usuario' => $usuario, 'alumno' => $alumno ]);
        
    }

    public function update_alumnos(Request $request, $id){ 

        $campos = [
            'alu_nombre' => 'required |regex:/^[\pL\s]+$/u',
            'alu_apellidos' => 'required | regex:/^[\pL\s]+$/u',
            'alu_telefono' => 'required | regex:/^[0-9 \-]+$/ | min:10',
            'curp' => 'required | alpha_num | between:18,18',
            'alu_domicilio' => 'required',
            'alu_matricula' => 'required | numeric',
            // 'generos_gen_id' => 'required',
            'grados_gra_id' => 'required',
            'grupos_gru_id' => 'required',
            'email' => 'required | email',
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
            'grados_gra_id' => 'Este campo es requerido.',
            'grupos_gru_id' => 'Este campo es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un formato válido de correo electrónico.',
        ];

        $this -> validate($request, $campos, $mensajes);


        $usuarioModificado = request() -> except(['_token','_method','alu_matricula', 'alu_nombre', 'alu_apellidos', 'curp', 'alu_domicilio', 'alu_telefono','nivel', 'carrera_nivels_id', 'grupos_gru_id', 'grados_gra_id']);
        User::where('id','=',$id) -> update($usuarioModificado);
        
        $niv_id = $request->input('nivel');
        $car_id = $request->input('carrera_nivels_id'); 

        // Consulta para obtener el valor de $carreraNiveles_id
        $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
            ->where('carreras_car_id', $car_id)
            ->value('id');

        // Actualización de datos del alumno, incluyendo carrera_nivels_id
        $alumnoModificado = request()->except(['_token', '_method', 'email', 'roles_rol_id', 'nivel', 'carrera_nivels_id']);
        $alumnoModificado['carrera_nivels_id'] = $carreraNiveles_id;

        Alumno::where('usuarios_id', '=', $id)->update($alumnoModificado);

        return redirect() -> route('admin/usuarios/alumnos.index') -> with('success', 'Alumno modificado con éxito.');

    }

    public function destroy_alumnos($id){
        $usuario = User::findOrFail($id);

        if (!empty($usuario->foto)) {
            Storage::delete('public/' . $usuario->foto);
        }
    
        $usuario->delete();
    
        return redirect() -> route('admin/usuarios/alumnos.index') -> with('success', 'Alumno eliminado con éxito.');
    }

/////////////////////////////////////////////////////// APARTADO DE CARRERAS ///////////////////////////////////////////////////////////////////////////////////////

    public function carrera_index($id){
        $carreraNiveles = DB::table('carrera_nivels as cn')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select('cn.id', 'c.*', 'n.*')
        ->where('n.niv_id', $id)
        ->paginate(5);

        $nivel_id = $id;

        return view('admin.carreras.index', ['carreraNiveles' => $carreraNiveles, 'nivel_id' => $nivel_id]);
    }

    public function carrera_store(Request $request){
        $campos = [
            'car_nombre' => 'required',
        ];

        $mensajes = [
            'car_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);

        $car_nombre = $request->input('car_nombre');

        $carrera = Carrera::create([
            'car_nombre' => $car_nombre
        ]);

        $idCarrera = $carrera -> car_id;

        $idNivel = $request->input('niv_id');

        $carreraNivel = CarreraNivel::create([
            'carreras_car_id' => $idCarrera,
            'nivel_niv_id' => $idNivel,
        ]);

        return redirect()->route('admin/carreras.index', ['id' => $idNivel])->with('success', 'Nueva carrera registrada con éxito.');
    }

    public function carrera_update(Request $request){
        $campos = [
            'car_nombre' => 'required',
        ];

        $mensajes = [
            'car_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);

        $car_id = $request->input('car_id');
        $car_nombre = $request->input('car_nombre');
    
        Carrera::where('car_id', $car_id)->update([
            'car_nombre' => $car_nombre
        ]);

        return back()->with('success', 'Carrera actualizada con éxito.');
    }
    
    public function carrera_destroy($id){
        $carrera = CarreraNivel::where('carreras_car_id', $id)->first();
        
        $ni_id = $carrera->nivel_niv_id;
        $cn_id = $carrera->id;

        CarreraNivel::destroy($cn_id);
        Carrera::destroy($id);
    
        return redirect()->route('admin/carreras.index', ['id' => $ni_id])->with('success', 'Carrera eliminada con éxito.');
    }

/////////////////////////////////////////////////////// APARTADO DE INVENTARIO /////////////////////////////////////////////////////////////////////////////////////

    public function inventario_index(Request $request){

        $busqueda = trim($request -> get('busqueda')); 
        $orden = $request -> input('orden'); 

        if (isset($orden)) {
            if ($orden === "recientes") {
                $libros = DB::table('autor_libros as al')
                ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
                ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
                ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
                ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
                ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
                ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
                ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
                ->where('lib_titulo', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('aut_nombre', 'LIKE', '%'.$busqueda.'%')
                ->orderBy('l.lib_id', 'desc')
                ->paginate(6);
            } else {
                $libros = DB::table('autor_libros as al')
                ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
                ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
                ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
                ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
                ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
                ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
                ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
                ->where('lib_titulo', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('aut_nombre', 'LIKE', '%'.$busqueda.'%')
                ->orderBy('l.lib_titulo', 'asc')
                ->paginate(6);
            }
            
        } else {
            $libros = DB::table('autor_libros as al')
            ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
            ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
            ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
            ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
            ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
            ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
            ->where('lib_titulo', 'LIKE', '%'.$busqueda.'%')
            ->orWhere('aut_nombre', 'LIKE', '%'.$busqueda.'%')
            ->orderBy('l.lib_id', 'desc') 
            ->paginate(6);
        }
        
        return view('admin.libros.inventario.index', ['libros' => $libros, 'busqueda' => $busqueda, 'orden' => $orden]);
    }

    public function inventario_create(){

        // $autores = Autor::all(); 
        $autores = DB::table('autores as a')
        ->select('a.*')
        ->orderBy('a.aut_nombre', 'asc') 
        ->get();

        // $editoriales = Editorial::all();

        $editoriales = DB::table('editoriales as e')
        ->select('e.*')
        ->orderBy('e.edi_nombre', 'asc') 
        ->get();

        $carreras = Carrera::all();
        $niveles = Nivel::all();
        $carreraNiveles = CarreraNivel::all(); 


        return view('admin.libros.inventario.create', [
            'autores' => $autores, 
            'editoriales' => $editoriales,
            'carreras' => $carreras,
            'niveles' => $niveles,
            'carreraNiveles' => $carreraNiveles,
        ]);
    }

    public function inventario_store(Request $request){
        
        $campos = [
            'lib_titulo' => 'required',
            'autores_aut_id' => 'required',
            'carrera_nivels_id' => 'required',        
        ];

        $mensajes = [
            'lib_titulo.required' => 'El titulo del libro es requerido.',
            'autores_aut_id.required' => 'Este campo es requerido.',
            'carrera_nivels_id' => 'Este campo es requerido.',       
        ];

        $this -> validate($request, $campos, $mensajes);


        // RECIBIR DATOS

        $newLibro = $request->except(['_token', 'autores_aut_id', 'carrera_nivels_id']);
        $niv_id = $request -> input('nivel');
        $car_id = $request -> input('carrera_nivels_id');

        $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
            ->where('carreras_car_id', $car_id)
            ->value('id'); 

       // EDITORIAL 

        $editorial = $request -> input('editoriales_edi_id');

            if ($editorial === 'agregar-nueva-editorial') {
                // Verificar si ya existe editorial 
                $editoriales = Editorial::all();
                foreach ($editoriales as $editorial) {
                    if ($editorial->edi_nombre === $request->input('edi_nombre')) {
                        return redirect()->back()->withInput()->withErrors(['editorial_repetida' => 'Editorial repetida.']); 
                    }    
                } 

                    $nuevaEditorial = Editorial::create([
                        'edi_nombre' => $request->input('edi_nombre'),
                    ]);
                    $editoriales_edi_id = $nuevaEditorial->edi_id;
                    $newLibro['editoriales_edi_id'] = $editoriales_edi_id;
            }else{
                $newLibro['editoriales_edi_id'] = $editorial;
            }

        // AUTOR

        $autor= $request->input('autores_aut_id');
        if ($autor === 'agregar-nuevo-autor'){
            // Verificar si ya existe autor 
            $autores = Autor::all();  

            foreach ($autores as $autor) {
                if ($autor->aut_nombre === $request->input('aut_nombre')) {
                    return redirect()->back()->withInput()->withErrors(['autor_repetido' => 'Autor repetido.']); 
                }     
            } 
        
            $nuevoAutor = Autor::create([
                'aut_nombre' => $request->input('aut_nombre'),
            ]);

            $autores_aut_id = $nuevoAutor -> aut_id;
        }else{
            $autores_aut_id = $autor; 
        }  

        // CREAR LIBRO 
  
    
        if($request -> hasFile('lib_foto')){
            $newLibro['lib_foto'] = $request -> file('lib_foto') -> store('uploads', 'public');
        }else{
            $newLibro['lib_foto'] = 'Sin Imagen';
        } 

        $newLibro['carreraNiveles_id'] = $carreraNiveles_id;
        $newLibro['lib_eDisponibles'] = $request -> input('lib_ejemplares');
        

        $libro = Libro::create($newLibro);

        $libros_lib_id = $libro -> lib_id;

    
        AutorLibro::create([
            'autores_aut_id' => $autores_aut_id,
            'libros_lib_id' => $libros_lib_id,  
        ]);
    
        return redirect()->route('/admin/libros/inventario.index')->with('success', 'Nueva libro registrado con éxito.');
    }

    public function inventario_show($id){ 

        $niveles = Nivel::all();
        $carreras = Carrera::all();
        $autores = Autor::all();
        $editoriales = Editorial::all();

        $bookSelected = DB::table('autor_libros as al')
        ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
        ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
        ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
        ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
        ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.*', 'n.*')
        ->where('lib_id', '=', $id)
        ->first();

        $carreraNivel = DB::select("
            SELECT  cn.*, c.car_nombre, n.*
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id
            WHERE $bookSelected->carreraNiveles_id = cn.id;
        ");

        $carrera = $carreraNivel[0];
        $carrera_nivels = $carreraNivel[0]->niv_id;

        $nivel = Nivel::where('niv_id', $carrera_nivels)->first();


        // 

        return view('admin.libros.inventario.update', ['bookSelected' => $bookSelected, 'autores' => $autores, 'editoriales' => $editoriales, 'niveles' => $niveles, 'nivel' => $nivel, 'carrera' => $carrera, 'carreras' => $carreras]);
    }

    public function inventario_update(Request $request, $id){

        $campos = [
            'lib_titulo' => 'required',
            'lib_ejemplares' => 'required',
            'autores_aut_id' => 'required',
            'carrera_nivels_id' => 'required',        
        ];

        $mensajes = [
            'lib_titulo.required' => 'El titulo del libro es requerido.',
            'lib_ejemplares.required' => 'Este campo es requerido.',
            'autores_aut_id.required' => 'Este campo es requerido.',
            'carrera_nivels_id' => 'Este campo es requerido.',       
        ];

        $this -> validate($request, $campos, $mensajes);

        $updatedBook = $request -> only(['lib_titulo', 'lib_descripcion', 'lib_ejemplares', 'lib_foto', 'lib_aPublicacion']);
        $niv_id = $request ->input('niv_id');
        $carrera_nivels_id = $request -> input('carrera_nivels_id');
        $editorial = $request -> input('editoriales_edi_id');
        $autor= $request->input('autores_aut_id');

        if($request -> hasFile('lib_foto')){
            $libro = Libro::findOrFail($id);

            Storage::delete('public/'.$libro->lib_foto);

            $updatedBook['lib_foto'] = $request->file('lib_foto')->store('uploads','public');
        }
        $updatedBook['lib_eDisponibles'] = $request -> input('lib_ejemplares');

        $niv_id = $request -> input('nivel');
        $car_id = $request -> input('carrera_nivels_id');

        $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
        ->where('carreras_car_id', $car_id)
        ->value('id');

        $updatedBook['carreraNiveles_id'] = $carreraNiveles_id;
        

        if ($editorial === 'agregar-nueva-editorial') {
                $nuevaEditorial = Editorial::create([
                    'edi_nombre' => $request->input('edi_nombre'),
                ]);
                $editoriales_edi_id = $nuevaEditorial->edi_id;
                $updatedBook['editoriales_edi_id'] = $editoriales_edi_id;
        }else{
            $updatedBook['editoriales_edi_id'] = $editorial;
        }
        
        Libro::where('lib_id', '=', $id) -> update($updatedBook);

        if ($autor === 'agregar-nuevo-autor'){
                $nuevoAutor = Autor::create([
                    'aut_nombre' => $request->input('aut_nombre'),
                ]);
            $autores_aut_id = $nuevoAutor -> aut_id;
        }else{
            $autores_aut_id = $autor;
        }
    
        AutorLibro::where('libros_lib_id', '=', $id) -> update(['autores_aut_id' => $autores_aut_id]);

        return redirect() -> route('/admin/libros/inventario.index')->with('success', 'Libro modificado con éxito.');
    }

    public function inventario_destroy($id){

        $autorLibro = AutorLibro::findOrFail($id);

        $lib_id = $autorLibro -> libros_lib_id;
        
        
        $libro = Libro::findOrFail($lib_id);
        if(Storage::delete('public/'.$libro->lib_foto)){
            Libro::destroy($lib_id);
            }
        
        AutorLibro::destroy($id);

        return redirect()->route('/admin/libros/inventario.index')->with('success', 'Libro eliminado con éxito.');
    }

    // CRUD LIBROS PDF

        public function inventarioDigitales_create(){
            $autores = Autor::all();
            $editoriales = Editorial::all();
            $carreras = Carrera::all();
            $niveles = Nivel::all();
            $carreraNiveles = CarreraNivel::all();


            return view('admin.libros.inventario.librosPdf.create', [
                'autores' => $autores, 
                'editoriales' => $editoriales,
                'carreras' => $carreras,
                'niveles' => $niveles,
                'carreraNiveles' => $carreraNiveles,
            ]);
        }

        public function inventarioDigitales_store(Request $request){
            $campos = [
                'lib_titulo' => 'required',
                'lib_archivo' => 'required|mimes:pdf',
                'autores_aut_id' => 'required',
                'carrera_nivels_id' => 'required',        
            ];

            $mensajes = [
                'lib_titulo.required' => 'El titulo del libro es requerido.',
                'lib_archivo.required' => 'Selecciona el archivo PDF.',
                'lib_archivo.mimes' => 'Solo se acepta formatos PDF.',
                'autores_aut_id.required' => 'Este campo es requerido.',
                'carrera_nivels_id' => 'Este campo es requerido.',       
            ];

            $this -> validate($request, $campos, $mensajes);

            $pdfFile = $request->file('lib_archivo');
            $pdfPath = $pdfFile->store('pdfs', 'public');

            $niv_id = $request -> input('nivel');
            $car_id = $request -> input('carrera_nivels_id');
    
            $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
                ->where('carreras_car_id', $car_id)
                ->value('id'); 
            
            $newLibro = $request->except(['_token', 'autores_aut_id', 'carrera_nivels_id']);

            // $carreraNiveles_id = $request -> input('carrera_nivels_id');

            $editorial = $request -> input('editoriales_edi_id');
                if ($editorial === 'agregar-nueva-editorial') {
                        $nuevaEditorial = Editorial::create([
                            'edi_nombre' => $request->input('edi_nombre'),
                        ]);
                        $editoriales_edi_id = $nuevaEditorial->edi_id;
                        $newLibro['editoriales_edi_id'] = $editoriales_edi_id;
                }else{
                    $newLibro['editoriales_edi_id'] = $editorial;
                }

            $newLibro['carreraNiveles_id'] = $carreraNiveles_id;
            $newLibro['lib_eDisponibles'] = $request -> input('lib_ejemplares');
            $newLibro['lib_archivo'] = $pdfPath;
            

            $libro = Libro::create($newLibro);

            $libros_lib_id = $libro -> lib_id;

            $autor= $request->input('autores_aut_id');
            if ($autor === 'agregar-nuevo-autor'){
                $nuevoAutor = Autor::create([
                    'aut_nombre' => $request->input('aut_nombre'),
                ]);
                $autores_aut_id = $nuevoAutor -> aut_id;
            }else{
                $autores_aut_id = $autor;
            }

            AutorLibro::create([
                'autores_aut_id' => $autores_aut_id,
                'libros_lib_id' => $libros_lib_id, 
            ]);
            
            
            return redirect()->route('/admin/libros/inventario.index')->with('success', 'Nuevo libro pdf registrado con éxito.');
        }

        public function inventarioDigitales_show($id){
            $autores = Autor::all();
            $carreras = Carrera::all();
            $editoriales = Editorial::all();

            $niveles = Nivel::all();

            $bookSelected = DB::table('autor_libros as al')
            ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
            ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
            ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
            ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
            ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
            ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.*', 'n.*')
            ->where('lib_id', '=', $id)
            ->first();

            $carreraNivel = DB::select("
                    SELECT  cn.*, c.car_nombre, n.*
                    FROM carrera_nivels cn
                    LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
                    LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id
                    WHERE $bookSelected->carreraNiveles_id = cn.id;
                ");

            $carrera = $carreraNivel[0];
            $carrera_nivels = $carreraNivel[0]->niv_id;
            
            $nivel = Nivel::where('niv_id', $carrera_nivels)->first();

            return view('admin.libros.inventario.librosPdf.update', ['bookSelected' => $bookSelected, 'autores' => $autores, 'editoriales' => $editoriales, 'niveles' => $niveles, 'nivel' => $nivel, 'carrera' => $carrera, 'carreras' => $carreras]);
        }

        public function inventarioDigitales_update(Request $request, $id){
            $campos = [
                'lib_titulo' => 'required',
                'autores_aut_id' => 'required',
                'carrera_nivels_id' => 'required',        
            ];

            $mensajes = [
                'lib_titulo.required' => 'El titulo del libro es requerido.',
                'autores_aut_id.required' => 'Este campo es requerido.',
                'carrera_nivels_id' => 'Este campo es requerido.',       
            ];

            $this -> validate($request, $campos, $mensajes);

            $updatedBook = $request -> only(['lib_titulo', 'lib_descripcion', 'lib_aPublicacion']);
            $editorial = $request -> input('editoriales_edi_id');
            $autor= $request->input('autores_aut_id');

            if($request -> hasFile('lib_archivo')){
                $libro = Libro::findOrFail($id);

                Storage::delete('public/'.$libro->lib_archivo);

                $updatedBook['lib_archivo'] = $request->file('lib_archivo')->store('uploads','public');
            }
            $niv_id = $request -> input('nivel'); 
            $car_id = $request -> input('carrera_nivels_id');

            $carreraNiveles_id = CarreraNivel::where('nivel_niv_id', $niv_id)
                ->where('carreras_car_id', $car_id)
                ->value('id'); 
                
            $updatedBook['carreraNiveles_id'] = $carreraNiveles_id;

            if ($editorial === 'agregar-nueva-editorial') {
                    $nuevaEditorial = Editorial::create([
                        'edi_nombre' => $request->input('edi_nombre'),
                    ]);
                    $editoriales_edi_id = $nuevaEditorial->edi_id;
                    $updatedBook['editoriales_edi_id'] = $editoriales_edi_id;
            }else{
                $updatedBook['editoriales_edi_id'] = $editorial;
            }
            
            Libro::where('lib_id', '=', $id) -> update($updatedBook);

            if ($autor === 'agregar-nuevo-autor'){
                    $nuevoAutor = Autor::create([
                        'aut_nombre' => $request->input('aut_nombre'),
                    ]);
                $autores_aut_id = $nuevoAutor -> aut_id;
            }else{
                $autores_aut_id = $autor;
            }

            AutorLibro::where('libros_lib_id', '=', $id) -> update(['autores_aut_id' => $autores_aut_id]);

            return redirect()->route('/admin/libros/inventario.index')->with('success', 'Libro PDF actualizado correctamente');
        }

        public function inventarioDigitales_destroy($id){

            $autorLibro = AutorLibro::findOrFail($id);
            
            $lib_id = $autorLibro -> libros_lib_id;
            
            $libro = Libro::findOrFail($lib_id);
            if(Storage::delete('public/'.$libro->lib_archivo)){
                Libro::destroy($lib_id);
            }
            
            AutorLibro::destroy($id);
            
            return redirect()->route('/admin/libros/inventario.index')->with('success', 'Libro PDF eliminado');
        }

/////////////////////////////////////////////////////// AUTORES ///////////////////////////////////////////////////////

    public function autores_index(Request $request){
        $busqueda = trim($request -> get('busqueda')); 

        $autores = DB::table('autores as a')
            ->select('a.*')
            ->where('aut_nombre', 'LIKE', '%'.$busqueda.'%')
            ->paginate(5); 

        return view('admin.libros.autores.index', ['autores' => $autores, 'busqueda' => $busqueda]);

    }

    public function autores_store(Request $request){
        $campos = [
            'aut_nombre' => 'required',
        ];

        $mensajes = [
            'aut_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);

        $aut_nombre = $request -> aut_nombre;

        Autor::create([
            'aut_nombre' => $aut_nombre
        ]);
        return redirect() -> route('/admin/libros/autores.index')->with('success', 'Nuevo autor registrado con éxito.');
    }

    public function autores_update(Request $request){
        $campos = [
            'aut_nombre' => 'required',
        ];

        $mensajes = [
            'aut_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);
        
        $aut_id = $request ->input('aut_id');
        $aut_nombre = $request ->input('aut_nombre');

        Autor::where('aut_id', $aut_id) -> update(['aut_nombre' => $aut_nombre]);

        return redirect() -> route('/admin/libros/autores.index')->with('success', 'Se actualizaron los datos con éxito.');
    }

    public function autores_destroy($id){
        Autor::destroy($id);

        return redirect() -> route('/admin/libros/autores.index')->with('success', 'Autor eliminado con éxito.');
    }

/////////////////////////////////////////////////////// EDITORIALES ////////////////////////////////////////////////////////////////////////////////////
    
    public function editoriales_index(Request $request){
        $busqueda = trim($request -> get('busqueda')); 

        $editoriales = DB::table('editoriales as e')
            ->select('e.*')
            ->where('edi_nombre', 'LIKE', '%'.$busqueda.'%')
            ->paginate(5);

        return view('admin.libros.editoriales.index', ['editoriales' => $editoriales, 'busqueda' => $busqueda]);
    } 

    public function editoriales_store(Request $request){
        $campos = [
            'edi_nombre' => 'required',
        ];

        $mensajes = [
            'edi_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);

        $edi_nombre = $request -> edi_nombre;

        Editorial::create([
            'edi_nombre' => $edi_nombre
        ]);
        return redirect() -> route('/admin/libros/editoriales.index')->with('success', 'Nueva editorial registrada con éxito.');
    }

    public function editoriales_update(Request $request){
        $campos = [
            'edi_nombre' => 'required',
        ];

        $mensajes = [
            'edi_nombre.required' => 'El nombre es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);
        
        $edi_id = $request ->input('edi_id');
        $edi_nombre = $request ->input('edi_nombre');

        Editorial::where('edi_id', $edi_id) -> update(['edi_nombre' => $edi_nombre]);

        return redirect() -> route('/admin/libros/editoriales.index')->with('success', 'Se actualizaron los datos con éxito.');
    }

    public function editoriales_destroy($id){
        Editorial::destroy($id);

        return redirect() -> route('/admin/libros/editoriales.index')->with('success', 'Editorial eliminada con éxito.');
    }

/////////////////////////////////////////////////////// PERFIL DE USUARIO //////////////////////////////////////////////////////////////////////////////

    public function profile_show($id){

        $usuario =  User::find($id);
        $usuarios_id = $usuario -> id;

        $generos = Genero::all();

        // $admin = Administrador::where('usuarios_id', $usuarios_id)->first();

        $adminCadena = DB::select("
            SELECT a.*, usuarios.*, generos.*
            FROM administradores a
            LEFT JOIN usuarios ON a.usuarios_id = usuarios.id
            LEFT JOIN generos ON a.generos_gen_id = generos.gen_id
            WHERE usuarios.id = $usuarios_id;
        ");

        $admin = $adminCadena[0];

        // return $admin;

        return view('admin.perfil.index', ['usuario' => $usuario, 'admin' => $admin, 'generos' => $generos]); 
    }

    public function profile_update(Request $request, $id){
        $campos = [
            'adm_nombre' => 'required',
            'adm_apellidos' => 'required',
            'email' => 'required',        
        ];

        $mensajes = [
            'adm_nombre.required' => 'El nombre es requerido.',
            'adm_apellidos.required' => 'Los apellidos son requeridos.',
            'email.required' => 'El email es requerido.',
        ];

        $this -> validate($request, $campos, $mensajes);

        // Modificar datos del Usuario
        $usuarioModificado = request() -> except(['_token','_method','adm_nombre', 'adm_apellidos', 'generos_gen_id']);
            
        User::where('id','=',$id) -> update($usuarioModificado);

        // Modificar datos del Administrador
        $alumnoModificado = request()-> except(['_token','_method','email']);

        Administrador::where('usuarios_id','=',$id) -> update($alumnoModificado);

        return redirect()->route('admin/perfil.show', ['id' => $id]) -> with('success', 'Datos actualizados con éxito.');

    }

    public function profile_imageUpdate(Request $request, $id){

        $newFoto = request() -> except(['_token','_method']);

        if($request -> hasFile('foto')){
            $usuario = User::findOrFail($id);

            Storage::delete('public/'.$usuario->foto);

            $newFoto['foto'] = $request->file('foto')->store('uploads','public');
        }

        User::where('id','=',$id) -> update($newFoto);

        return redirect()->route('admin/perfil.show', ['id' => $id]);
    }

    public function password_update(Request $request, $id){

        $campos = [
            'password' => 'required | min:8',
            'newPassword' => 'required | min:8 | confirmed',
            'newPasswordConfirmation' => 'required | min:8',
        ];

        $mensajes = [
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener 8 caracteres como mínimo',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password_confirmation.required' => 'Debes confirmar tu contraseña'
            
        ];

        $this -> validate($request, $campos, $mensajes);

        $password = $request -> password;
        $newPassword = $request -> newPassword;
        $newPasswordConfirmation = $request -> newPasswordConfirmation;
    }

/////////////////////////////////////////////////////// APARTADO DE GRAFICAS ///////////////////////////////////////////////////////////////////////////////////////

    public function logins_index(Request $request){

        $selectedOption = $request->input('option', 'month'); // Obtener la opción seleccionada del usuario
    
        // Crear una vista temporal para calcular el intervalo
        DB::statement("
            CREATE OR REPLACE VIEW login_interval_view AS
            SELECT
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                CASE
                    WHEN MONTH(created_at) IN (1, 2, 3, 4) THEN 'ene_abr'
                    WHEN MONTH(created_at) IN (5, 6, 7, 8) THEN 'may_ago'
                    WHEN MONTH(created_at) IN (9, 10, 11, 12) THEN 'sep_dic'
                END as interval_alias,
                id
            FROM historial_de_logins
        ");
    
        $query = DB::table('login_interval_view')
            ->select(
                'year',
                'month',
                'interval_alias',
                DB::raw('count(*) as login_count')
            );
    
        if ($selectedOption == 'month') {
            $query->groupBy('year', 'month', 'interval_alias');
        } elseif ($selectedOption == 'interval') {
            $query->groupBy('year', 'interval_alias');
        }
    
        $loginCounts = $query->get();
    
        // Eliminar la vista temporal
        DB::statement("DROP VIEW IF EXISTS login_interval_view");
    
        $data = [];
    
        foreach($loginCounts as $row){
            $data[] = [
                'year' => $row->year,
                'month' => $row->month,
                'interval' => $row->interval_alias,
                'login_count' => $row->login_count
            ];
        }

        // return $data;
    
        return view('admin.visitas.index', [
            'data' => $data,
            'selectedOption' => $selectedOption,
        ]);
    }

    public function loginsPDF_index(Request $request){
        $selectedOption = $request->input('option', 'month'); // Obtener la opción seleccionada del usuario
    
        // Crear una vista temporal para calcular el intervalo
        DB::statement("
            CREATE OR REPLACE VIEW login_interval_view AS
            SELECT
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                CASE
                    WHEN MONTH(created_at) IN (1, 2, 3, 4) THEN 'ene_abr'
                    WHEN MONTH(created_at) IN (5, 6, 7, 8) THEN 'may_ago'
                    WHEN MONTH(created_at) IN (9, 10, 11, 12) THEN 'sep_dic'
                END as interval_alias,
                id
            FROM historial_de_logins
        ");
    
        $query = DB::table('login_interval_view')
            ->select(
                'year',
                'month',
                'interval_alias',
                DB::raw('count(*) as login_count')
            );
    
        if ($selectedOption == 'month') {
            $query->groupBy('year', 'month', 'interval_alias');
        } elseif ($selectedOption == 'interval') {
            $query->groupBy('year', 'interval_alias');
        }
    
        $loginCounts = $query->get();
    
        // Eliminar la vista temporal
        DB::statement("DROP VIEW IF EXISTS login_interval_view");
    
        $data = [];
    
        foreach($loginCounts as $row){
            $data[] = [
                'year' => $row->year,
                'month' => $row->month,
                'interval' => $row->interval_alias,
                'login_count' => $row->login_count
            ];
        }

        // return $data;
    
        return view('admin.pdf.visitas', [
            'data' => $data,
            'selectedOption' => $selectedOption,
        ]);
    }

    public function loginsPDF_store(Request $request){
        $selectedOption = $request->input('option', 'month'); // Obtener la opción seleccionada del usuario
        $chartImageBase64 = $request->input('chartImageBase64');
    
        // Crear una vista temporal para calcular el intervalo
        DB::statement("
            CREATE OR REPLACE VIEW login_interval_view AS
            SELECT
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                CASE
                    WHEN MONTH(created_at) IN (1, 2, 3, 4) THEN 'ene_abr'
                    WHEN MONTH(created_at) IN (5, 6, 7, 8) THEN 'may_ago'
                    WHEN MONTH(created_at) IN (9, 10, 11, 12) THEN 'sep_dic'
                END as interval_alias,
                id
            FROM historial_de_logins
        ");
    
        $query = DB::table('login_interval_view')
            ->select(
                'year',
                'month',
                'interval_alias',
                DB::raw('count(*) as login_count')
            );
    
        if ($selectedOption == 'month') {
            $query->groupBy('year', 'month', 'interval_alias');
        } elseif ($selectedOption == 'interval') {
            $query->groupBy('year', 'interval_alias');
        }
    
        $loginCounts = $query->get();
    
        // Eliminar la vista temporal
        DB::statement("DROP VIEW IF EXISTS login_interval_view");
    
        $data = [];

        // Establecer la configuración regional a español
        setlocale(LC_TIME, 'es_ES');
    
        foreach($loginCounts as $row){
            // Obtener el nombre del mes en formato texto y en español
            $monthNames = [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
            ];
            
            $monthName = $monthNames[$row->month];
            
            $data[] = [
                'year' => $row->year,
                'month' => $monthName,
                'interval' => $row->interval_alias,
                'login_count' => $row->login_count
            ];
        }
    
        // Tu código para obtener los datos y generar la gráfica

        // Crear una vista con los datos y la gráfica
        $view = view('pdf.reporteVisitas', [
            'data' => $data,
            'selectedOption' => $selectedOption,
        ]);

        // Generar el PDF usando Dompdf
        $pdf = PDF::loadHTML($view);
        return $pdf->download('Visitas - Sistema de prestámos UDM.pdf');
    }

/////////////////////////////////////////////////////// APARTADO DE PUBLICACIONES //////////////////////////////////////////////////////////////////////////////////

    public function publicaciones_index(){

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
                $publicacion->updated_at = Carbon::parse($publicacion->updated_at)->format('d/m/Y H:i');
            }
    
            return view('admin.publicaciones.index', ['publicaciones' => $publicaciones]);
    }
    
    public function publicaciones_store(Request $request){
        $campos = [
            'descripcion' => 'required | max:1000',
            'pub_foto' => 'required | mimes:jpg,png,jpeg,gif,avi,mp4',
        ];

        $mensajes = [
            'descripcion.required' => 'La descripción es requerida.',
            'descripcion.max' => 'Se excedió el número de caracteres permitidos.',
            'pub_foto.required' => 'La foto es requerida.',
            'pub_foto.mimes' => 'Las publicaciones solo aceptan formatos .jpg, .png, .jpeg, .gif, .avi, .mp4'
        ]; 

        $this -> validate($request, $campos, $mensajes);
    
        $newPublication = $request -> except('_token');
        $email = $request->input('email');
        $usuario = User::where('email', $email)->first(); // Ejecuta la consulta y obtiene el primer resultado
        
        if ($usuario) {
            $newPublication['usuarios_id'] = $usuario->id;
        } else {
            return 'Usuario no encontrado';
        }
        
        if($request -> hasFile('pub_foto')){
            $newPublication['pub_foto'] = $request -> file('pub_foto') -> store('uploads', 'public');
        }
        
        Publicacion::create($newPublication);
 
        return redirect() -> route('admin/publicaciones.index');
    }
    
    public function publicaciones_update(Request $request){
        $campos = [
            'descripcion' => 'required | max:1000',
            'pub_foto' => 'mimes:jpg,png,jpeg,gif,avi,mp4',
        ];

        $mensajes = [
            'descripcion.required' => 'La descripción no puede quedar vacía.',
            'descripcion.max' => 'Se excedió el número de caracteres permitidos.',
            'pub_foto.mimes' => 'Las publicaciones solo aceptan formatos .jpg, .png, .jpeg, .gif, .avi, .mp4'
        ]; 

        $this -> validate($request, $campos, $mensajes);
        
        $pub_id = $request -> input('id');
        $updatedPublication = $request -> except(['_token', '_method', 'id']);
        
        
        if($request -> hasFile('pub_foto')){
            $publicacion = Publicacion::findOrFail($pub_id);

            Storage::delete('public/'.$publicacion->pub_foto);
            
            $updatedPublication['pub_foto'] = $request->file('pub_foto')->store('uploads','public');
        }
        
        Publicacion::where('id', '=', $pub_id) -> update($updatedPublication);
        return redirect() -> route('admin/publicaciones.index');
    }

    public function publicaciones_destroy($id){
        $publicacion = Publicacion::findOrFail($id);

        if(Storage::delete('public/'.$publicacion -> pub_foto)){
            Publicacion::destroy($id);
        }

        return redirect() -> route('admin/publicaciones.index'); 
    }

/////////////////////////////////////////////////////// APARTADO DEL PORTAL DE INVESTIGACIÓN ////////////////////////////////////////////////////////////////////////

    public function index_portal(){

        $enlaces = DB::select("
            SELECT p.*
            FROM portal_de_investigacions p            
        ");

        return view('admin.portal.index', compact('enlaces'));
    }

    public function portal_index(){

        $paginas = DB::table('portal_de_investigacions as pdi')
            ->select('pdi.*')
            ->paginate(5);

        return view('admin.portalDeInvestigacion.index', ['paginas' => $paginas]);
    }

    public function portal_store(Request $request){

        $campos = [
            'pdi_imagen' => 'mimes:jpg,png,jpeg,gif',
        ];

        $mensajes = [
            'pdi_imagen.mimes' => 'Solo se aceptan extenciones: .jpg, .png, .jpeg, .gif'
        ]; 

        $this -> validate($request, $campos, $mensajes);

        $newLink = $request -> except('_token');

        if($request -> hasFile('pdi_imagen')){
            $newLink['pdi_imagen'] = $request -> file('pdi_imagen') -> store('uploads', 'public');
        }

        PortalDeInvestigacion::create($newLink);

        return redirect() -> route('/admin/portal-de-investigacion.index')->with('success', 'Nuevo enlace agregado.');
    }

    public function portal_update(Request $request){

        $campos = [
            'pdi_imagen' => 'mimes:jpg,png,jpeg,gif',
        ];

        $mensajes = [
            'pdi_imagen.mimes' => 'Solo se aceptan extenciones: .jpg, .png, .jpeg, .gif'
        ]; 

        $this -> validate($request, $campos, $mensajes);

        $idLink = $request -> input('id');
        $updatedLink = $request -> except(['_token', '_method', 'id']);

        if($request -> hasFile('pdi_imagen')){

            $link = PortalDeInvestigacion::findOrFail($idLink);
            Storage::delete('public/'. $link -> pdi_imagen);

            $updatedLink['pdi_imagen'] = $request -> file('pdi_imagen') -> store('uploads', 'public');
        }

        PortalDeInvestigacion::where('id', $idLink) -> update($updatedLink);

        return redirect() -> route('/admin/portal-de-investigacion.index')->with('success', 'Enlace actualizado');
    }

    public function portal_destroy($id){

        $pdi = PortalDeInvestigacion::findOrFail($id);

        if(Storage::delete('public/'.$pdi->pdi_imagen)){
            PortalDeInvestigacion::destroy($id);
            }

        return redirect() -> route('/admin/portal-de-investigacion.index')->with('success', 'Enlace eliminado');
    }
    
    /////////////////////////////////////////////////////// APARTADO DE REPORTE PDF DE LIBROS //////////////////////////////////////////////////////////////////////////

    public function filtroLibrosPDF_index(){
 
        $niveles = Nivel::all();

        return view('admin.libros.pdf.index', compact('niveles'));
    }

    public function obtenerCarrerasPDF(Request $request){
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

    public function librosPDF_index(Request $request){ 

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
        
        $fechaGeneracion = $meses[Date::now()->month] . ' ' . Date::now()->year;
        

        $opcionNivel = $request->input('opcionNivel');
        $opcionCarrera = $request->input('opcionCarrera');
        $actualizo_nombre = $request->input('actualizo_nombre');
        $actualizo_cargo = $request->input('actualizo_cargo');
        $reviso_nombre = $request->input('reviso_nombre');
        $reviso_cargo = $request->input('reviso_cargo'); 


        // Usando is_null()
        if (is_null($opcionCarrera)) {

            if( $opcionNivel == 0 ){
                $libros = DB::table('autor_libros as al')
                ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
                ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
                ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
                ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
                ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
                ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
                ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
                ->get();

                $elementosPDF = PdfEncabezado::all();
                $elementosPiePDF = PdfPiePagina::all();
                $imagenPortada = PdfImagenPortada::first();

                $data = [
                    'libros' => $libros, // Pasa los datos como un arreglo asociativo
                    'nombreNivel' => null, 
                    'nombreCarrera' => null, 
                    'elementosPDF' => $elementosPDF, 
                    'elementosPiePDF' => $elementosPiePDF,  
                    'imagenPortada' => $imagenPortada, 
                    'actualizo_nombre' => $actualizo_nombre, 
                    'actualizo_cargo' => $actualizo_cargo, 
                    'reviso_nombre' => $reviso_nombre, 
                    'reviso_cargo' => $reviso_cargo,  
                    'fechaGeneracion' => $fechaGeneracion, 
                ];

                
                // Generar la vista del encabezado
                $encabezado = view('pdf.encabezado', $data)->render();

                // Cargar la vista del reporte de libros
                $reporte = view('pdf.libros.cuerpo', $data)->render();

                 // Combinar el encabezado y el reporte en un solo HTML
                $contenidoHTML = $encabezado . $reporte;

                // Después de usar $datosGrandes y no necesitarlo más, puedes liberar la memoria así:
                unset($data);

                // Crear el PDF
                $pdf = PDF::loadHTML($contenidoHTML);

                return $pdf->download('Inventario de libros.pdf');            

            }else{
                $libros = DB::table('autor_libros as al')
                ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
                ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
                ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
                ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
                ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
                ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
                ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
                ->where('n.niv_id', '=', $opcionNivel )
                ->get();
                

                $nombreNivel = Nivel::find($opcionNivel);
                $elementosPDF = PdfEncabezado::all();
                $elementosPiePDF = PdfPiePagina::all();
                $imagenPortada = PdfImagenPortada::first();


                $data = [
                    'libros' => $libros, // Pasa los datos como un arreglo asociativo
                    'nombreNivel' => $nombreNivel, 
                    'nombreCarrera' => null, 
                    'elementosPDF' => $elementosPDF, 
                    'elementosPiePDF' => $elementosPiePDF,
                    'imagenPortada' => $imagenPortada, 
                    'actualizo_nombre' => $actualizo_nombre, 
                    'actualizo_cargo' => $actualizo_cargo, 
                    'reviso_nombre' => $reviso_nombre, 
                    'reviso_cargo' => $reviso_cargo,  
                    'fechaGeneracion' => $fechaGeneracion, 
                ];

                // Generar la vista del encabezado
                $encabezado = view('pdf.encabezado', $data)->render();

                // Cargar la vista del reporte de libros
                $reporte = view('pdf.libros.cuerpo', $data)->render();

                 // Combinar el encabezado y el reporte en un solo HTML
                $contenidoHTML = $encabezado . $reporte;

                // Crear el PDF
                $pdf = PDF::loadHTML($contenidoHTML);

                return $pdf->download('Inventario de libros.pdf');
            }

        } else {
            $libros = DB::table('autor_libros as al')
            ->leftJoin('autores as a', 'al.autores_aut_id', '=', 'a.aut_id')
            ->leftJoin('libros as l', 'al.libros_lib_id', '=', 'l.lib_id')
            ->leftJoin('editoriales as e', 'l.editoriales_edi_id', '=', 'e.edi_id')
            ->leftJoin('carrera_nivels as cn', 'l.carreraNiveles_id', '=', 'cn.id')
            ->leftJoin('carreras as c', 'cn.carreras_car_id', '=', 'c.car_id')
            ->leftJoin('nivel as n', 'cn.nivel_niv_id', '=', 'n.niv_id')
            ->select('al.*', 'a.*', 'l.*', 'e.*', 'cn.id as cn_id', 'c.car_nombre', 'n.niv_nombre')
            ->where('n.niv_id', '=', $opcionNivel )
            ->where('c.car_id', '=', $opcionCarrera)
            ->get();


            $nombreNivel = Nivel::find($opcionNivel);
            $nombreCarrera = Carrera::find($opcionCarrera);
            $elementosPDF = PdfEncabezado::all();
            $elementosPiePDF = PdfPiePagina::all();
            $imagenPortada = PdfImagenPortada::first();

            $data = [
                'libros' => $libros, // Pasa los datos como un arreglo asociativo
                'nombreNivel' => $nombreNivel, 
                'nombreCarrera' => $nombreCarrera, 
                'elementosPDF' => $elementosPDF, 
                'elementosPiePDF' => $elementosPiePDF,
                'imagenPortada' => $imagenPortada, 
                'actualizo_nombre' => $actualizo_nombre, 
                'actualizo_cargo' => $actualizo_cargo, 
                'reviso_nombre' => $reviso_nombre, 
                'reviso_cargo' => $reviso_cargo,  
                'fechaGeneracion' => $fechaGeneracion, 
            ];

            // Generar la vista del encabezado
            $encabezado = view('pdf.encabezado', $data)->render();

            // Cargar la vista del reporte de libros
            $reporte = view('pdf.libros.cuerpo', $data)->render();

                // Combinar el encabezado y el reporte en un solo HTML
            $contenidoHTML = $encabezado . $reporte;

            // Crear el PDF
            $pdf = PDF::loadHTML($contenidoHTML);

            return $pdf->download('Inventario de libros.pdf');
        }

    }

    //

    public function pdfPortada_index(){

        return view('pdf.admin.edicion.index'); 
    }

    public function pdfPortadaEncabezado_index(){
        // return view('pdf.edicion.encabezado.index');

        $elementosPDF = PdfEncabezado::all();

        return view('pdf.admin.edicion.encabezado.index', compact('elementosPDF'));
    }

    public function pdfPortadaEncabezado_store(Request $request){

        $campos = [
            'contenidoImagen' => 'mimes:jpg,png,jpeg',
        ];

        $mensajes = [
            'contenidoImagen.mimes' => 'Solo se aceptan imagenes (.jpg, .png, .jpeg)'
        ];

        $this -> validate($request, $campos, $mensajes);

        $opcion = $request->input('opcion');
        // La variable 'nombre_variable' fue enviada en el request.
        $contenidotextoArray = $request->input('contenidoTexto', []);
        $contenidoArrayJson = json_encode($contenidotextoArray);

        $isAllNull = true;
        foreach ($contenidotextoArray as $item) {
            if ($item !== null) {
                $isAllNull = false;
                break;
            }
        }

        if ($isAllNull) {
            $datosPDF = request()->except('_token', 'contenidoTexto', 'opcion');

            if($request->hasFile('contenidoImagen')){
                $datosPDF['contenidoImagen']=$request->file('contenidoImagen')->store('uploads','public');
            }

            // Asignar el valor a la variable $tipo
            if ($opcion === 'no') {
                $tipo = 'Imagen';
            } else {
                $tipo = 'Texto';
            }

            // Agregar el valor de $tipo a $datosPDF
            $datosPDF['tipo'] = $tipo;

            PdfEncabezado::insert($datosPDF);

            return redirect()->route('admin/edicion-pdf/encabezado.index') -> with('success', 'Nuevo elemento agregado.');
        } else {
            $datosPDF = request()->except('_token', 'contenidoImagen', 'opcion');

            // Luego, guarda la cadena JSON en la base de datos
            $nuevoRegistro = new PdfEncabezado;
            $nuevoRegistro->tipo = 'Texto';
            $nuevoRegistro->contenidoTexto = $contenidoArrayJson;
            $nuevoRegistro->save();

            return redirect()->route('admin/edicion-pdf/encabezado.index') -> with('success', 'Nuevo elemento agregado.');
        } 

    }

    public function pdfPortadaEncabezado_destroy($id){
        $elementoPDF = PdfEncabezado::findOrFail($id);
        
        if(Storage::delete('public/'.$elementoPDF -> contenidoImagen)){
        }
        PdfEncabezado::destroy($id);
        

        return redirect()->route('admin/edicion-pdf/encabezado.index') -> with('success', 'Elemento eliminado.');
    }

    public function pdfPortadaPie_index(){

        $elementosPDF = PdfPiePagina::all(); 

        return view('pdf.admin.edicion.pie.index', compact('elementosPDF'));
    }

    public function pdfPortadaPie_store(Request $request){

        $campos = [
            'contenidoImagen' => 'mimes:jpg,png,jpeg',
        ];

        $mensajes = [
            'contenidoImagen.mimes' => 'Solo se aceptan imagenes (.jpg, .png, .jpeg)'
        ];

        $this -> validate($request, $campos, $mensajes);

        $opcion = $request->input('opcion');
        // La variable 'nombre_variable' fue enviada en el request.
        $contenidotextoArray = $request->input('contenidoTexto', []);
        $contenidoArrayJson = json_encode($contenidotextoArray);

        $isAllNull = true;
        foreach ($contenidotextoArray as $item) {
            if ($item !== null) {
                $isAllNull = false;
                break;
            }
        }

        if ($isAllNull) {
            $datosPDF = request()->except('_token', 'contenidoTexto', 'opcion');

            if($request->hasFile('contenidoImagen')){
                $datosPDF['contenidoImagen']=$request->file('contenidoImagen')->store('uploads','public');
            }

            // Asignar el valor a la variable $tipo
            if ($opcion === 'no') {
                $tipo = 'Imagen';
            } else {
                $tipo = 'Texto';
            }

            // Agregar el valor de $tipo a $datosPDF
            $datosPDF['tipo'] = $tipo;

            PdfPiePagina::insert($datosPDF);

            return redirect()->route('admin/edicion-pdf/pie.index') -> with('success', 'Nuevo elemento agregado.');
        } else {
            $datosPDF = request()->except('_token', 'contenidoImagen', 'opcion');

            // Luego, guarda la cadena JSON en la base de datos
            $nuevoRegistro = new PdfPiePagina;
            $nuevoRegistro->tipo = 'Texto';
            $nuevoRegistro->contenidoTexto = $contenidoArrayJson;
            $nuevoRegistro->save();

            return redirect()->route('admin/edicion-pdf/pie.index') -> with('success', 'Nuevo elemento agregado.');
        } 

    }

    public function pdfPortadaPie_destroy($id){
        $elementoPDF = PdfPiePagina::findOrFail($id);
        
        if(Storage::delete('public/'.$elementoPDF -> contenidoImagen)){
        }
        PdfPiePagina::destroy($id);
        
        return redirect()->route('admin/edicion-pdf/pie.index') -> with('success', 'Elemento eliminado.');
    }

    public function pdfPortadaCuerpo_index(){

        $elementoPDF = PdfImagenPortada::first(); 

        // return $elementoPDF;

        return view('pdf.admin.edicion.portada.index', compact('elementoPDF')); 
    }

    public function pdfPortadaCuerpo_store(Request $request){ 

        $campos = [
            'imagen' => 'mimes:jpg,png,jpeg',
            'imagen' => 'required',
        ];

        $mensajes = [
            'imagen.mimes' => 'Solo se aceptan imagenes (.jpg, .png, .jpeg)',
            'imagen.required' => 'La imagen es requerida.',
        ];
        
        $datosPDF = request()->except('_token');
        $existeRegistro = PdfImagenPortada::first();

        if ($existeRegistro) {
            $registroCadena = PdfImagenPortada::find($existeRegistro); 
            $registro = $registroCadena[0];

            if(Storage::delete('public/'.$registro -> contenidoImagen)){
                PdfImagenPortada::destroy($registro->id);
            }

            if($request->hasFile('contenidoImagen')){
                $datosPDF['contenidoImagen']=$request->file('contenidoImagen')->store('uploads','public');
            } 

            PdfImagenPortada::insert($datosPDF);
            
        } else {
            if($request->hasFile('contenidoImagen')){
                $datosPDF['contenidoImagen']=$request->file('contenidoImagen')->store('uploads','public');
            }

            PdfImagenPortada::insert($datosPDF);
        }

        return redirect()->route('admin/edicion-pdf/portada.index') -> with('success', 'Nueva imagen agregada.');

    }

    public function pdfPortadaCuerpo_destroy($id){
        $elementoPDF = PdfPiePagina::findOrFail($id);
        
        if(Storage::delete('public/'.$elementoPDF -> contenidoImagen)){
        }
        PdfPiePagina::destroy($id);

    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

//Modelos

use App\Models\Rol;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\Grado;
use App\Models\Grupo;
use App\Models\Nivel;
use App\Models\Alumno;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

//
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{

    public function index(){
        

    }

    //
    public function create(){

        $roles = Rol::all();
        $generos = Genero::all();
        $grados = Grado::all();
        $grupos = Grupo::all();
        $niveles = Nivel::all();



        $carreraNivel = DB::select("
            SELECT  cn.id, c.car_nombre, n.niv_nombre
            FROM carrera_nivels cn
            LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
            LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id;
        ");
        
        //return $carreraNivel;

        return view('auth.register', ['roles' => $roles, 'generos' => $generos, 'grados' => $grados, 'grupos' => $grupos, 'niveles' => $niveles, 'carreraNivel' => $carreraNivel ]);
    }

    public function store(Request $request){


    
        $user = User::create(request(['email', 'password', 'roles_rol_id']));
        
        
        
        // $datosAlumno = request()->except('_token', 'email', 'password', 'roles_rol_id', 'password_confirmation');
            
        // Alumno::insert($datosAlumno);
        // $alumno = Alumno:

        $alumno = new Alumno; // Crear nuevo registro
        $alumno -> alu_matricula = $request -> alu_matricula;
        $alumno -> alu_nombre = $request-> alu_nombre; // Asignar cada uno de los valores
        $alumno -> alu_apellidos = $request-> alu_apellidos;
        $alumno -> curp = $request -> curp; 
        $alumno -> generos_gen_id = $request -> generos_gen_id;
        $alumno -> alu_telefono = $request -> alu_telefono; 
        $alumno -> alu_domicilio = $request -> alu_domicilio; 
        $alumno -> carrera_nivels_id = $request -> carrera_nivels_id;
        $alumno -> grados_gra_id = $request->grados_gra_id; 
        $alumno -> grupos_gru_id = $request->grupos_gru_id; 
        $alumno -> usuarios_id = $user -> id; 
        $alumno ->save(); // Guardar nuevo registro en la tabla de la base de datos
        
        return redirect() -> route('admin_alumnos.index');
    }

    public function show($id){

        $roles = Rol::all();
        $generos = Genero::all();
        $grados = Grado::all();
        $grupos = Grupo::all();       
        $niveles = Nivel::all();

        
        $usuario = User::find($id);

        $usuarios_id = $usuario -> id;

        // return $carreraNivel;
        
        $alumno = Alumno::where('usuarios_id', $usuarios_id)->first();

        // return $alumno->carrera_nivels_id;

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

        //$alumno = Alumno::find('usuarios_id','=',$usuarios_id);
        //return $carreraNivel;

        return view('admin.alumnos.alumnos_edit', ['roles' => $roles, 'generos' => $generos, 'grados' => $grados, 'grado' => $grado, 'grupos' => $grupos, 'grupo' => $grupo, 'niveles' => $niveles, 'nivel' => $nivel, 'carreraNivel' => $carreraNivel,'carrera' => $carrera, 'usuario' => $usuario, 'alumno' => $alumno ]);
        
    }

    public function update(Request $request, $id){

        $usuarioModificado = request() -> except(['_token','_method','alu_matricula', 'alu_nombre', 'alu_apellidos', 'curp', 'alu_domicilio', 'alu_telefono', 'carrera_nivels_id', 'grupos_gru_id', 'grados_gra_id']);
            
        User::where('id','=',$id) -> update($usuarioModificado);

        $alumnoModificado = request()-> except(['_token','_method','email', 'roles_rol_id', 'carrera_nivels_id']);

        Alumno::where('usuarios_id','=',$id) -> update($alumnoModificado);

        return redirect() -> route('admin_alumnos.index');

    }

    public function obtenerDatosJS()
    {
        $datos = DB::select("
        SELECT  cn.id, c.car_nombre, n.niv_nombre
        FROM carrera_nivels cn
        LEFT JOIN carreras c ON cn.carreras_car_id = c.car_id
        LEFT JOIN nivel n ON cn.nivel_niv_id = n.niv_id;
    ");// Obtener los datos que deseas enviar al archivo JS
        
        return response()->json($datos);
    }

    public function destroy($id){
        // $delete = Alumno::where('usuarios_id','=',$id);

        // Alumno::destroy($delete);

        User::destroy($id);
        return redirect() -> route('admin_alumnos.index');
    }
}

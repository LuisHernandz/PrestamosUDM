<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\CodigoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function index_verificacion(){ 
        // Definimos variables de sesión para posteriormente verificar si se pueden acceder a ciertas rutas
        session(['codigo_enviado' => false]);
        session(['codigo_correcto' => false]);

        return view('contraseña_olvidada.verificacion');
    }

    public function store_verificacion(Request $request){

        // Validación

        $campos = [
            'email' => 'required | email',
        ];

        $mensajes = [
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un formato válido de correo electrónico.',
        ];

        $this -> validate($request, $campos, $mensajes);

        // Recibir datos
        $email = $request->email;

        // Buscar al usuario
        $usuario = User::where('email', $email)->first();

        // Generamos el código
        $codigo = rand(1000, 9999);
        session(['codigoGenerado' => $codigo]);

        // Verificamos que el usuario con ese correo exista
        if ($usuario) {
            // Si el campo codigo_verificacion es nulo...
            if ($usuario->codigo_verificacion === null) {

                // Se asigna el codigo al usuario
                $usuario -> codigo_verificacion = $codigo;
                $usuario ->save();

                // Enviamos el correo con el codigo
                $correo = new CodigoMailable($codigo);
                Mail::to($usuario->email)->send($correo);

                // Eliminamos el valor del campo codigo
                $usuario -> codigo_verificacion = null;
                $usuario ->save();

                // Marcar el estado de envío en la sesión
                session(['codigo_enviado' => true]);

                // return view('contraseña_olvidada.codigo', ['codigo' => $codigo, 'email' => $usuario->email]);  
                return redirect()->route('/verificacion/codigo.index')->with([
                    'codigo' => $codigo,
                    'email' => $usuario->email,
                ]);
                
            }else{
                $usuario -> codigo_verificacion = null;
                $usuario ->save();      

                return redirect()->route('/verificacion/codigo.index')->with([
                    'codigo' => $codigo,
                    'email' => $usuario->email,
                ]);
            }          
        } else {
            return redirect()->route('/verificacion.index')->withInput(['email'])->with('success', 'No existe algun usuario con ese correo electrónico.');
        }
        
    }

    public function index_codigo(){
        
        // Verificar si el código ha sido enviado
        if (session('codigo_enviado')) {
            $codigo = session('codigoGenerado'); // Obtener el valor de la variable de sesión
            return view('contraseña_olvidada.codigo', ['codigo' => $codigo]);
        }else{
            return redirect()->route('login.index');
        }
    }

    public function store_codigo(Request $request){
        $campos = [
            'respuesta' => 'required|numeric|digits:4',
        ];
        
        $mensajes = [
            'respuesta.required' => 'Por favor, proporciona el código.',
            'respuesta.numeric' => 'El código debe ser numérico.',
            'respuesta.digits' => 'El código debe tener 4 dígitos.',
        ];

        // Devolver errores y datos

        $validator = Validator::make($request->all(), $campos, $mensajes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'respuesta' => $request->respuesta,
                    'codigo' => $request->codigo,
                    'email' => $request->email,
                ]);
        }

        // Obtener datos

        $respuesta = $request->respuesta;
        $email = $request->email;
        $codigo = $request->codigo;
        
        $usuario = User::where('email', $email)->first();
        

        // Verificar si la respuesta concuerda con el codigo
        if ($respuesta = $codigo){
            session(['usuario' => $usuario->id]);
            session(['codigo_correcto' => true]);

            return view('contraseña_olvidada.cambiar', ['usuario' => $usuario]);
        }

        $mensaje = 'Código inválido, por favor inténtalo de nuevo.';

        return redirect()->route('/verificacion/codigo.index')->with([
            'mensaje' => $mensaje,
            'email' => $email,
            'codigo' => $codigo,
        ]);

    }

    public function index_cambiar(){
        // Verificar si el código es correcto
        if (session('codigo_correcto')) {

            $usuario = session('usuario'); // Obtener el valor de la variable de sesión

            // return view('contraseña_olvidada.codigo', ['codigo' => $codigo]);
            return view('contraseña_olvidada.cambiar', ['usuario' => $usuario]);
        }else{
            return redirect()->route('login.index');
        }

    }

    public function store_cambiar(Request $request){

        // Validación
        $campos = [
            'newPassword' => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]+$/',
        ];
        
        $mensajes = [
            'newPassword.required' => 'Por favor, proporciona tu nueva contraseña.',
            'newPassword.string' => 'La contraseña debe ser una cadena de texto.',
            'newPassword.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'newPassword.regex' => 'La contraseña debe contener una combinación de letras, números y símbolos.',
        ];

        // Devolver errores y datos

        $validator = Validator::make($request->all(), $campos, $mensajes);

        if ($validator->fails()) {
            return redirect()->route('/cambiar.index')
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'usuario' => $request->usuario,
                ]);
        }
        
        $nuevaContraseña = $request->newPassword;
        $usuario = User::find($request->usuario);
        
        // Actualizar campos
        $usuario->password = $request->newPassword; // Asignar cada uno de los valores
        $usuario->save(); 

        return view('contraseña_olvidada.exito');
        
    }
}

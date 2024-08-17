<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistorialDeLogin;


class SessionsController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){  
        $campos = [
            'email' => 'required | email',
            'password' => 'required'
        ];

        $mensajes = [
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa un formato válido de correo electrónico.',
            'password.required' => 'La contraseña es requerida.'
            
        ];

        $this -> validate($request, $campos, $mensajes);

        if (auth() -> attempt(request(['email', 'password'])) == false){
            return back() -> withErrors([
                'message' => 'El email o la contraseña son incorrectos, por favor intenta de nuevo.'
            ]);
        } else{
            if(auth()->user()->roles_rol_id == '1'){
                return redirect() -> route('admin.index');
            }elseif(auth() -> user() -> roles_rol_id == '2'){
                return redirect() -> route('bibliotecario.index');
            }else{
                HistorialDeLogin::create([
                'usuarios_id' => auth() -> user() -> id,]);
                return redirect() -> to('/');
            }
        }
        
    }
    
    // Función para cerrar sesión
    public function destroy(){
        auth()-> logout();
        return redirect() -> to('/');
    }
}

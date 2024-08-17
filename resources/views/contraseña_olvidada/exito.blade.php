@extends('layouts.app')
@section('titulo', 'UDM - Restablecer Contraseña')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/restablecer.css')}}">
@endsection
 
@section('content')
    <div class="container" >
        <form action="{{ route('/cambiar.store')}}" method="POST">
            @csrf
            <div class="form-title">
                <div class="form-title_img">
                    <img src="{{url('/assets/images/escudo.png')}}">
                    <h2>UDM</h2>
                </div>
            
                <h1>Restablecer contraseña</h1>
            </div>

            <p class="form-msg">¡Tu contraseña se ha restablecido con éxito!</p>
            
            <div class="form-inputs">
                <div class="modal-footer">
                    <a href="{{route('login.index')}}">
                        <input type="button" class="btn btn-success" value="Confirmar">
                    </a>   
                </div>
            </div>

        </form> 
    </div>
    
@endsection


        

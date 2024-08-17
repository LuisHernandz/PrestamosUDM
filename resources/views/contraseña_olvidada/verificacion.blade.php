@extends('layouts.app')
@section('titulo', 'UDM - Restablecer Contraseña')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/restablecer.css')}}">
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('/verificacion.store')}}" method="POST">
            @csrf

            <div class="form-title">
                <div class="form-title_img">
                    <img src="{{url('/assets/images/escudo.png')}}">
                    <h2>UDM</h2>
                </div>
            
                <h1>Restablecer contraseña</h1>
            </div>   

            <p class="form-msg">
                Por favor, proporciona la dirección de correo electrónico asociada a tu cuenta, te enviaremos un código de verificación para que puedas restablecer tu contraseña.
            </p>

            <div class="form-inputs">
                <div class="box-input">
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" value ="{{old('email')}}" placeholder="Email">

                        @error('email')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror

                        @if (session('success'))
                            <p class="msg-error"> {{ session('success') }}</p>
                        @endif
                    </div>  
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Confirmar">
                    <a href="{{route('login.index')}}">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    </a>   
                </div>
            </div>
        </form> 
    </div> 
@endsection



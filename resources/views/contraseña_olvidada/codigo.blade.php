@extends('layouts.app')
@section('titulo', 'UDM - Restablecer Contraseña')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/restablecer.css')}}">
@endsection
 
@section('content')
    <div class="container">
        <form action="{{ route('/verificacion/codigo.store')}}" method="POST">
            @csrf
            <div class="form-title">
                <div class="form-title_img">
                    <img src="{{url('/assets/images/escudo.png')}}">
                    <h2>UDM</h2>
                </div>
            
                <h1>Restablecer contraseña</h1>
            </div>

            <p class="form-msg">Se ha enviado un código de verificación de cuatro dígitos a tu correo electrónico, por favor, ingresa el código en el siguiente campo:</p>

            <div class="form-inputs">
                <div class="box-input">
                    <div class="form-group">
                        <input type="number" class="form-control" name="respuesta" id="myNumberInput" value ="{{old('respuesta')}}" placeholder="Ingresa el código." oninput="limitInputLength()">

                        @if(session('codigo'))
                            <input type="hidden" name="codigo" value="{{ session('codigo') }}">
                        @endif

                        {{-- <p>{{ session('codigo') }}</p> --}}
                                      
                        @if(session('email'))
                            <input type="hidden" name="email" value="{{ session('email') }}">
                        @endif

                        @error('respuesta')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror

                        @if (session('mensaje'))
                            <p class="msg-error"> {{ session('mensaje') }}</p>
                        @endif 
                    </div>  
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Confirmar">
                    <a href="{{route('/verificacion.index')}}">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    </a>   
                </div>
            </div>

        </form> 
    </div>
    
    
    @section('scripts_unicos')
        <script>
            function limitInputLength() {
            const input = document.getElementById('myNumberInput');
            const maxLength = 4; // Límite máximo de caracteres permitidos
        
            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength); // Trunca el valor al límite máximo
            }
            }
        </script>                       
    @endsection
@endsection



 
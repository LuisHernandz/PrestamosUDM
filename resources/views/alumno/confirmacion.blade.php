@extends('layouts.app')
@section('titulo', 'UDM - Confirmar Correo Electrónico')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/restablecer.css')}}">
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('registro.store')}}" method="POST">
            @csrf

            <div class="form-title">
                <div class="form-title_img">
                    <img src="{{url('/assets/images/escudo.png')}}">
                    <h2>UDM</h2>
                </div>
            
                <h1>Confirmación De Correo</h1>
            </div>   

            <p class="form-msg">
                Antes de finalizar tu registro, es necesario confirmar que la dirección de correo electrónico proporcionada te pertenece. Para ello, hemos enviado un código de 4 dígitos. Por favor, ingresa el código en el siguiente campo. 
            </p>

            <div class="form-inputs">
                <div class="box-input">
                    <div class="form-group">
                        <input type="number" class="form-control" name="respuesta" id="myNumberInput" value ="{{old('respuesta')}}" placeholder="Ingresa el código." oninput="limitInputLength()">

                        @error('respuesta')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror

                        @if (session('mensaje'))
                            <p class= "msg-error">{{ session('mensaje') }}</p>
                        @endif

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

            <input type="hidden" name="_token" value="{{ session('datos_alumno._token', old('_token')) }}" required> 
            <input type="hidden" name="alu_nombre" value="{{ session('datos_alumno.alu_nombre', old('alu_nombre')) }}" required>
            <input type="hidden" name="alu_apellidos" value="{{ session('datos_alumno.alu_apellidos', old('alu_apellidos')) }}" required>
            <input type="hidden" name="alu_telefono" value="{{ session('datos_alumno.alu_telefono', old('alu_telefono')) }}" required>
            <input type="hidden" name="curp" value="{{ session('datos_alumno.curp', old('curp')) }}" required>
            <input type="hidden" name="alu_domicilio" value="{{ session('datos_alumno.alu_domicilio', old('alu_domicilio')) }}" required>
            <input type="hidden" name="generos_gen_id" value="{{ session('datos_alumno.generos_gen_id', old('generos_gen_id')) }}" required>
            <input type="hidden" name="alu_matricula" value="{{ session('datos_alumno.alu_matricula', old('alu_matricula')) }}" required>
            <input type="hidden" name="nivel" value="{{ session('datos_alumno.nivel', old('nivel')) }}" required>
            <input type="hidden" name="carrera_nivels_id" value="{{ session('datos_alumno.carrera_nivels_id', old('carrera_nivels_id')) }}" required>
            <input type="hidden" name="grados_gra_id" value="{{ session('datos_alumno.grados_gra_id', old('grados_gra_id')) }}" required>
            <input type="hidden" name="grupos_gru_id" value="{{ session('datos_alumno.grupos_gru_id', old('grupos_gru_id')) }}" required>
            <input type="hidden" name="email" value="{{ session('datos_alumno.email', old('email')) }}" required>
            <input type="hidden" name="password" value="{{ session('datos_alumno.password', old('password')) }}" required>
            <input type="hidden" name="roles_rol_id" value="{{ session('datos_alumno.roles_rol_id', old('roles_rol_id')) }}" required>
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



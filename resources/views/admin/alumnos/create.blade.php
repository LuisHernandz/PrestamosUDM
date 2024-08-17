@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Nuevo Alumno') 

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')

    <div class="container-form">
        <form action="{{ route('admin/usuarios/alumnos.store') }}" method="POST">
        @csrf 

            <div class="form-title">
                <h2>Nuevo Alumno</h2> 

                <div class="btn-back">
                    <a href="{{ route('admin/usuarios/alumnos.index') }}"> 
                    <i class="fa-solid fa-circle-arrow-left"></i>
                        <p>Regresar</p>
                    </a>
                </div>
            </div>

            <h3>1. Datos personales</h3>

            <div class="row form-sub">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" value="{{old('alu_nombre')}}" name="alu_nombre">

                    @error('alu_nombre')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div>         
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" value="{{old('alu_apellidos')}}" name="alu_apellidos" id="lastname">

                    @error('alu_apellidos')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>Número de teléfono</label>
                    <input type="tel" class="form-control" value="{{old('alu_telefono')}}" name="alu_telefono">

                    @error('alu_telefono')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div> 
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>CURP</label>
                    <input type="text" class="form-control" value="{{old('curp')}}" name="curp" id="input-curp">

                    @error('curp')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>Dirección (Domicilio)</label>
                    <input type="text" class="form-control" value="{{old('alu_domicilio')}}" name="alu_domicilio">

                    @error('alu_domicilio')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div>               
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>Género</label>
                    <div class="container-input form-control">
                        <select class = "select" name="generos_gen_id" id="" >
                            @foreach($generos as $genero)
                                <option value="{{ $genero -> gen_id }}" {{ old('generos_gen_id') == $genero->gen_id ? 'selected' : '' }}> 
                                    {{ $genero -> gen_nombre }} 
                                </option>
                            @endforeach
                        </select>  
                    </div>

                    @error('generos_gen_id')
                        <p class= "msg-error">{{$message}}</p>
                    @enderror
                </div>
              </div>
            </div>

            <h3>2. Datos escolares</h3>

            <div class="row form-sub">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Matrícula</label>
                        <input type="text" class="form-control" value="{{old('alu_matricula')}}" name="alu_matricula">

                        @error('alu_matricula')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nivel</label>
                        <div class="container-input form-control">
            
                            <select name="nivel" id="firstSelect">
                                <option value="" hidden selected>Seleccionar</option>
                                @foreach ($niveles as $nivel)
                                    <option value="{{ $nivel->niv_id }}" {{ old('nivel') == $nivel->niv_id ? 'selected' : '' }}>
                                        {{ $nivel->niv_nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('nivel')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Carrera</label>
                        <div class="container-input form-control">
                            <select id="secondSelect" name="carrera_nivels_id">
                                <option value=""></option>
                                @if(old('carrera_nivels_id'))
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->car_id }}" {{ old('carrera_nivels_id') == $carrera->car_id ? 'selected' : '' }}>
                                            {{ $carrera->car_nombre }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                        </div>

                        @error('carrera_nivels_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Grado</label>
                        <div class="container-input form-control">

                            <select class="select" name="grados_gra_id" id="">
                                @foreach($grados as $grado)
                                    <option value="{{ $grado -> gra_id }}" {{ old('grados_gra_id') ==  $grado -> gra_id ? 'selected' : '' }}> {{ $grado -> gra_nombre }} </option>
                                @endforeach
                            </select>
                        </div>

                        @error('grados_gra_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Grupo</label>
                        <div class="container-input form-control">
                
                            <select class="select" name="grupos_gru_id" id="">
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo -> gru_id }}" {{ old('grupos_gru_id') ==  $grupo -> gru_id ? 'selected' : '' }}> {{ $grupo -> gru_nombre }} </option>
                                @endforeach
                            </select> 
                        </div>

                        @error('grupos_gru_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <h3>3. Datos de usuario</h3>

            <div class="row form-sub">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="text" class="form-control" value="{{old('email')}}" name="email">

                        @error('email')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror 

                        @if (session('success'))
                            <p class="msg-error"> {{ session('success') }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="input input-pass form-control" name="password" id="password"  value="{{old('password')}}">
                        <button type="button" class="btn-show-password" tabindex="-1" style="border: none; outline: none;">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>

                        @error('password')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Repetir contraseña</label>
                        <input class="input form-control" type="password" id = "password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}"> 
                            <button type="button" class="btn-show-password_confirmation" tabindex="-1" style="border: none; outline: none;">
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>

                        @error('password_confirmation')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <input type="text" name="roles_rol_id" value="3" hidden>

            <div class="container-buttons">
                <input type="submit" class="btn btn-success" value="Registrar">
                
                <a href="{{ route('admin/usuarios/alumnos.index') }}" class="btn-cancel">
                    <input type="button" class="btn btn-default" value="Cancelar">
                </a>
            </div>
        </form>
    </div>

    <!-- Petición AJAX -->
    <script>         
        $(document).ready(function() {
            $('#firstSelect').change(function() {
                var opcionSeleccionada = $(this).val();
    
                // Realiza la solicitud AJAX al controlador
                $.ajax({
                    url: '{{ route("/obtener-opciones/admin") }}',
                    type: 'GET',
                    data: {
                        opcionSeleccionada: opcionSeleccionada
                    },
                    success: function(response) {
                        // Actualiza las opciones del segundo select
                        var secondSelect = $('#secondSelect');
                        secondSelect.empty(); // Vaciar contenido previo del elemento select
    
                        // Agregar un option vacío al principio
                        // secondSelect.append('<option value="" hidden>Selecciona una opción.</option>');
    
                        // Agregar los registros como options
                        secondSelect.append(response);
                    } 
                });
            });
        });
    </script>

    <!-- Script para botón de ver contraseña -->
    <script>
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const showPasswordButton = document.querySelector('.btn-show-password');
            const showPasswordConfirmationButton = document.querySelector('.btn-show-password_confirmation');

            showPasswordButton.addEventListener('click', function() {

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordButton.innerHTML = '<i class="fa-solid fa-eye"></i>' ;
            } else {
                passwordInput.type = 'password';
                showPasswordButton.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            }
            });

            showPasswordConfirmationButton.addEventListener('click', function() {

                if (passwordConfirmationInput.type === 'password') {
                    passwordConfirmationInput.type = 'text';
                    showPasswordConfirmationButton.innerHTML = '<i class="fa-solid fa-eye"></i>' ;
                } else {
                    passwordConfirmationInput.type = 'password';
                    showPasswordConfirmationButton.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                }
                });
    </script>
        
    <!-- Script para convertir a máyusculas los caracteres ingresados al campo CURP -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('input-curp');
            
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@endsection

<!-- JQUERY -->
<script src="{{url('/assets/js/jquery.js')}}"></script>  
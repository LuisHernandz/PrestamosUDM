@extends('layouts.nav-librarian') 

@section('titulo', 'UDM - Modificar Alumno') 

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')

    <div class="container-form">
        <form action="{{ route('bibliotecario/usuarios/alumnos.update',['id' => $usuario -> id]) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-title">
                <h2>Modificar Alumno</h2>

                <div class="btn-back">
                    <a href="{{ route('/bibliotecario/libros/inventario.index') }}">
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
                        <input type="text" class="form-control" value="{{ $alumno -> alu_nombre }}" name="alu_nombre">

                        @error('alu_nombre')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{ $alumno -> alu_apellidos }}" name="alu_apellidos" id="lastname">

                        @error('alu_apellidos')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Número de teléfono</label>
                        <input type="tel" class="form-control" value="{{ $alumno -> alu_telefono }}" name="alu_telefono">

                        @error('alu_telefono')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>CURP</label>
                        <input type="text" class="form-control" value="{{ $alumno -> curp }}" name="curp" id="input-curp">

                        @error('curp')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" class="form-control" value="{{ $alumno -> alu_domicilio }}" name="alu_domicilio">

                        @error('alu_domicilio')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>

                  {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label>Género</label>
                        <div class="container-input form-control">
                            <select class = "select" name="generos_gen_id" id="" >
                                <option value="{{ $alumno->gen_id }}" hidden selected>
                                    {{ $genero->gen_nombre}}
                                </option>
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
                  </div> --}}

            
                </div>

            
                <h3>2. Datos escolares</h3>

            <div class="row form-sub">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Matrícula</label>
                        <input type="text" class="form-control" value="{{ $alumno -> alu_matricula }}" name="alu_matricula">

                        @error('alu_matricula')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div> 

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nivel</label>
                        <div class="container-input form-control">
            
                            <select id="firstSelect" name="nivel">
                                <option value="{{ $nivel->niv_id }}" hidden selected>
                                    {{ $nivel->niv_nombre }}
                                </option>
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
                                <option value="{{ $carrera -> carreras_car_id }}"> {{ $carrera->car_nombre }} </option>
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
                            <i class="fa-solid fa-graduation-cap"></i>
                            <select class="select" name="grados_gra_id" id="">
                                <option value="{{ $grado->gra_id }}" hidden selected>
                                    {{ $grado->gra_nombre}}
                                </option>

                                @foreach($grados as $grado)
                                    <option value="{{ $grado -> gra_id }}"> {{ $grado -> gra_nombre }} </option>
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
                            <i class="fa-solid fa-graduation-cap"></i>
                            <select class="" name="grupos_gru_id" id="">
                                <option value="{{ $grupo->gru_id }}" hidden selected>
                                    {{ $grupo->gru_nombre}}
                                </option>

                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo -> gru_id }}"> {{ $grupo -> gru_nombre }} </option>
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
                        <input type="text" class="form-control" value="{{ $usuario -> email }}" name="email">

                        @error('email')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

    
            </div>

            <input type="text" name="roles_rol_id" value="3" hidden>

            <div class="container-buttons">
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Actualizar">
                
                <a href="{{ route('bibliotecario/usuarios/alumnos.index') }}" class="btn-cancel" tabindex="16">
                    <input type="button" class="btn btn-default" value="Cancelar">
                    <!-- <button>Cancelar</button> -->
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
                    url: '{{ route("/obtener-opciones") }}',
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
                showPasswordButton.innerHTML = '<i class="bi bi-eye-fill"></i>' ;
            } else {
                passwordInput.type = 'password';
                showPasswordButton.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
            }
            });

            showPasswordConfirmationButton.addEventListener('click', function() {

                if (passwordConfirmationInput.type === 'password') {
                    passwordConfirmationInput.type = 'text';
                    showPasswordConfirmationButton.innerHTML = '<i class="bi bi-eye-fill"></i>' ;
                } else {
                    passwordConfirmationInput.type = 'password';
                    showPasswordConfirmationButton.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
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
@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Nuevo Bibliotecario') 

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')
    <div class="container-form">
        <form action="{{ route('/admin/usuarios/bibliotecarios.store') }}" method="POST">
        @csrf

        <div class="form-title">
            <h2>Nuevo Bibliotecario</h2>

            <div class="btn-back">
                <a href="{{ route('/admin/usuarios/bibliotecarios.index') }}">
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
                        <input type="text" class="form-control" value="{{old('bib_nombre')}}" name="bib_nombre">

                        @error('bib_nombre')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{old('bib_apellidos')}}" name="bib_apellidos" id="lastname">

                        @error('bib_apellidos')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Número de teléfono</label>
                        <input type="tel" class="form-control" value="{{old('telefono')}}" name="telefono">

                        @error('telefono')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección (Domicilio)</label>
                        <input type="text" class="form-control" value="{{old('domicilio')}}" name="domicilio">

                        @error('domicilio')
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

            <h3>2. Datos de usuario</h3>

            <div class="row form-sub">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="text" class="form-control" value="{{old('email')}}" name="email">

                        @error('email')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="input input-pass form-control" name="password" id="password"  value="{{old('password')}}">
                        <button type="button" class="btn-show-password">
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
                            <button type="button" class="btn-show-password_confirmation">
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>

                        @error('password_confirmation')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>
    
            </div>

            <input type="text" name="roles_rol_id" value="2" hidden>

            <div class="container-buttons">
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Registrar">
                
                <a href="{{ route('/admin/usuarios/bibliotecarios.index') }}" class="btn-cancel">
                    <input type="button" class="btn btn-default" value="Cancelar">
                    <!-- <button>Cancelar</button> -->
                </a>
            </div>
        </form>
    </div>

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

@endsection
@extends('layouts.app')
@section('titulo', 'UDM - Acceso')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/login.css')}}">
@endsection

@section('content')

	<div class="container">
		<div class="img">
			<img src="{{url('/assets/images/book2.svg')}}">
		</div>

		<div class="login-content"> 
            <form action="" method="POST" autocomplete="off">
                @csrf
				<img src="{{url('/assets/images/escudo.png')}}">
         
				<h2 class="title">Bienvenido</h2>
           		<div class="input-div one">
           		   <div class="i">
                        <i class="fa-solid fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Correo electrónico</h5>
           		   		<input type="text" name="email" class="input" value ="{{old('email')}}" required>
           		   </div>
           		</div>

                @error('email')
                    <p class="msg-error">{{$message}}</p>
                @enderror 
                
           		<div class="input-div pass">
           		   <div class="i"> 
                        <i class="fa-solid fa-key"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Contraseña</h5>
           		    	<input type="password" name="password" id="password" class="input input-pass" required>

                        <button type="button" class="btn-show-password" style="border: none; outline: none;">
                            <i class="fa-solid fa-eye-slash"></i>
                        </button>
            	   </div>
            	</div>

                @error('password')
                    <p class="msg-error">{{$message}}</p>
                @enderror

                @error('message')
                    <p class="msg-error">{{$message}}</p>
                @enderror

            	<a href="{{ route('/verificacion.index') }}" class="option-password">¿Olvidaste tu contraseña?</a>

            	<input type="submit" name="" id="" class="btn-session" value="iniciar sesión">

                <div class="create-user">
                    <p>¿Eres nuevo usuario?</p>
                    <a href="{{ route('registro.create') }}" class="option-register">Registro para alumnos UDM</a>
                </div>
            </form>
        </div>
	</div>

    @section('scripts_unicos')
        <script>
            const passwordInput = document.getElementById('password');
            const showPasswordButton = document.querySelector('.btn-show-password');
            showPasswordButton.addEventListener('click', function() {

            if (passwordInput.type === 'password') { 
                passwordInput.type = 'text';
                showPasswordButton.innerHTML = '<i class="fa-solid fa-eye"></i>' ;
            } else {
                passwordInput.type = 'password';
                showPasswordButton.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            }
            });
        </script>

        <script src="{{url('/assets/js/login.js')}}"></script>
    @endsection

@endsection
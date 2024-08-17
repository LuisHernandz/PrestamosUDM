@extends('layouts.app')
@section('titulo', 'UDM - Restablecer Contraseña')

@section('estilos_unicos')
    <link rel="stylesheet" href="{{url('/assets/css/restablecer.css')}}">
@endsection
 
@section('content')
    <div class="container">
        <form action="{{ route('/cambiar.store')}}" method="POST">
            @csrf
            <div class="form-title">
                <div class="form-title_img">
                    <img src="{{url('/assets/images/escudo.png')}}">
                    <h2>UDM</h2>
                </div>
            
                <h1>Restablecer contraseña</h1>
            </div>

            <p class="form-msg">A continuación ingresa la nueva contraseña para tu cuenta.</p>
            
            <div class="form-inputs">
                <div class="box-input">
                    <div class="form-group">
                        <div class="intPassword-container">
                            <input type="password" name="newPassword" id="password" class="input input-pass form-control" placeholder="Nueva contraseña.">
                            <button type="button" class="btn-show-password" style="border: none; outline: none;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        @if(session('usuario'))
                            <input type="hidden" name="usuario" value="{{ session('usuario') }}">
                        @endif

                        @error('newPassword')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror

                        @if (session('success'))
                            <div class="msg-registro" id="myDiv">
                                <p> {{ session('success') }}</p>
                                <div class="d-flex-right">
                                    <i class="bi bi-x-circle-fill" id="deleteIcon" title="Eliminar"></i>
                                </div>
                            </div> 
        
                            <script>
                                var deleteIcon = document.getElementById("deleteIcon");
                                var myDiv = document.getElementById("myDiv");
        
                                deleteIcon.addEventListener("click", function() {
                                    myDiv.parentNode.removeChild(myDiv);
                                });
                            </script> 
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
                     
    @endsection
@endsection


        

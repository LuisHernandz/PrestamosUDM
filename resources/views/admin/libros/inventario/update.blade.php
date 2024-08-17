@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Modificar Libro')

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')
    <div class="container-form">
        <form action="{{ route('/admin/libros/inventario.update',['id' => $bookSelected -> lib_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-title">
            <h2>Editar Libro</h2>

            <div class="btn-back">
                <a href="{{ route('/admin/libros/inventario.index') }}">
                <i class="fa-solid fa-circle-arrow-left"></i>
                    <p>Regresar</p>
                </a>
            </div>
        </div>

            <div class="row form-sub">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" value="{{$bookSelected -> lib_titulo}}" name="lib_titulo">

                        @error('lib_titulo')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Número de ejemplares</label>
                        <input type="number" class="form-control" value="{{$bookSelected -> lib_ejemplares}}" name="lib_ejemplares">

                        @error('lib_ejemplares')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Autor</label>
                        <div class="container-input form-control">
                            <i class="fa-solid fa-venus-mars"></i>
                            <select class = "select" name="autores_aut_id" id="opciones-autor" >
                                <option value="{{ $bookSelected -> aut_id }}">{{ $bookSelected -> aut_nombre }}</option>
                                @foreach($autores as $autor)
                                    @if ($autor -> aut_id != $bookSelected -> aut_id)
                                        <option value="{{ $autor -> aut_id }}" {{ old('autores_aut_id') == $autor->aut_id ? 'selected' : '' }}> 
                                            {{ $autor -> aut_nombre }} 
                                        </option>
                                    @endif
                                @endforeach
                                <option value="agregar-nuevo-autor">Agregar nuevo</option>
                            </select>  
                        </div>

                        @error('autores_aut_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    <div id="input-agregar-nuevo-autor" style="display: none;" class="">
                        <input  class="form-control" type="text" name="aut_nombre" placeholder="Nuevo autor">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Editorial</label>
                        <div class="container-input form-control">
                            <i class="fa-solid fa-venus-mars"></i>
                            <select class = "select" name="editoriales_edi_id" id="opciones-editorial" >
                                <option value="{{$bookSelected -> edi_id}}">{{$bookSelected -> edi_nombre}}</option>
                                @foreach($editoriales as $editorial)
                                    @if ($editorial -> edi_id != $bookSelected -> edi_id)
                                        <option value="{{ $editorial -> edi_id }}" {{ old('editoriales_edi_id') == $editorial->edi_id ? 'selected' : '' }}> 
                                            {{ $editorial -> edi_nombre }} 
                                        </option>
                                    @endif
                                @endforeach
                                <option value="agregar-nueva-editorial">Agregar nueva</option>
                            </select>  
                        </div>

                        @error('editoriales_edi_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    <div id="input-agregar-nueva-editorial" style="display: none;">
                        <input class="form-control" type="text" name="edi_nombre" placeholder="Nueva editorial">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nivel</label>
                        <div class="container-input form-control">
            
                            <select name="nivel" id="firstSelect">
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
                            <label>Descripción</label>
                                <textarea name="lib_descripcion" id="" cols="30" rows="10" class="form-control" name="lib_descripcion">{{$bookSelected -> lib_descripcion}}</textarea>
                            @error('lib_descripcion')
                                <p class= "msg-error">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fotografía</label>
                            <input type="file" class="form-control" value="" name="lib_foto" id="file-input">

                            <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                <div class="media">
                                    <span class="rounded-circle" style="margin: 0 auto; width: 150px; height: 150px;">
                                        <img src="{{ asset('storage').'/'.$bookSelected -> lib_foto }}" alt="" id="selected-image"  width="auto" height="100%" >                                                
                                    </span>
                                </div>    
                            </div> 

                            
                            @error('lib_foto')
                            <p class= "msg-error">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Año de publicación</label>
                            <input type="number" class="form-control" value="{{$bookSelected -> lib_aPublicacion}}" name="lib_aPublicacion">
                        </div>
                    </div>

            </div>


            <div class="container-buttons">
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Registrar">
                
                <a href="{{ route('/admin/libros/inventario.index') }}" class="btn-cancel">
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

    <script>
            document.getElementById('file-input').addEventListener('change', function() {
            const selectedImage = document.getElementById('selected-image');
            const fileInput = document.getElementById('file-input');
            const button = document.getElementById('file-button');
            const removeButton = document.getElementById('remove-image');
            
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                        selectedImage.src = e.target.result;
                        selectedImage.style.display = 'block';
                        selectedVideo.style.display = 'none';
                    button.innerHTML = '<i class="fa-solid fa-plus"></i> Agregar otra foto';
                    removeButton.style.display = 'block'; // Mostrar el botón "Quitar Imagen"
                };
                
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    </script>

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

    <script>
        document.getElementById("opciones-autor").addEventListener("change", function() {
            var seleccionado = this.value;
            var inputAgregarNuevo = document.getElementById("input-agregar-nuevo-autor");

            if (seleccionado === "agregar-nuevo-autor") {
                inputAgregarNuevo.style= "display:block; margin-bottom: 1rem";
            } else {
                inputAgregarNuevo.style.display = "none";
            }
        });
    </script>    
    
    <script>
        document.getElementById("opciones-editorial").addEventListener("change", function() {
            var seleccionado = this.value;
            var inputAgregarNuevo = document.getElementById("input-agregar-nueva-editorial");

            if (seleccionado === "agregar-nueva-editorial") {
                inputAgregarNuevo.style= "display:block; margin-bottom: 1rem";
            } else {
                inputAgregarNuevo.style.display = "none";
            }
        });
    </script>
@endsection

<!-- JQUERY -->
<script src="{{url('/assets/js/jquery.js')}}"></script>  
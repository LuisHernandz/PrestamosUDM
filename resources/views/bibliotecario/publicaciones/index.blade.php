@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Publicaciones')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">

<style> 
    body{
        color: #444; 
    }
    .principal-container{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-container{
        display: flex;
        flex-wrap: wrap;
        border:solid 1px #ddd;
        width: 500px;
        border-radius: 1rem;
        background-color: #fff;
    }

    .input-text{
        display: flex;
        width: 100%;
        padding: 11px;
    }

    .profile-add-publication{
        margin-right: 0.5rem;
    }

    .profile-add-publication a{
        display:flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50px;
        overflow: hidden;
        margin-right: 0.8rem;
    }

    .profile-add-publication img{
        width: auto;
        height: 100%;
    }

    .button-new-publication{
        display: flex;
        align-items: center;
        width: 100%;
        border:solid 1px #ddd;
        padding-left: 0.85rem;
        color: #444;
        border-radius: 1rem;
    }

    .button-new-publication:hover{
        color: #444;
    }
    
    .button-icon-plus{
        display: flex;
        align-items: center;
        justify-content: center;
        border: solid 0.5px #ccc;
        border-radius: 100px;
        margin-right: 1rem;
        color: #444;
    }
    
    .input-text i{
        padding: 0.5rem;
    }


    .icons-file{
        margin-left: 1rem;
        margin-top: 0.1;
        margin-bottom: 0.2;
    }

    .icons-file button{
        border: none;
        background: none;
    }

    .icons-file i{
        margin: 0.2rem;
        margin-right: 1rem;
        padding-bottom: 0.3rem;
        font-size: 1.3rem;
        color: #444;
    }

    .horizontal-line{
        width: 100%;
        margin-left: 1rem;
        margin-right: 1rem;
        margin-bottom: 0.5rem;
        border-bottom: solid 0.1px #ddd; 
    }
    
    .input-description{
        width: 100%;
        border: none;
        outline:none;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
        padding: 5px;
    }

    .body-file{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: solid 0.3px #ddd;
        border-radius: 0.5rem;
        padding: 0.3rem;
    }

    .icon-add{
        text-align: center;
        border: solid 0.2px grey;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 10px;
        padding: 20px;
        font-size: 20px;
    }

    .file-input {
    display: inline-block;
    position: relative;
    }

    #file-button {
        width: 95%;
        padding: 10px 20px;
        background-color: #D6DBDF;
        color: #32325d;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    #file-button:hover {
        background-color: #EBEDEF;
    }

    #file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }

    .image-container{
        width: 90%;
        border: solid 0.3px #D6DBDF;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-bottom: 1rem;
    }

    .image-container img{
        width: 100%;
        height: auto;
    }    
    
    .image-container video{
        width: 100%;
        height: auto;
    }

    .gallery {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Dos columnas con igual tamaño */
        gap: 10px; /* Espacio entre las imágenes */
        margin-bottom: 1rem;
    }

    .gallery img {
        width: 100%; /* Asegurar que la imagen ocupe todo el espacio de la columna */
        height: auto; /* Mantener la proporción original */
        border-radius: 5px; /* Bordes redondeados para las imágenes */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra ligera */
    }


    #remove-image {
        position: absolute; /*Colocar el botón en posición absoluta*/
        top: 0; /* Alinear en la parte superior */
        right: 0; /* Alinear en la parte izquierda */
        display: none; /* Inicialmente oculto */
        /* background: red; Cambia el color de fondo a tu preferencia */
        color: black; /* Cambia el color del texto a tu preferencia */
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    #selected-image, 
    #selected-video {
        display: none;
    }

    .new-publication{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 500px;
        align-self: center;
        margin-top: 2.5rem;
        background-color: #F4F6F6;
        border-radius: 0.7rem;
        background-color: #fff;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
        padding: 0 1rem 1rem 1rem;
    }

    .dropdown{
        align-self: end;
        margin-top: 3px;
        margin-right: 6px;
        
    }

    .actions-button{
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        border: none;
        outline: none;
        font-size: 18px;
        background-color: transparent;
        width: 30px;
        height: 30px;
    }

    .actions-button:hover{
        border-radius: 50px;
        background-color: #D5DBDB;
        border: none;
        outline: none;
    }

    .dropdown-menu{
        font-size: 50px;
    }

    .user-information{
        width: 100%;
        display: flex;
        align-items: center;
        line-height: 1.4rem
    }

    .user-profile{
        display:flex;
        align-items: center;
        justify-content: center;
        align-self: start;
        width: 50px;
        height: 50px;
        border-radius: 50px;
        overflow: hidden;
        margin-right: 0.8rem;
    }

    .user-profile img{
        width: auto;
        height: 100%;
    }


    .new-publication-description{
        margin: 1rem 0;
    }

    .new-publication-image{
        width: 100%;
        height: auto;
        margin-top: 0.5rem;
    }

    .new-publication-video{
        width: 100%;
        height: auto;
    }

    .publications-date{
        font-size: 0.7rem;
    }

</style>

@section('main')

    <div class="container-xl">

        <div class="principal-container">
            <div class="img-container">
                <div class="input-text">
                    <div class="profile-add-publication">
                        @foreach ($bibliotecarios as $usuario)
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">                                                                                                                                             
                                    @if (auth()->user()->id  == $usuario->usuarios_id)
                                        @if (empty($usuario -> foto))
                                            <img style="" src="{{url('/assets/images/no-user.png')}}">
                                        @else
                                            <img style="" src="{{ asset('storage').'/'.$usuario -> foto }}">
                                        @endif
                                    @endif                                                                                                                           
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <a class="button-new-publication" href="#addPublication" data-toggle="modal">Nueva publicación</a>
                </div>
                <div class="horizontal-line">
                    <div class="messages-error-input" style="color: red; margin-bottom: 0.8rem;">
                        @error('descripcion')
                            <p>{{ $message }}</p>
                        @enderror
                        @error('pub_foto')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="icons-file">
                    <a href="#addPublication" data-toggle="modal">
                        <button style="border: none; outline: none; cursor: pointer;">
                            <i class="fa-regular fa-images"></i>
                        </button>
                    </a>
                    <a href="#addPublication" data-toggle="modal">
                        <button style="border: none; outline: none; cursor: pointer;">
                            <i class="fa-solid fa-video"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @foreach ($publicaciones as $publicacion)
        <div class="new-publication">
            <div class="dropdown">
                <button class="actions-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#edit-{{$publicacion -> id}}" data-toggle="modal">Editar</a>
                    <a class="dropdown-item" href="#delete-{{$publicacion -> id}}" data-toggle="modal">Eliminar</a>
                </div>
            </div>

            <div class="user-information">
                <div class="user-profile">
                    @if (is_null($publicacion -> foto))
                        <img style="" src="{{url('/assets/images/no-user.png')}}">
                        
                    @else
                        <img src="{{ asset('storage').'/'.$publicacion -> foto }}" alt="">
                    @endif
                
                </div>
                <div class="user-name">
                    @if ($publicacion -> rol_id == 1)
                        <p>{{ $publicacion -> adm_nombre }} {{ $publicacion -> adm_apellidos }}</p>
                    @elseif ($publicacion -> rol_id == 2)
                        <p>{{ $publicacion -> bib_nombre }} {{ $publicacion -> bib_apellidos }}</p>
                    @endif
                    <p class="publications-date">{{ $publicacion->updated_at }}</p>
                </div>
            </div>

            <div>
                <p class="new-publication-description">{{ $publicacion -> descripcion }}</p>

                @if ($publicacion->pub_foto)
                    @if (Str::endsWith($publicacion->pub_foto, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img class="new-publication-image" src="{{ asset('storage').'/'. $publicacion->pub_foto }}" alt="Imagen">
                    @elseif (Str::endsWith($publicacion->pub_foto, ['.mp4', '.avi', '.mov']))
                        <video class="new-publication-video" controls>
                            <source src="{{ asset('storage').'/'. $publicacion->pub_foto }}" type="video/mp4">
                            Tu navegador no admite el elemento de video.
                        </video>
                    @endif
                @endif
            </div>

            <!-- <img class="new-publication-image" src="{{ asset('storage').'/'.$publicacion -> pub_foto }}" alt="imagen desciptiva">
            <video class="new-publication-video" src="{{ asset('storage').'/'.$publicacion -> pub_foto }}" controls></video> -->
        </div>
    @endforeach
@endsection

    <div id="addPublication" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ url('/bibliotecario/publicaciones/nueva-publicacion') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">						
                        <h4 class="modal-title">Nueva publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body"> 
                        <div class="body-publication">
                            <div class="body-description">
                                <textarea class="input-description" name="descripcion" id="" cols="30" rows="3" placeholder="Descripción de la publicación"></textarea>
                                <br>
                            </div>
                            <div class="body-file">
                                <div class="image-container">
                                    <!-- <button id="remove-image" style="display: none; border: none"><i class="fa-solid fa-xmark icon-remove"></i></button> -->
                                    <img id="selected-image" src="">
                                    <video id="selected-video" src="" controls></video>
                                </div>
                                <input type="file" id="file-input" accept="image/*,video/*" style="display: none;" name="pub_foto">
                                <button id="file-button">
                                    <i class="fa-solid fa-photo-film icon-add"></i><b></b>
                                    <p>Sube fotos o videos</p>
                                </button>
                            </div>
                            @if (auth()->check())
                                <input type="text" name="email" value ="{{ auth()->user()->email }}" hidden>
                            @endif 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="upload-button" value="Publicar">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($publicaciones as $publicacion )
    <div id="edit-{{$publicacion -> id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/bibliotecario/publicacion/update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <div class="modal-header">						
                        <h4 class="modal-title">Editar publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" name = "descripcion" required value="{{ $publicacion -> descripcion }}">
                        </div>
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name = "pub_foto" id="file-input-update-{{ $publicacion -> id }}" >
                            <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                <div class="media">
                                    <span class="rounded-circle" style="margin: 0 auto; width: 150px; height: 150px;">
                                        <img src="{{ asset('storage').'/'.$publicacion -> pub_foto }}" alt="" id="selected-image-update-{{$publicacion -> id}}"  width="auto" height="100%" >                                                
                                    </span>
                                </div>    
                            </div>     
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" name = "id" value="{{ $publicacion -> id }}" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Guardar cambios">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($publicaciones as $publicacion)
    <div id="delete-{{$publicacion -> id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/bibliotecario/publicacion/destroy/'.$publicacion -> id) }}" method = "post">
                    @csrf
                    {{ method_field ('DELETE') }}
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <p>¿Estás seguro de eliminar esta publicación?</p><br>
                        <p class="text-warning"><small>Esta acción no se podrá deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach


    <script>
        document.getElementById('file-button').addEventListener('click', function(event) {
            event.preventDefault(); // Evita la acción predeterminada (envío del formulario)
            document.getElementById('file-input').click();
        });


        document.getElementById('file-input').addEventListener('change', function() {
            const selectedVideo = document.getElementById('selected-video');
            const selectedImage = document.getElementById('selected-image');
            const fileInput = document.getElementById('file-input');
            const button = document.getElementById('file-button');
            const removeButton = document.getElementById('remove-image');
            
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (fileInput.files[0].type.startsWith('video/')) {
                        selectedVideo.src = e.target.result;
                        selectedVideo.style.display = 'block';
                        selectedImage.style.display = 'none';
                    } else if (fileInput.files[0].type.startsWith('image/')) {
                        selectedImage.src = e.target.result;
                        selectedImage.style.display = 'block';
                        selectedVideo.style.display = 'none';
                    }
                    button.innerHTML = '<i class="fa-solid fa-plus"></i> Agregar otra foto';
                    removeButton.style.display = 'block'; // Mostrar el botón "Quitar Imagen"
                };
                
                reader.readAsDataURL(fileInput.files[0]);
            }
        });

    </script>

    <script>

        function handleImagePreview(fileInputId, selectedImageId){
            const fileInput = document.getElementById(fileInputId);
            const selectedImage = document.getElementById(selectedImageId);

            fileInput.addEventListener('change', function(){
                if (fileInput.files && fileInput.files[0]){
                    const reader = new FileReader();
                    reader.onload = function(e){
                        selectedImage.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(fileInput.files[0]);
                }
            });
        }


        @foreach($publicaciones as $publicacion)
            handleImagePreview('file-input-update-{{ $publicacion -> id }}', 'selected-image-update-{{ $publicacion -> id }}');
        @endforeach

    </script>
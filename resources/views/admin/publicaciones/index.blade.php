@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Publicaciones')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/publicaciones.css')}}">

@section('main')

    <div class="container-xl">
        <div class="principal-container">
            <div class="img-container">
                <div class="input-text">
                    <div class="profile-add-publication">
                        @foreach ($administradores as $usuario)
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
                <button class="actions-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border: none; outline: none; cursor: pointer;">
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
        </div>
    @endforeach
@endsection

    <div id="addPublication" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ url('/admin/publicaciones/nueva-publicacion') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">						
                        <h4 class="modal-title">Nueva publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="body-publication">
                            <div class="body-description">
                                <textarea class="input-description" name="descripcion" id="" cols="30" rows="3" placeholder="Descripción de la publicación" ></textarea>
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
                                    <p>Sube una foto o video.</p>
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
                <form action="{{ url('/admin/publicacion/update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <div class="modal-header">						
                        <h4 class="modal-title">Editar publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" name = "descripcion" value="{{ $publicacion -> descripcion }}">
                        </div>
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name = "pub_foto" id="file-input-update-{{ $publicacion -> id }}" value=" ">
                            <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                <div class="media">
                                    <span class="rounded-circle">
                                        <img src="{{ asset('storage').'/'.$publicacion -> pub_foto }}" alt="" id="selected-image-update-{{$publicacion -> id}}">                                                
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
                <form action="{{ url('/admin/publicacion/destroy/'.$publicacion -> id) }}" method = "post">
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
                    button.innerHTML = 'Cambiar foto';
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

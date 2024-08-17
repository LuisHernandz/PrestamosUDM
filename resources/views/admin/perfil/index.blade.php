@extends('layouts.nav-admin')
@section('titulo', 'UDM - Perfil de usuario')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}"> 
<link rel="stylesheet" href="{{url('/assets/css/perfil.css')}}"> 


@section('main')

    <section class="">

      <div class="container" > 
        <div class="bg-white shadow rounded-lg d-block" > 
          <div class="form-title" style="padding:1.5rem; margin-bottom: 0;" >
              <h2>Perfil De Usuario</h2>

              <div class="btn-back">
                <a href="{{ route('admin.index') }}" onclick="goBack()">
                  <i class="fa-solid fa-circle-arrow-left"></i>
                  <p>Regresar</p>
                </a> 
              </div> 
          </div>
          <div class="d-sm-flex" style="border-top: 1px solid #e9ecef !important;">
            <div class="profile-tab-nav border-right">
              <div class="p-4">
                <div class="img-circle text-center mb-3">
                  
                  <div class="">
                    @if ($admin->foto !== null)
                      <img src="{{ asset('storage').'/'.$usuario -> foto }}" alt="Image" class="shadow">
                    @else
                      <img src="{{url('/assets/images/no-user.png')}}" alt="Image" class="shadow"> 
                    @endif
                    

                    <a href="#add" class="add-image btn-add" data-toggle="modal">
                      <i class="fa-solid fa-camera"></i>
                    </a>
                  </div>
                </div>

                <h4 class="usuario-nombre">
                  {{$admin -> adm_nombre}} {{$admin -> adm_apellidos}}
                </h4>

                <p class="text-center">Administrador</p> 
              
              </div>
            </div>
            <div class="tab-content p-4 p-md-4" id="v-pills-tabContent">
            

                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                  
                @if (session('success'))
                    <script>
                        alert("{{ session('success') }}");
                    </script>
                @endif



                  <h3 class="mb-4">Mi Información</h3>

                  <form action="{{ route('admin/perfil.update',['id' => $usuario -> id]) }}" method="POST">
                  @csrf
                  @method('PATCH') 

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" value="{{$admin -> adm_nombre}}" name="adm_nombre" required>

                            @error('adm_nombre')
                                <p class= "msg-error">{{$message}}</p>
                            @enderror
                        </div>


                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="{{$admin -> adm_apellidos}}" name="adm_apellidos" required>

                            @error('adm_apellidos')
                                <p class= "msg-error">{{$message}}</p>
                            @enderror
                        </div>


                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{$usuario -> email}}" name="email" required>

                            @error('email')
                                <p class= "msg-error">{{$message}}</p>
                            @enderror
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Género</label>
                            <div class="container-input form-control">
                                <i class="fa-solid fa-venus-mars"></i>
                                <select class = "select" name="generos_gen_id" id="" >

                                    <option value="{{ $admin -> gen_id }}" hidden selected>
                                        {{ $admin -> gen_nombre }}
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
                      </div>

                    </div>

                  
                    <div>
                      <!-- <button class="btn btn-success">Actualizar</button> -->
                      <input type="submit" class="btn btn-success" value="Actualizar">
                  
                      <input type="reset" class="btn btn-default" value="Resetear">
                    </div>

                  </form>
                </div>
       

            </div>
          </div>

        </div>
      </div>
    </section>

<script src="{{ url('/assets/js/btn-regresar.js') }}"></script>
<script src="{{ url('/assets/js/btn-disabled.js') }}"></script>

@endsection 

    <!-- Add Modal HTML -->

    <div id="add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ route('admin/perfil/image.update',['id' => $usuario -> id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- @method('PATCH')  -->
                    <div class="modal-header">						
                        <h4 class="modal-title">Nueva Foto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Selecciona la fotografía:</label>
                            <input type="file" class="form-control" name = "foto" required id="file-input">

                            

                              <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                  <div class="media">
                                      <span class="rounded-circle" style="margin: 0 auto; width: 150px; height: 150px;"> 
                                          <img src="{{ asset('storage').'/'.$admin -> foto }}" alt="" id="selected-image" width="auto" height="100%" >                                                                                                     
                                      </span>
                                  </div>    
                              </div>  
                       
                        </div>                   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="Agregar">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    </div>
                </form>
            </div>
        </div>
    </div>

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

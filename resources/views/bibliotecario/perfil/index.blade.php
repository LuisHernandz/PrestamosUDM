@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Perfil de usuario')

@php
    use Jenssegers\Date\Date; 
    Date::setLocale('es');
@endphp

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/perfil.css')}}">


@section('main') 

    <section class="">

      <div class="container" > 
        
        <div class="bg-white shadow rounded-lg d-block" > 
          <div class="form-title" style="padding:1.5rem; margin-bottom: 0;" >
              <h2>Perfil De Usuario</h2>

              <div class="btn-back">
                <a href="{{ route('bibliotecario.index') }}" onclick="goBack()">
                  <i class="fa-solid fa-circle-arrow-left"></i>
                  <p>Regresar</p>
                </a> 
              </div> 
          </div>
          <div class="d-sm-flex" style="border-top: 1px solid #e9ecef !important;">
            <div class="profile-tab-nav border-right">
              <div class="p-4">
                <div class="img-circle text-center mb-3">
                  
                  <!-- <img src="{{ asset('storage').'/'.$usuario -> foto }}" alt="Image" class="shadow"> -->
                  <div class="">
                    @if ($bibliotecario->foto !== null)
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
                  {{$bibliotecario -> bib_nombre}} {{$bibliotecario -> bib_apellidos}}
                </h4>
              
              </div>
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                  <i class="fa fa-home text-center mr-1"></i> 
                  Mi Información
                </a>
                <a class="nav-link" id="notification-tab" data-toggle="pill" href="#notification" role="tab" aria-controls="notification" aria-selected="false">
                  <i class="fa fa-bell text-center mr-1"></i> 
                  Notificaciones
                </a>
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

                  <form action="{{ route('bibliotecario/perfil.update',['id' => $usuario -> id]) }}" method="POST" style="height: 245px; overflow:;">
                    @csrf
                    @method('PATCH') 

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" value="{{$bibliotecario -> bib_nombre}}" name="bib_nombre">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="{{$bibliotecario -> bib_apellidos}}" name="bib_apellidos">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{$usuario -> email}}" name="email">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="tel" class="form-control" value="{{$bibliotecario -> telefono}}" name="telefono"> 
                        </div> 
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Domicilio</label>
                            <input type="text" class="form-control" value="{{$bibliotecario -> domicilio}}" name="domicilio"> 
                        </div> 
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Género</label>
                            <div class="container-input form-control">
                                <i class="fa-solid fa-venus-mars"></i>
                                <select class = "select" name="generos_gen_id" id="" >

                                    <option value="{{ $bibliotecario -> gen_id }}" hidden selected>
                                        {{ $bibliotecario -> gen_nombre }}
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
                      <input type="submit" class="btn btn-success" value="Actualizar">
                  
                      <input type="reset" class="btn btn-default" value="Resetear">
                    </div>

                  </form>
              </div>
         

              
              <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                
                <h3 class="mb-4">Notificaciones</h3>

                @if (session('notification'))
                    <script>
                        alert("{{ session('notification') }}");
                    </script>
                @endif

                <div class="containerNotificaciones">
                  @forelse ($notificacionesSP as $notificacionSP)
                    <a href="#show-{{$notificacionSP->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                      <div class="form-group">
                        <div class="form-check">
                          {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                          <div>
                            <div class="notificacion-icono"></div>
                          </div>
                          <label class="form-check-label" for="notification1">

                              @if($notificacionSP->data['solicitud_alumno_genero'] == 1)
                                El alumno
                              @else
                                La alumna
                              @endif

                              {{ $notificacionSP->data['solicitud_alumno_nombre'] }}  realizó la solicitud de préstamo del Libro '{{ $notificacionSP->data['solicitud_libro_titulo'] }}''. 
                          
                      
                          </label>

                          
                              {{-- <i class="bi bi-three-dots"></i> --}}
                          
                        </div>
                      </div>
                    </a>
                  @empty
                      <label>No tienes notificaciones.</label>
                  @endforelse
                </div>

                  <!-- <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="notification1">
                      <label class="form-check-label" for="notification1">

                      El alumno...
                   
                      </label>

                      <a href="#show" class="show" data-toggle="modal" title="Ver más información">
                        <i class="bi bi-three-dots"></i>
                      </a>
                    </div>
                  </div> -->

                <!-- <div>
                  <button class="btn btn-success">Update</button>
                  <button class="btn btn-light">Cancel</button>
                </div> -->
              
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <script>
        const currentPasswordInput = document.getElementById('currentPassword');
        const newPasswordInput = document.getElementById('newPassword');
        const newPasswordConfirmationInput = document.getElementById('newPasswordConfirmation');
        const showCurrentPasswordButton = document.querySelector('.btn-show-password');
        const showNewPasswordButton = document.querySelector('.btn-show-newPassword');
        const shoNewPasswordConfirmationButton = document.querySelector('.btn-show-newPasswordConfirmation');

        showCurrentPasswordButton.addEventListener('click', function() {

          if (currentPasswordInput.type === 'password') {
            currentPasswordInput.type = 'text';
            showCurrentPasswordButton.innerHTML = '<i class="bi bi-eye-fill"></i>' ;
          } else {
            currentPasswordInput.type = 'password';
            showCurrentPasswordButton.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
          }
        });


        showNewPasswordButton.addEventListener('click', function() {

          if (newPasswordInput.type === 'password') {
            newPasswordInput.type = 'text';
            showNewPasswordButton.innerHTML = '<i class="bi bi-eye-fill"></i>' ;
          } else {
            newPasswordInput.type = 'password';
            showNewPasswordButton.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
          }
        });

        shoNewPasswordConfirmationButton.addEventListener('click', function() {

            if (newPasswordConfirmationInput.type === 'password') {
                newPasswordConfirmationInput.type = 'text';
                shoNewPasswordConfirmationButton.innerHTML = '<i class="bi bi-eye-fill"></i>' ;
            } else {
                newPasswordConfirmationInput.type = 'password';
                shoNewPasswordConfirmationButton.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
            }
            });
    </script>



<script src="{{ url('/assets/js/modal-profile.js') }}"></script>
<script src="{{ url('/assets/js/btn-regresar.js') }}"></script>
<script src="{{ url('/assets/js/btn-disabled.js') }}"></script>

@endsection 

    <!-- Add Modal HTML -->

    <div id="add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ route('bibliotecario/perfil/image.update',['id' => $usuario -> id]) }}" method="POST" enctype="multipart/form-data">
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
                            <div style="display:flex; align-items:center; justify-content:center; width:80%; height: 270px; margin-top: 0.8rem; overflow:hidden">
                              <img src="{{ asset('storage').'/'.$bibliotecario -> foto }}" alt="" id="selected-image" width="auto" height="100%" >
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

    @foreach ($notificacionesSP as $notificacionSP)
      <div id="show-{{$notificacionSP->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
   

                      <div class="modal-header">						
                          <h4 class="modal-title">SOLICITUD DE PRESTÁMO</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                          
                      </div>

                      

                      <div class="modal-body">
                        <p>
                          Solicitud de prestámo realizada el {{ Date::parse($notificacionSP->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.
                        </p><br>

                        <i>Puedes ver los detalles de la solicitud en el apartado de Solicitudes.</i>

                      </div>
                      
                      <div class="modal-footer">
                          {{-- <input type="button" class="btn btn-default" data-dismiss="modal" value="Rechazar"> --}}
                          {{-- <input type="submit" class="btn btn-light confirmarBtn" value="Confirmar" id="" disabled> --}}
                          <a href="{{ route('/bibliotecario/solicitudes.index') }}">
                            <input type="submit" class="btn btn-success" value="Ir" id="">
                          </a>
                          
                      </div>
                  
              </div>
          </div>
      </div>
    @endforeach

    <script>
      function mostrarContenido(event) {
        var modalContainer = event.target.closest(".body-datosAprobacion");
        var contenidoDivsSi = modalContainer.querySelectorAll(".contenidoSi");
        var contenidoDivsNo = modalContainer.querySelectorAll(".contenidoNo");
        var radioOpcionSi = modalContainer.querySelector('input[name="opcion"][value="si"]:checked');
        
        if (radioOpcionSi) {
          mostrarDivs(contenidoDivsSi);
          ocultarDivs(contenidoDivsNo);
        } else {
          mostrarDivs(contenidoDivsNo);
          ocultarDivs(contenidoDivsSi);
        }
      }
      
      function mostrarDivs(divs) {
        divs.forEach(function(div) {
          div.style.display = "block";
        });
      }
      
      function ocultarDivs(divs) {
        divs.forEach(function(div) {
          div.style.display = "none";
        });
      }
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



      
      
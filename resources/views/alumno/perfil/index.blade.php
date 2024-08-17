@extends('layouts.nav-student')
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

      <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <a class="nav-link" id="notification-tab-link" data-toggle="pill" href="#notification" role="tab" aria-controls="notification" aria-selected="false">Notificaciones</a>
      </ul> -->

        
        <!-- style="height: 424.433px;" -->
        <!-- <h1 class="mb-5">Account Settings</h1> -->
        <div class="bg-white shadow rounded-lg d-block" > 
          <div class="form-title" style="padding:1.5rem; margin-bottom: 0;" >
              <h2>Perfil De Usuario</h2>

              <div class="btn-back">
                <a href="#" onclick="goBack()">
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
                    @if ($alumno->foto !== null)
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
                  {{$alumno -> alu_nombre}} {{$alumno -> alu_apellidos}}
                </h4>
              
              </div>
              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                  <i class="fa fa-home text-center mr-1"></i> 
                  Mi Información
                </a>
                {{-- <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                  <i class="fa fa-key text-center mr-1"></i> 
                  Cambiar Contraseña
                </a> --}}
                <a class="nav-link" id="notification-tab" data-toggle="pill" href="#notification" role="tab" aria-controls="notification" aria-selected="false">
                  <i class="fa fa-bell text-center mr-1"></i> 
                  Notificaciones
                </a>
              </div>
            </div>
            <div class="tab-content p-4 p-md-4" id="v-pills-tabContent"  style="height: 280px; overflow: auto;">
            
              <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">  
                  @if (session('success'))
                      <script>
                          alert("{{ session('success') }}");
                      </script>
                  @endif



                  <h3 class="mb-4">Mi Información</h3>

                  <form action="{{ route('/perfil.update',['id' => $usuario -> id]) }}" method="POST">
                  @csrf
                  @method('PATCH') 

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" value="{{$alumno -> alu_nombre}}" name="alu_nombre">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="{{$alumno -> alu_apellidos}}" name="alu_apellidos">
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
                            <label>CURP</label>
                            <input type="text" class="form-control" value="{{$alumno -> curp}}" name="curp">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Domicilio</label>
                            <input type="text" class="form-control" value="{{$alumno -> alu_domicilio}}" name="alu_domicilio">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Número de teléfono</label>
                            <input type="tel" class="form-control" value="{{$alumno -> alu_telefono}}" name="alu_telefono">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Género</label>
                            <div class="container-input form-control">
                                <i class="fa-solid fa-venus-mars"></i>
                                <select class = "select" name="generos_gen_id" id="" >

                                    <option value="{{ $alumno -> gen_id }}" hidden selected>
                                        {{ $alumno -> gen_nombre }}
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

                      <!-- <div class="col-md-12">
                        <div class="form-group">
                            <label>Bio</label>
                          <textarea class="form-control" rows="4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore vero enim error similique quia numquam ullam corporis officia odio repellendus aperiam consequatur laudantium porro voluptatibus, itaque laboriosam veritatis voluptatum distinctio!</textarea>
                        </div>
                      </div> -->
                    </div>

                  
                    <div>
                      <!-- <button class="btn btn-success">Actualizar</button> -->
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

                @php
                  $allNotifications = [];

                  foreach ($notificacionesSA as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'SA',
                          'contenido' => $notificacion,
                      ];
                  }

                  foreach ($notificacionesSE as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'SE',
                          'contenido' => $notificacion,
                      ];
                  }

                  foreach ($notificacionesSR as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'SR',
                          'contenido' => $notificacion,
                      ];
                  }

                  foreach ($notificacionesPA as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'PA',
                          'contenido' => $notificacion,
                      ];
                  }

                  foreach ($notificacionesPC as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'PC',
                          'contenido' => $notificacion,
                      ];
                  }
                  
                  foreach ($notificacionesPF as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'PF',
                          'contenido' => $notificacion,
                      ];
                  }

                  foreach ($notificacionesDF as $notificacion) {
                      $allNotifications[] = [
                          'fecha' => $notificacion->created_at,
                          'tipo' => 'DF',
                          'contenido' => $notificacion,
                      ];
                  }

                  usort($allNotifications, function ($a, $b) {
                      return $b['fecha'] <=> $a['fecha']; // Ordenar por fecha de creación en orden descendente
                  });
              @endphp

              <div class="containerNotificaciones">
                @forelse ($allNotifications as $notificacionData)
                    @php
                        $tipo = $notificacionData['tipo'];
                    @endphp

                    @if ($tipo === 'SA')
                      @php
                          $notificacionSA = $notificacionData['contenido'];
                      @endphp
                      
                      <a href="#show-{{$notificacionSA->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div>
                              <div class="notificacion-icono"></div>
                            </div>
                            <label class="form-check-label" for="notification1">
  
                              Tu solicitud de prestámo del libro "{{ $notificacionSA->data['libroPre_nombre'] }} " fue aceptado. Puedes pasar a recoger el libro
  
                                @if (isset($notificacionSA->data['prestamo_fechaFinal']))
                                    <!-- FechaInicio y FechaFinal se definieron... -->
                                    
                                    entre el  {{ Date::parse($notificacionSA->data['prestamo_fechaInicio'])->format('d \d\e F') }}
                                    y el {{ Date::parse($notificacionSA->data['prestamo_fechaFinal'])->format('d \d\e F \d\e Y') }}


                                    @if (isset($notificacionSA->data['prestamo_horaFinal']))
                                    <!-- horaInicio y horaFinal se definieron... -->
                                    de {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i') }}
                                    a {{ Date::parse($notificacionSA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                                    @else
                                      @if (isset($notificacionSA->data['prestamo_horaInicio']))
                                      a las {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                      @else
                                      
                                      @endif
                                    @endif
                                @else
                                    <!-- Solo se definio FechaInicio ... -->
                                    el {{ Date::parse($notificacionSA->data['prestamo_fechaInicio'])->format('d \d\e F \d\e Y') }},
                                    
                                    @if (isset($notificacionSA->data['prestamo_horaFinal']))
                                    <!-- horaInicio y horaFinal se definieron... -->
                                    de {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i') }}
                                    a {{ Date::parse($notificacionSA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                                    @else
                                      @if (isset($notificacionSA->data['prestamo_horaInicio']))
                                      a las {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                      @else
                                      
                                      @endif
                                    @endif
  
                                @endif
  
                            
                        
                            </label>
  
                            
                                {{-- <i class="bi bi-three-dots"></i> --}}
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'SR')
                      @php
                          $notificacionSR = $notificacionData['contenido'];
                      @endphp

                      <a href="#show-{{$notificacionSR->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div>
                              <div class="notificacion-icono"></div>
                            </div>

                            <label class="form-check-label" for="notification1">
                              Tu solicitud de prestámo del libro "{{ $notificacionSR->data['libroSol_nombre'] }}"  fue rechazada.
                            </label>
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'PA')
                      @php
                          $notificacionPA = $notificacionData['contenido'];
                      @endphp
                      <a href="#show-{{$notificacionPA->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div>
                              <div class="notificacion-icono"></div>
                            </div>
                            <label class="form-check-label" for="notification1">
      
                              Hola {{ $notificacionPA->data['alumno_nombre'] }}, se realizo el prestamo del libro {{ $notificacionPA->data['libroPre_nombre'] }}.
      
      
        
                        
                            </label>
      
                            
                                {{-- <i class="bi bi-three-dots"></i> --}}
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'PC')
                      @php
                          $notificacionPC = $notificacionData['contenido'];
                      @endphp
                      <a href="#show-{{$notificacionPC->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div class="notificacion-icono"></div>
                            <label class="form-check-label" for="notification1">
      
                              Hola {{ $notificacionPC->data['alumno_nombre'] }}, tu prestamo del libro {{ $notificacionPC->data['libroPre_nombre'] }} ha sido cancelado.
      
      
        
                        
                            </label>
      
                            
                                {{-- <i class="bi bi-three-dots"></i> --}}
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'PF')  
                      @php
                          $notificacionPF = $notificacionData['contenido'];
                      @endphp
                      <a href="#show-{{$notificacionPF->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div class="notificacion-icono"></div>
                            <label class="form-check-label" for="notification1"> 
      
                              Hola {{ $notificacionPF->data['alumno_nombre'] }}, gracias por cumplir con la devolución del libro "{{ $notificacionPF->data['libroPre_nombre'] }}".
      
      
        
                        
                            </label>
      
                            
                                {{-- <i class="bi bi-three-dots"></i> --}}
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'DF')
                      @php
                          $notificacionDF = $notificacionData['contenido'];
                      @endphp

                      <a href="#show-{{$notificacionDF->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <i class="fa-solid fa-book"></i>
                            <label class="form-check-label" for="notification1">

                              Debes entregar el libro mañana wey.



                        
                            </label>

                            
                                {{-- <i class="bi bi-three-dots"></i> --}}
                            
                          </div>
                        </div>
                      </a>
                    @elseif ($tipo === 'SE')
                      @php
                          $notificacionSE = $notificacionData['contenido'];
                      @endphp

                      <a href="#show-{{$notificacionSE->id}}" class="show notificacion" data-toggle="modal" title="Ver más información">
                        <div class="form-group">
                          <div class="form-check">
                            {{-- <input class="form-check-input" type="checkbox" value="" id="notification1"> --}}
                            <div>
                              <div class="notificacion-icono"></div>
                            </div>
                            <label class="form-check-label" for="notification1">
                              Realizaste la solicitud de prestámo del libro "{{ $notificacionSE->data['solicitud_libro_titulo'] }}".
                            </label>     
                          </div>
                        </div>
                      </a>
                    @else
                        <!-- Mensaje de tipo de notificación desconocido -->
                    @endif
                @empty
                    <label>No tienes notificaciones.</label>
                @endforelse
              </div>
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
            <form action="{{ route('/perfil/image.update',['id' => $usuario -> id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- @method('PATCH')  -->
                    <div class="modal-header">						
                        <h4 class="modal-title">Nueva Foto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Selecciona la fotografía:</label>
                            <input type="file" class="form-control" name = "foto" required>
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

    @foreach ($notificacionesSE as $notificacionSE)
      <div id="show-{{$notificacionSE->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="POST">
              
                    @csrf

                      <div class="modal-header">						
                          <h4 class="modal-title">SOLICITUD DE PRESTÁMO</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      
                      <div class="modal-body">
                        <p>
                          Solicitud de prestámo realizada el {{ Date::parse($notificacionSE->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.
                        </p>

                        <div class="body-datosLibro">
                          <h5>Datos Del Libro Solicitado</h5>
  
                          <div>
                              <p class="dato"> Título: <span>{{ $notificacionSE->data['solicitud_libro_titulo'] }}</span> </p>
                          </div>
  
                          <div>
                              <p class="dato"> Autor: <span>{{ $notificacionSE->data['solicitud_libro_autor'] }}</span></p>
                          </div> 

                          <div>
                            <p class="dato"> Nivel educativo: <span>{{ $notificacionSE->data['solicitud_libro_nivel'] }}</span></p>
                          </div>

                          <div>
                              <p class="dato"> Carrera: <span>{{ $notificacionSE->data['solicitud_libro_carrera'] }}</span></p>
                          </div>
                          
                      </div>
                      </div>
                      

                  </form>
              </div>
          </div>
      </div>
    @endforeach


    @foreach ($notificacionesSA as $notificacionSA)
      <div id="show-{{$notificacionSA->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="POST">
              
                    @csrf

                      <div class="modal-header">						
                          <h4 class="modal-title">SOLICITUD DE PRESTÁMO ACEPTADA</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      
                      <div class="modal-body">
                        <i> Se acepto la solicitud el <span>{{ Date::parse($notificacionSA->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.</span> </i>
                        <div class="body-datosLibro">
                          <h5>Datos Del Libro Solicitado</h5>
  
                          <div>
                              <p class="dato"> Título: <span>{{ $notificacionSE->data['solicitud_libro_titulo'] }}</span> </p>
                          </div>
  
                          <div>
                              <p class="dato"> Autor: <span>{{ $notificacionSE->data['solicitud_libro_autor'] }}</span></p>
                          </div> 

                          <div>
                            <p class="dato"> Nivel educativo: <span>{{ $notificacionSE->data['solicitud_libro_nivel'] }}</span></p>
                          </div>

                          <div>
                              <p class="dato"> Carrera: <span>{{ $notificacionSE->data['solicitud_libro_carrera'] }}</span></p>
                          </div>
                          
                        </div>

                        <div class="body-datosLibro">
                          <h5>¿Donde puedo pasar a recogerlo?</h5>
  
                          Puedes pasar a recoger el libro
  
                          @if (isset($notificacionSA->data['prestamo_fechaFinal']))
                              <!-- FechaInicio y FechaFinal se definieron... -->
                              
                              entre el  {{ Date::parse($notificacionSA->data['prestamo_fechaInicio'])->format('d \d\e F') }}
                              y el {{ Date::parse($notificacionSA->data['prestamo_fechaFinal'])->format('d \d\e F \d\e Y') }}


                              @if (isset($notificacionSA->data['prestamo_horaFinal']))
                              <!-- horaInicio y horaFinal se definieron... -->
                              de {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i') }}
                              a {{ Date::parse($notificacionSA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                              @else
                                @if (isset($notificacionSA->data['prestamo_horaInicio']))
                                a las {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                @else
                                
                                @endif
                              @endif
                          @else
                              <!-- Solo se definio FechaInicio ... -->
                              el {{ Date::parse($notificacionSA->data['prestamo_fechaInicio'])->format('d \d\e F \d\e Y') }},
                              
                              @if (isset($notificacionSA->data['prestamo_horaFinal']))
                              <!-- horaInicio y horaFinal se definieron... -->
                              de {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i') }}
                              a {{ Date::parse($notificacionSA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                              @else
                                @if (isset($notificacionSA->data['prestamo_horaInicio']))
                                a las {{ Date::parse($notificacionSA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                @else
                                
                                @endif
                              @endif

                          @endif

                          En las intalaciones de la UDM, Ocosingo Chiapas.

                          
                        </div>
                      </div>
                      
                  </form>
              </div>
          </div>
      </div>
    @endforeach

    @foreach ($notificacionesSR as $notificacionSR)
      <div id="show-{{$notificacionSR->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="POST">
              
                    @csrf

                      <div class="modal-header">						
                          <h4 class="modal-title">SOLICITUD DE PRESTÁMO RECHAZADA</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      
                      <div class="modal-body" style="height: auto;">
                        <p>
                          Tu solicitud de prestámo del libro "{{ $notificacionSR->data['libroSol_nombre'] }}"  fue rechazada.
                        </p>

                        <div class="body-datosLibro">

                            <i> Se rechazó el <span>{{ Date::parse($notificacionSR->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.</span> </i>

                          <div>
                            <p class="dato"> Motivo: 
                              <span>
                                @if (is_null($notificacionSR->data['solicitud_motivo']))
                                  No especificado.
                                @else
                                  {{ $notificacionSR->data['solicitud_motivo'] }}
                                @endif
                                                                
                              </span> 
                            </p>
                          </div>
                        </div>

                        

                      </div>
                      
                  </form>
              </div>
          </div>
      </div>
    @endforeach

    @foreach ($notificacionesPC as $notificacionPC)
      <div id="show-{{$notificacionPC->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="POST"> 
              
                    @csrf

                      <div class="modal-header">						
                          <h4 class="modal-title">PRESTÁMO CANCELADO</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      
                      <div class="modal-body" style="height: auto;">
                        <p>
                          Tu prestámo del libro "{{ $notificacionPC->data['libroPre_nombre'] }}"  fue cancelado.
                        </p>

                        <div class="body-datosLibro">

                            <i> Se canceló el <span>{{ Date::parse($notificacionPC->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.</span> </i>
                        </div>

                        

                      </div>
                      
                  </form>
              </div>
          </div>
      </div>
    @endforeach

    @foreach ($notificacionesPA as $notificacionPA)
      <div id="show-{{$notificacionPA->id}}" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form action="" method="POST"> 
              
                    @csrf 

                      <div class="modal-header">						
                          <h4 class="modal-title">PRESTÁMO REALIZADO</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      </div>

                      
                      <div class="modal-body" style="height: auto;">
                        <p>
                          Tu prestámo del libro "{{ $notificacionPA->data['libroPre_nombre'] }}"  se realizó con éxito.
                        </p><br>

                        {{-- <p>
                          La fecha de entrega del libro es: El
                          {{ Date::parse($notificacionPA->data['prestamo_fechaInicio'])->format('d \d\e F') }}
                        </p> --}}

                        <p>
                          Deberás entregar el libro:
                            @if (isset($notificacionPA->data['prestamo_fechaFinal']))
                                <!-- FechaInicio y FechaFinal se definieron... -->
                                
                                Entre el  {{ Date::parse($notificacionPA->data['prestamo_fechaInicio'])->format('d \d\e F') }}
                                y el {{ Date::parse($notificacionPA->data['prestamo_fechaFinal'])->format('d \d\e F \d\e Y') }}


                                @if (isset($notificacionPA->data['prestamo_horaFinal']))
                                <!-- horaInicio y horaFinal se definieron... -->
                                de {{ Date::parse($notificacionPA->data['prestamo_horaInicio'])->format('H:i') }}
                                a {{ Date::parse($notificacionPA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                                @else
                                    @if (isset($notificacionPA->data['prestamo_horaInicio']))
                                    a las {{ Date::parse($notificacionPA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                    @else
                                    
                                    @endif
                                @endif
                            @else
                                <!-- Solo se definio FechaInicio ... -->
                                El {{ Date::parse($notificacionPA->data['prestamo_fechaInicio'])->format('d \d\e F \d\e Y') }},
                                
                                @if (isset($notificacionPA->data['prestamo_horaFinal']))
                                <!-- horaInicio y horaFinal se definieron... -->
                                de {{ Date::parse($notificacionPA->data['prestamo_horaInicio'])->format('H:i') }}
                                a {{ Date::parse($notificacionPA->data['prestamo_horaFinal'])->format('H:i \h\o\r\a\s') }}.
                                @else
                                    @if (isset($notificacionPA->data['prestamo_horaInicio']))
                                    a las {{ Date::parse($notificacionPA->data['prestamo_horaInicio'])->format('H:i \h\o\r\a\s') }}.
                                    @else
                                    
                                    @endif
                                @endif

                            @endif
                        </p>

                        <div class="body-datosLibro">

                            <i> Prestámo realizado el <span>{{ Date::parse($notificacionPA->updated_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.</span> </i>
                        </div>

                        

                      </div>
                      
                  </form>
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




      
      
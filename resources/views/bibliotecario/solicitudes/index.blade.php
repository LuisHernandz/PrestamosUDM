@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Solicitudes') 

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/perfil.css')}}">


<style>
    thead tr th, td{
        width: 20%;
        overflow: hidden;
    }
</style>

@section('main')

    <div class="container-xl">

    @if (session('success'))
        <div class="msg-registro" id="myDiv">
            <p> {{ session('success') }} </p>
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

        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="" style="width: 50%;">
                            <h2>Historial De Solicitudes</h2>
                        </div>
                        <div class="" style="width: 50%;">
                            {{-- <a href="" class="btn btn-add">
                                <i class="material-icons">&#xE147;</i>
                                <span>Agregar Nuevo</span>
                            </a>
                             --}}
                            <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						 -->
                        </div>
                    </div>
                </div> 

                <div class="containerButtonsIndex">
                
                        <form action="{{ route('/bibliotecario/solicitudes.index') }}" class="input-search">
                                <input type="text" value="{{ $busqueda }}" name="busqueda" placeholder="Buscar por nombre de alumno o libro." style="width: 350px"> 
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form> 
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Fecha</th>
                            <th>Alumno (Solicitante)</th>
                            <th>Libro</th>
                            <th>Estado</th>
                            <th>Revisar</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud )
                        <tr>


                            <td>
                                {{ Date::parse($solicitud->created_at)->format('d/F/Y') }}
                            </td>
                            <td>{{ $solicitud -> alu_nombre }} {{ $solicitud -> alu_apellidos }} </td>
                            <td>
                                @php
                                    if (is_null($solicitud -> lib_tituloCorto)) {
                                        echo $solicitud -> lib_titulo ;
                                    } else {
                                        
                                        echo $solicitud -> lib_tituloCorto;
                                    }
                                @endphp
                                
                            </td>
                            <td>
                                @php
                                    if (is_null($solicitud -> sol_estado)) {
                                        echo "INDEFINIDA";
                                    } else {
                                        echo $solicitud -> sol_estado ;
                                    }
                                @endphp
                                
                            </td>
                            
                            <td>
                                <a href="#show-{{$solicitud->sol_id}}" class="show" data-toggle="modal" title="Ver más información">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </a> 
                                {{-- <a href="" class="edit">
                                    <i class="bi bi-pencil-square" data-toggle="tooltip" title="Editar"></i>
                                </a>
                                <a href="#delete-{{$solicitud -> sol_id}}" class="delete" data-toggle="modal">
                                    <i class="bi bi-trash-fill" data-toggle="tooltip" title="Eliminar"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

                

                <div class="clearfix">
                    <div class="hint-text">
                        <!-- Mostrando registros del <b>5</b> al <b>25</b> de un total de <b>100</b> -->
                        Mostrando registros del <b>{{ $solicitudes->firstItem() }}</b> al <b>{{ $solicitudes->lastItem() }}</b> de un total de <b>{{ $solicitudes->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($solicitudes->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$solicitudes->onFirstPage() ? $solicitudes->appends(['busqueda' => $busqueda])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($solicitudes->currentPage() - 2, 1);
                            $endPage = min($solicitudes->currentPage() + 2, $solicitudes->lastPage());
                        @endphp

                        @if ($solicitudes->lastPage() <= 5)
                            @foreach ($solicitudes->getUrlRange(1, $solicitudes->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $solicitudes->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $solicitudes->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $solicitudes->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($solicitudes->hasMorePages())
                            <li class="page-item">
                                {{-- <a href="{{ $solicitudes->nextPageUrl() }}" class="page-link page-next">Siguiente</a> --}}
                                <a href="{{ $solicitudes->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $solicitudes->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $solicitudes->url($solicitudes->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $solicitudes->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $solicitudes->currentPage() ? 'selected' : '' }}>
                                            Página {{ $page }}
                                        </option>
                                    @endfor
                                </select>

                                <input type="hidden" name="busqueda" value="{{ $busqueda }}">
                                
                                
                                <li class="page-item">
                                    <button type="submit" class="page-link page-next" style="background-color: none; border: none; font-weight: 500; margin-left: 10px; height: auto;">Ir</button> 
                                </li>
                                
                            </form>
                        </li>
                    </ul>
                </div> 
                 
            </div>
        </div>        
    </div>
    
    @php
        $usuario_id = null; // Inicializar la variable

        foreach ($bibliotecarios as $usuario) {
            if (auth()->user()->id == $usuario->usuarios_id) {
                $usuario_id = $usuario->id; // Asignar el valor a la variable
                break; // Romper el bucle una vez que se encuentra el valor
            }
        }
    @endphp


@endsection



@foreach ($solicitudes as $solicitud)
    <div id="show-{{$solicitud->sol_id}}" class="modal fade">
        <div class="modal-dialog modal-prestamos">
            <div class="modal-content">
                <form action="{{ route('/bibliotecario/prestamos/registro.store' , ['id' => $usuario_id]) }}" method="POST">
            
                @csrf

                    <div class="modal-header">						
                        <h4 class="modal-title">SOLICITUD DE PRESTÁMO</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        
                    </div>

                    
                    <div class="modal-body">
                        
                            <div>
                                <div>  
                                    <i>
                                    Realizada el {{ Date::parse($solicitud->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.
                                    </i>
                                </div>
                            </div>					

                            <div class="body-datosAlumno">
                                <h5>DATOS DEL ALUMNO (SOLICITANTE)</h5>
                                <div>
                                    <p class="dato">Matricula: <span> {{ $solicitud->alu_matricula }}</span></p>
                                </div>

                                <div>
                                    <p class="dato"> Nombre: <span> {{ $solicitud->alu_nombre }} {{ $solicitud->alu_apellidos }} </span></p>
                                </div>

                            </div>

                            <div class="body-datosLibro">
                                <h5>DATOS DEL LIBRO SOLICITADO</h5>
        
                                <div>
                                    <p class="dato"> Título: <span>{{ $solicitud->lib_titulo }}</span> </p>
                                </div>
        
                                <div>
                                    <p class="dato"> Autor: <span>{{ $solicitud->aut_nombre }}</span></p>
                                </div>
      
                                <div>
                                  <p class="dato"> Nivel educativo: <span>{{ $solicitud->car_nombre}}</span></p>
                                </div>
      
                                <div>
                                    <p class="dato"> Carrera: <span>{{ $solicitud->niv_nombre}}</span></p>
                                </div>
                            </div>

                            @if ( $solicitud->sol_estado === null)

                            <div class="body-datosAprobacion">
                                <h5>¿APROBAR LA SOLICITUD?</h5>
        
                                <div class="">
                                    <input type="radio" name="opcion" value="si" onclick="mostrarContenido(event)">
                                    <label class="">Sí</label>
        
                                    <input type="radio" name="opcion" value="no" onclick="mostrarContenido(event)">
                                    <label class="">No</label>
                                </div>
                            
                                <div style="display: none;" class="contenido contenidoSi">
                                    <!-- Aquí colocas el contenido para la opción "Sí" -->
                                    <p>
                                    A continuación, asigna la fecha y horario para que el alumno pueda pasar a recoger el libro.
                                    </p>
                                    
                                    <div class="containerInputsAprobacion">
                                    
                                        <div>
                                        <label for="">Fecha:</label><br>
                                        <div class="row form-sub">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>De:</label>
                                                <input type="date" class="form-control" value="{{old('')}}" name="fechaInicio">
                        
                                                @error('')
                                                    <p class= "msg-error">{{$message}}</p>
                                                @enderror
                                            </div>
                                            </div>
        
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hasta:</label>
                                                <input type="date" class="form-control" value="{{old('')}}" name="fechaFinal">
                        
                                                @error('')
                                                    <p class= "msg-error">{{$message}}</p>
                                                @enderror
                                            </div>
                                            </div>
        
        
                                        </div>
                                        </div>
                                        
                                        <div>
                                        <label for="">Horario:</label><br>
        
                                        <div class="row form-sub">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>De:</label>
                                                <input type="time" class="form-control" value="{{old('')}}" name="horaInicio">
                        
                                                @error('')
                                                    <p class= "msg-error">{{$message}}</p>
                                                @enderror
                                            </div>
                                            </div>
        
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>A las:</label>
                                                <input type="time" class="form-control" value="{{old('')}}" name="horaFinal">
                        
                                                @error('')
                                                    <p class= "msg-error">{{$message}}</p>
                                                @enderror
                                            </div>
                                            </div>
                                        </div>
        
                                        </div>
        
                                        <input type="text" name="alu_id" id="" value="{{ $solicitud->alumnos_id }}" hidden>
                                        <input type="text" name="lib_id" id="" value="{{ $solicitud->lib_id }}" hidden>
                                        <input type="text" name="sol_id" id="" value="{{ $solicitud->sol_id }}" hidden>
                                        {{-- <input type="text" name="estado" id="" value="prestado" hidden> --}}
                                
                                    </div>
                                    
                                </div>
                            
                                <div style="display: none;" class="contenido contenidoNo">
                                    <!-- Aquí colocas el contenido para la opción "No" -->
                                    <p>
                                    Si lo deseas, puedes escribir el motivo por el cual no se puede aceptar esta solicitud .
                                    </p>
        
                                    <div class="form-group">
        
                                    <textarea name="sol_motivo" id="" cols="30" rows="10" class="form-control" value="{{old('sol_motivo')}}"></textarea>
        
                                    @error('sol_motivo')
                                        <p class= "msg-error">{{$message}}</p>
                                    @enderror
                                    </div>
                                
                                </div>

                            </div>

                            @elseif ($solicitud->sol_estado === "ACEPTADO")
                            
                            <p style="text-align: center; margin: 1rem 0;">ESTA SOLICITUD YA FUE ACEPTADA, PUEDES VER MAS DETALLES EN EL APARTADO DE PRESTAMOS.</p>
                                
                            @else
                                
                            <p style="text-align: center; margin: 1rem 0;">ESTA SOLICITUD YA FUE RECHAZADA.</p>
                            @endif
                    </div>
                   
                    
                    <div class="modal-footer">
                        {{-- <input type="button" class="btn btn-default" data-dismiss="modal" value="Rechazar"> --}}
                        {{-- <input type="submit" class="btn btn-light confirmarBtn" value="Confirmar" id="" disabled> --}}
                        <input type="submit" class="btn btn-success" value="Confirmar" id="">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
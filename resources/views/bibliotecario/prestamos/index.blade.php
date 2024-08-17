@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Prestámos') 

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
                <i class="fa-solid fa-circle-xmark" id="deleteIcon" title="Eliminar"></i>
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
                            <h2>Prestamos</h2>
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
                
                    <form action="{{ route('/bibliotecario/prestamos.index') }}" class="input-search">
                            <input type="text" value="{{ $busqueda }}" name="busqueda" placeholder="Buscar por nombre de alumno o libro." style="width: 350px"> 
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form> 
            </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Fecha</th>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamos as $prestamo ) 
                        <tr>


                            <td>
                                {{ Date::parse($prestamo->created_at)->format('d/F/Y') }}
                            </td>
                            <td>{{ $prestamo -> alu_nombre }} {{ $prestamo -> alu_apellidos }} </td>
                            <td>
                                @php
                                if (is_null($prestamo -> lib_tituloCorto)) {
                                    echo $prestamo -> lib_titulo ;
                                } else {
                                    
                                    echo $prestamo -> lib_tituloCorto;
                                }
                            @endphp
                            </td>
                            <td>
                                @php
                                    if (is_null($prestamo -> estado)) {
                                        echo "EN PROCESO";
                                    } else {
                                        echo $prestamo -> estado ;
                                    }
                                @endphp
                                
                            </td>
                            
                            <td>
                            <a href="#show-{{$prestamo->pre_id}}" class="show" data-toggle="modal" title="Ver más información">
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
                        Mostrando registros del <b>{{ $prestamos->firstItem() }}</b> al <b>{{ $prestamos->lastItem() }}</b> de un total de <b>{{ $prestamos->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($prestamos->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$prestamos->onFirstPage() ? $prestamos->appends(['busqueda' => $busqueda])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($prestamos->currentPage() - 2, 1);
                            $endPage = min($prestamos->currentPage() + 2, $prestamos->lastPage());
                        @endphp

                        @if ($prestamos->lastPage() <= 5)
                            @foreach ($prestamos->getUrlRange(1, $prestamos->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $prestamos->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $prestamos->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $prestamos->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($prestamos->hasMorePages())
                            <li class="page-item">
                                {{-- <a href="{{ $prestamos->nextPageUrl() }}" class="page-link page-next">Siguiente</a> --}}
                                <a href="{{ $prestamos->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $prestamos->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $prestamos->url($prestamos->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $prestamos->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $prestamos->currentPage() ? 'selected' : '' }}>
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

    @foreach ($prestamos as $prestamo)
        <div id="show-{{$prestamo->pre_id}}" class="modal fade">
            <div class="modal-dialog modal-prestamos">
                <div class="modal-content">
                    <form action="{{ route('/bibliotecario/prestamoConfirmado.store' , ['id' => $usuario_id]) }}" method="POST">
                
                    @csrf

                        <div class="modal-header">						
                            <h4 class="modal-title">PRESTÁMO</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        
                        {{-- @if ()
                            Esta solicitud ya fue aprobada.
                        @else --}}
                        <div class="modal-body"> 
                            @if ( $prestamo->estado === null)
                                <div>
                                    <div>
                                        
                                        <i>
                                        Solicitud aceptada el {{ Date::parse($prestamo->created_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.
                                        </i>
                                    </div>
                                </div>					

                                <div class="body-datosAlumno">
                                    <h5>DATOS DEL ALUMNO (SOLICITANTE)</h5>
                                    <div>
                                        <p class="dato">Matricula: <span> {{ $prestamo->alu_matricula }}</span></p>
                                    </div>

                                    <div>
                                        <p class="dato"> Nombre: <span> {{ $prestamo->alu_nombre }} {{ $prestamo->alu_apellidos }} </span></p>
                                    </div>

                                </div>

                                <div class="body-datosLibro">
                                    <h5>DATOS DEL LIBRO SOLICITADO</h5>
            
                                    <div>
                                        <p class="dato"> Título: <span>{{ $prestamo->lib_titulo }}</span> </p>
                                    </div>
            
                                    <div>
                                        <p class="dato"> Autor: <span>{{ $prestamo->aut_nombre }}</span></p>
                                    </div>
          
                                    <div>
                                      <p class="dato"> Nivel educativo: <span>{{ $prestamo->car_nombre}}</span></p>
                                    </div>
          
                                    <div>
                                        <p class="dato"> Carrera: <span>{{ $prestamo->niv_nombre}}</span></p>
                                    </div>
                                </div>

                                <div class="body-datosLibro">
                                    <h5>EL ALUMNO DEBERA PASAR POR EL LIBRO...</h5>

                                    <p>
                                        @if (isset($prestamo->fechaFinal))
                                            <!-- FechaInicio y FechaFinal se definieron... -->
                                            
                                            Entre el  {{ Date::parse($prestamo->fechaInicio)->format('d \d\e F') }}
                                            y el {{ Date::parse($prestamo->fechaFinal)->format('d \d\e F \d\e Y') }}
            
            
                                            @if (isset($prestamo->horaFinal))
                                            <!-- horaInicio y horaFinal se definieron... -->
                                            de {{ Date::parse($prestamo->horaInicio)->format('H:i') }}
                                            a {{ Date::parse($prestamo->horaFinal)->format('H:i \h\o\r\a\s') }}
                                            @else
                                            a las {{ Date::parse($prestamo->horaFinal)->format('H:i \h\o\r\a\s') }}
                                            @endif
                                        @else
                                            <!-- Solo se definio FechaInicio ... -->
                                            El {{ Date::parse($prestamo->horaInicio)->format('d \d\e F \d\e Y') }},
                                            
                                            @if (isset($prestamo->horaFinal))
                                            <!-- horaInicio y horaFinal se definieron... -->
                                            de {{ Date::parse($prestamo->horaInicio)->format('H:i') }}
                                            a {{ Date::parse($prestamo->horaFinal)->format('H:i \h\o\r\a\s') }}.
                                            @else
                                            a las {{ Date::parse($prestamo->horaInicio)->format('H:i \h\o\r\a\s') }}.
                                            @endif
            
                                        @endif
                                    </p>
                                </div>

                                <div class="body-datosAprobacion">
                                    <h5>¿CONFIRMAR EL PRESTÁMO?</h5>

                                    <div class="">
                                        <input type="radio" name="opcion" value="si" onclick="mostrarContenido(event)">
                                        <label class="">Sí</label>

                                        <input type="radio" name="opcion" value="no" onclick="mostrarContenido(event)">
                                        <label class="">No</label>
                                    </div>
                                
                                    <div style="display: none;" class="contenido contenidoSi">
                                        <!-- Aquí colocas el contenido para la opción "Sí" -->
                                        <p>
                                        Antes de realizar el prestámo, asigna la fecha y hora en que se deberá entregar el libro.
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


                                            {{-- <input type="text" name="estado" id="" value="prestado" hidden> --}}
                                    
                                        </div>
                                        
                                    </div>
                                
                                    <div style="display: none;" class="contenido contenidoNo">
                                        <!-- Aquí colocas el contenido para la opción "No" -->
                                        <p>
                                        Si cancelas este prestámo, se notificara al alumno.
                                        </p>

                                        {{-- <div class="form-group">

                                        <textarea name="sol_motivo" id="" cols="30" rows="10" class="form-control" value="{{old('sol_motivo')}}"></textarea>

                                        @error('sol_motivo')
                                            <p class= "msg-error">{{$message}}</p>
                                        @enderror
                                        </div> --}}
                                    
                                    </div>

       

                                    <input type="hidden" name="alu_id" value="{{ $prestamo->alumnos_id }}">
                                    <input type="hidden" name="lib_id" value="{{ $prestamo->libros_lib_id }}">
                                    <input type="hidden" name="sol_id" value="{{ $prestamo->solicitud_sol_id }}">
                                    <input type="hidden" name="pre_id" value="{{ $prestamo->pre_id }}">

                                </div>

                            @elseif ($prestamo->estado === "PRESTADO")
                                <div>
                                    <div>
                                        
                                        <i>
                                        Prestamo realizado el {{ Date::parse($prestamo->updated_at)->format('d \d\e F \d\e Y, \a \l\a\s H:i \h\o\r\a\s') }}.
                                        </i>
                                    </div>
                                </div>					

                                <div class="body-datosAlumno">
                                    <h5>DATOS DEL ALUMNO (SOLICITANTE)</h5>
                                    <div>
                                        <p class="dato">Matricula: <span> {{ $prestamo->alu_matricula }}</span></p>
                                    </div>

                                    <div>
                                        <p class="dato"> Nombre: <span> {{ $prestamo->alu_nombre }} {{ $prestamo->alu_apellidos }} </span></p>
                                    </div>

                                </div>

                                <div class="body-datosLibro">
                                    <h5>DATOS DEL LIBRO SOLICITADO</h5>
            
                                    <div>
                                        <p class="dato"> Título: <span>{{ $prestamo->lib_titulo }}</span> </p>
                                    </div>
            
                                    <div>
                                        <p class="dato"> Autor: <span>{{ $prestamo->aut_nombre }}</span></p>
                                    </div>
        
                                    <div>
                                    <p class="dato"> Nivel educativo: <span>{{ $prestamo->car_nombre}}</span></p>
                                    </div>
        
                                    <div>
                                        <p class="dato"> Carrera: <span>{{ $prestamo->niv_nombre}}</span></p>
                                    </div>
                                </div>

                                <div class="body-datosLibro">
                                    <h5>PRESTAMO REALIZADO, EL ALUMNO DEBERA ENTREGAR EL LIBRO...</h5>

                                    <p>
                                        @if (isset($prestamo->fechaFinal))
                                            <!-- FechaInicio y FechaFinal se definieron... -->
                                            
                                            Entre el  {{ Date::parse($prestamo->fechaInicio)->format('d \d\e F') }}
                                            y el {{ Date::parse($prestamo->fechaFinal)->format('d \d\e F \d\e Y') }}


                                            @if (isset($prestamo->horaFinal))
                                            <!-- horaInicio y horaFinal se definieron... -->
                                            de {{ Date::parse($prestamo->horaInicio)->format('H:i') }}
                                            a {{ Date::parse($prestamo->horaFinal)->format('H:i \h\o\r\a\s') }}.
                                            @else
                                                @if (isset($prestamo->horaInicio))
                                                a las {{ Date::parse($prestamo->horaInicio)->format('H:i \h\o\r\a\s') }}.
                                                @else
                                                
                                                @endif
                                            @endif
                                        @else
                                            <!-- Solo se definio FechaInicio ... -->
                                            El {{ Date::parse($prestamo->fechaInicio)->format('d \d\e F \d\e Y') }},
                                            
                                            @if (isset($prestamo->horaFinal))
                                            <!-- horaInicio y horaFinal se definieron... -->
                                            de {{ Date::parse($prestamo->horaInicio)->format('H:i') }}
                                            a {{ Date::parse($prestamo->horaFinal)->format('H:i \h\o\r\a\s') }}.
                                            @else
                                                @if (isset($prestamo->horaInicio))
                                                a las {{ Date::parse($prestamo->horaInicio)->format('H:i \h\o\r\a\s') }}.
                                                @else
                                                
                                                @endif
                                            @endif

                                        @endif
                                    </p>
                                </div><br>
                                

                                @php
                                    $fechaInicio = new DateTime($prestamo->fechaInicio);
                                    $fechaActual = new DateTime();

                                    $diferencia = $fechaActual->diff($fechaInicio);
                                    $diasFaltantes = $diferencia->days;
                                    $horasFaltantes = $diferencia->h;
                                @endphp

                                @if ($fechaInicio <= $fechaActual)
                                    <i>La fecha de entrega del libro es hoy.</i><br><br>

                                    <div>
                                        <h5> ¿CONFIRMAR LA ENTREGA DEL LIBRO? </h5>
                                        <p>Si el libro ya fue devuelto, por favor confirmalo marcando la siguiente casilla:</p><br>

                                        <label for="">
                                            <input type="checkbox" class="checkbox">
                                            Confirmar
                                        </label>
                                        <br>

                                            <p>
                                            Escribe el estado del libro devuelto (Buen estado, Mal estado):
                                            </p>
                                            
                
                                            <div class="form-group" style="height: 80px;">
                
                                                <textarea name="sol_motivo" id=""  class="form-control" value="{{old('sol_motivo')}}"></textarea>
                    
                                                @error('sol_motivo')
                                                    <p class= "msg-error">{{$message}}</p>
                                                @enderror
                                            </div>

                                            <input type="hidden" class="form-control" value="FINALIZADO" name="fechaFinal">
                                            <input type="hidden" name="alu_id" value="{{ $prestamo->alumnos_id }}">
                                            <input type="hidden" name="lib_id" value="{{ $prestamo->libros_lib_id }}">
                                            <input type="hidden" name="pre_id" value="{{ $prestamo->pre_id }}"> 

                                        
                                    </div>
                                @else
                                    <i>Faltan {{ $diasFaltantes }} días y {{ $horasFaltantes }} horas para la entrega del libro.</i>

                                    <input type="checkbox" class="checkbox" hidden>
                                @endif

                                
                                
                            @else
                                
                                <p>EL PRESTAMO YA FINALIZO.</p>
                            @endif
                            

                        </div>
                        {{-- @endif --}}
                        
                        <div class="modal-footer">
                            {{-- <input type="button" class="btn btn-default" data-dismiss="modal" value="Rechazar"> --}}
                            {{-- <input type="submit" class="btn btn-light confirmarBtn" value="Confirmar" id="" disabled> --}}
                            @if ( $prestamo->estado === null)
                                <input type="submit" class="btn btn-toggle btn-success" value="Confirmar">
                            @else
                            <input type="submit" class="btn btn-toggle btn-light btn-confirmar" value="Confirmar" disabled="">
                            @endif
                            
                        </div>

      
                    </form>
                </div>
            </div>
        </div>


        
    @endforeach


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.checkbox');
            const btnConfirmar = document.querySelectorAll('.btn-confirmar');
    
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function () {
                    const btn = btnConfirmar[index];
    
                    if (this.checked) {
                        btn.classList.remove('btn-light');
                        btn.classList.add('btn-success');
                        btn.removeAttribute('disabled');
                    } else {
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-light');
                        btn.setAttribute('disabled', '');
                    }
                });
            });
        });
    </script>
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

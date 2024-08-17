@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Alumnos')
 
<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">

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
                            <h2>Alumnos</h2>
                        </div>
                        <div class="" style="width: 50%;">
                            <a href="{{ route('bibliotecario/usuarios/alumnos.create') }}" class="btn btn-add" >
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Agregar Nuevo</span>
                            </a> 
                        </div>
                    </div>
                </div>

                <div class="containerButtonsIndex">
                    <div>
                        <form action="{{ route('bibliotecario/usuarios/alumnos.index') }}" class="input-search">
                            <input type="text" value="{{ $busqueda }}" name="busqueda" placeholder="Buscar por nombre, apellidos o matricula." style="width: 300px;">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div> 
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Correo electrónico</th>
                            <th>Número de teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario )
                        <tr>
                            <td>{{ $usuario -> alu_matricula }}</td>
                            <td>{{$usuario -> alu_nombre}} {{$usuario -> alu_apellidos}}</td>
                            <td>{{$usuario -> email}}</td>
                            <td>{{ $usuario -> alu_telefono }}</td>
                            
                            <td>
                                <a href="#show-{{$usuario -> id}}" class="show" data-toggle="modal" title="Ver más información">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </a>
                                <a href="{{ url('bibliotecario/usuarios/alumnos/modificar/'.$usuario -> id) }}" class="edit">
                                    <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                </a>
                                <a href="#delete-{{$usuario -> id}}" class="delete" data-toggle="modal">
                                    <i class="fa-solid fa-trash" data-toggle="tooltip" title="Eliminar"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text">
                        <!-- Mostrando registros del <b>5</b> al <b>25</b> de un total de <b>100</b> -->
                        Mostrando registros del <b>{{ $usuarios->firstItem() }}</b> al <b>{{ $usuarios->lastItem() }}</b> de un total de <b>{{ $usuarios->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($usuarios->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$usuarios->onFirstPage() ? $usuarios->appends(['busqueda' => $busqueda])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($usuarios->currentPage() - 2, 1);
                            $endPage = min($usuarios->currentPage() + 2, $usuarios->lastPage());
                        @endphp

                        @if ($usuarios->lastPage() <= 5)
                            @foreach ($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url) 
                                <li class="page-item {{ $page == $usuarios->currentPage() ? 'active' : '' }}">
                                    {{-- <a href="{{ $url }}" class="page-link">{{ $page }}</a>  --}}
                                    <a href="{{ $usuarios->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $usuarios->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $usuarios->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor 
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($usuarios->hasMorePages())
                            <li class="page-item">
                                {{-- <a href="{{ $usuarios->nextPageUrl() }}" class="page-link page-next">Siguiente</a> --}}
                                <a href="{{ $usuarios->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $usuarios->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $usuarios->url($usuarios->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $usuarios->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $usuarios->currentPage() ? 'selected' : '' }}>
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
@endsection
    
<!-- Show Modal HTML -->
@foreach ($usuarios as $usuario )
    <div id="show-{{$usuario -> id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Datos Del Alumno:</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div>
                            <p>
                                <span>Matrícula:</span> {{ $usuario -> alu_matricula }}
                            </p>
                        </div>

                        <div class = "">
                            <p><span>Nombre:</span> {{$usuario -> alu_nombre}} {{$usuario -> alu_apellidos}}</p>
                        </div>

                        <div class = "">
                            <p><span>CURP:</span> {{$usuario -> curp}}</p>
                        </div>

                        <div class = "">
                            <p><span>Género:</span> {{$usuario -> gen_nombre}}</p>
                        </div>   
                                            
                        <div class = "">
                            <p><span>No. Teléfono:</span> {{$usuario -> alu_telefono}}</p>
                        </div>
                        
                        <div class = "">
                            <p><span>Domicilio:</span> {{$usuario -> alu_domicilio}}</p>
                        </div>
                                                
                        <div class = "">
                            <p><span>Nivel:</span> {{$usuario -> niv_nombre}}</p>
                        </div>

                        <div class = "">
                            <p><span>Carrera:</span> {{$usuario -> car_nombre}}</p>
                        </div>

                        <div class = "">
                            <p><span>Grado:</span> {{$usuario -> gra_nombre}}</p>
                        </div>

                        <div class = "">
                            <p><span>Grupo:</span> {{$usuario -> gru_nombre}}</p>
                        </div>

                        <div class = "">
                            <p><span>Correo:</span> {{$usuario -> email}}</p>
                        </div><br>

                        <div class = "text-center">
                            <p><span>Foto de usuario:</span>
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle" style="margin: 0 auto; width: 60px; height: 60px;">
                                        @if (empty($usuario -> foto))
                                            <img style="" src="{{url('/assets/images/no-user.png')}}">
                                        @else
                                            <img style="" src="{{ asset('storage').'/'.$usuario -> foto }}">
                                        @endif                                                       
                                    </span>
                                </div>        
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Regresar">
                        <!-- <input type="submit" class="btn btn-info" value="Save"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Delete Modal HTML -->
@foreach ($usuarios as $usuario)
    <div id="delete-{{$usuario -> id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('admin/usuarios/alumnos/eliminar/'.$usuario -> id) }}" method = "post">
                    @csrf
                    {{ method_field ('DELETE') }}
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar Alumno</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <p>¿Estás seguro de eliminar este registro?</p><br>
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

 
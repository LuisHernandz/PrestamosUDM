@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Inventario De Libros') 

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}"> 
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
                            <h2>Inventario</h2>
                        </div>
                        <div class="dropdown" style="width: 50%;">
                            <button class="btn btn-add " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Agregar Nuevo</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('/admin/libros/inventario.create') }}">Físico</a>
                                <a class="dropdown-item" href="{{ route('admin/libros/inventario/digitales/create') }}">Digital (PDF)</a>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="containerButtonsIndex">
                    <div style="display: flex;">
                        <form action="{{ route('/admin/libros/inventario.index') }}" class="input-search">
                                <input type="text" value="{{ $busqueda }}" name="busqueda" placeholder="Buscar por titulo o autor."> 
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form> 

                        <div class="col-md-6"> 
                            <div class="form-group" style=" margin-bottom: 0;">
                                <form action="{{ route('/admin/libros/inventario.index') }}" class="input-search">
                                    <div class="container-input form-control"  style="height: 30.4px; padding:0.625rem 0 0.635rem 0.75rem;">
                                        <select name="orden" style="font-size: 0.8rem;">
                                            @if (isset($orden))
                                                <option value="{{ $orden }}" hidden>
                                                    @if ($orden === 'alfabetico')
                                                        Orden Alfabetico (A - Z)
                                                    @else
                                                        Más recientes
                                                    @endif
                                                </option>
                                            @else
                                                <option value="" hidden> Ordenar por... </option>
                                            @endif
    
                                            
                                            <option value="alfabetico">Orden Alfabetico (A - Z)</option>
                                            <option value="recientes">Más recientes</option>
                                        </select>
                                        {{-- <input type="submit" value="Enviar" > --}}
                                        <button type="submit" style="margin-left: 0.75rem;"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    
                                </form>
                            </div>  
                        </div> 
                    </div>

                    
                    

                    <div>
                        <a href=" {{ route('/admin/libros/inventario/pdf/filtro.index') }} " class="icon-pdf" title="Reporte PDF">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>
                        <a href="{{route('export-excel-csv-file')}}" class="icon-excel" title="Reporte Excel">
                            <i class="fa-solid fa-file-excel"></i> 
                        </a>
                    </div>

                    
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Autor</th>
                            {{-- <th>Nivel</th> --}}
                            <th>Carrera</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($libros as $libro )
                        <tr>
                            <td>
                                {{ Str::limit($libro -> lib_titulo, 40) }}
                            </td>
                            <td>{{ Str::limit($libro -> aut_nombre, 30) }}</td>
                            <td>
                                {{ Str::limit($libro -> car_nombre, 30) }}
                            </td>
                            <td>
                                @if (!empty($libro->lib_archivo))
                                    <p>Digital(PDF)</p>
                                    <!-- <a href="{{ asset('storage/' . $libro->lib_archivo) }}" download="{{ $libro->lib_titulo }}.pdf"><i class="fa-solid fa-file-arrow-down" style="font-size: 25px"></i></a> -->
                                @else
                                    <p>Físico</p>
                                @endif
                            </td>
                            <td>
                                @if(!empty($libro -> lib_archivo))
                                    <a href="#showPdf-{{$libro -> lib_id}}" class="show" data-toggle="modal" title="Ver más información">
                                        <i class="fa-solid fa-ellipsis"></i> 
                                    </a>
                                    <a href="{{ url('/admin/libros/inventario/digitales/update/'.$libro->lib_id) }}" class="edit">
                                        <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                    </a>
                                    <a href="#deletePdf-{{$libro -> lib_id}}" class="delete" data-toggle="modal">
                                        <i class="fa-solid fa-trash" data-toggle="tooltip" title="Eliminar"></i>
                                    </a>
                                @else
                                    <a href="#show-{{$libro -> lib_id}}" class="show" data-toggle="modal" title="Ver más información">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </a>
                                    <a href="{{ url('admin/libros/inventario/update/'.$libro->lib_id) }}" class="edit">
                                        <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                    </a>
                                    <a href="#delete-{{$libro -> lib_id}}" class="delete" data-toggle="modal">
                                        <i class="fa-solid fa-trash" data-toggle="tooltip" title="Eliminar"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

 
                <div class="clearfix">
                    <div class="hint-text">
                        <!-- Mostrando registros del <b>5</b> al <b>25</b> de un total de <b>100</b> -->
                        Mostrando registros del <b>{{ $libros->firstItem() }}</b> al <b>{{ $libros->lastItem() }}</b> de un total de <b>{{ $libros->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($libros->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$libros->onFirstPage() ? $libros->appends(['busqueda' => $busqueda, 'orden' => $orden])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($libros->currentPage() - 2, 1);
                            $endPage = min($libros->currentPage() + 2, $libros->lastPage());
                        @endphp

                        @if ($libros->lastPage() <= 5)
                            @foreach ($libros->getUrlRange(1, $libros->lastPage()) as $page => $url) 
                                <li class="page-item {{ $page == $libros->currentPage() ? 'active' : '' }}">
                                    {{-- <a href="{{ $url }}" class="page-link">{{ $page }}</a>  --}}
                                    <a href="{{ $libros->appends(['busqueda' => $busqueda, 'orden' => $orden])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $libros->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $libros->appends(['busqueda' => $busqueda, 'orden' => $orden])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor 
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($libros->hasMorePages())
                            <li class="page-item">
                                {{-- <a href="{{ $libros->nextPageUrl() }}" class="page-link page-next">Siguiente</a> --}}
                                <a href="{{ $libros->appends(['busqueda' => $busqueda, 'orden' => $orden])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $libros->appends(['busqueda' => $busqueda, 'orden' => $orden])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $libros->url($libros->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $libros->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $libros->currentPage() ? 'selected' : '' }}>
                                            Página {{ $page }}
                                        </option>
                                    @endfor
                                </select>

                                <input type="hidden" name="busqueda" value="{{ $busqueda }}">
                                <input type="hidden" name="orden" value="{{ $orden }}">
                                
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
@foreach ($libros as $libro)
    <div id="show-{{$libro -> lib_id}}" class="modal fade">
        <div class="modal-dialog"  style="max-width: 500px;">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">Datos Del Libro:</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class = "">
                            <p><span>Título: </span>
                                {{-- {{}} --}}
                                <!-- En tu vista utilizando Blade -->
                                {{ $libro -> lib_titulo }}

                            </p>
                        </div>
                        <div class = "">
                            <p><span>Descripción:</span> {{$libro -> lib_descripcion}}</p>
                        </div>

                        <div class = "">
                            <p><span>Autor:</span> {{$libro -> aut_nombre}}</p>
                        </div>   
                                            
                        <div class = "">
                            <p><span>Editorial:</span> {{$libro -> edi_nombre }}</p>
                        </div>

                        <div>
                            <p><span>Año de publicación:</span> {{ $libro -> lib_aPublicacion }}</p>
                        </div>
                        
                        <div class = "">
                            <p><span>Número de ejemplares:</span> {{$libro -> lib_ejemplares}}</p>
                        </div>
                                                
                        <div class = "">
                            <p><span>Nivel:</span> {{$libro -> niv_nombre}}</p>
                        </div>                        
                        
                        <div class = "">
                            <p><span>Carrera:</span> {{$libro -> car_nombre}}</p>
                        </div>

                        @if ($libro -> lib_foto === 'Sin Imagen')
                            <i>Sin Imagen</i>
                        @else
                            <div class = "">
                                <p><span>Foto:</span></p><br>
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm" style="width: 200px; height: 200px; background-color: transparent;">
                                        <img src="{{ asset('storage').'/'.$libro -> lib_foto }}" style="border-radius: 0;">                                                 
                                    </span>
                                </div>    
                            </div>
                        @endif 
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

<!-- Show Modal HTML -->
@foreach ($libros as $libro)
    <div id="showPdf-{{$libro -> lib_id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">						
                        <h4 class="modal-title">DATOS DEL LIBRO PDF</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class = "">
                            <p><span>Título:</span> {{$libro -> lib_titulo}}</p>
                        </div>
                        <div class = "">
                            <p><span>Descripción:</span> {{$libro -> lib_descripcion}}</p>
                        </div>

                        <div class = "">
                            <p><span>Autor:</span> {{$libro -> aut_nombre}}</p>
                        </div>   
                                            
                        <div class = "">
                            <p><span>Editorial: </span>{{$libro -> edi_nombre }}</p>
                        </div>
                                                
                        <div class = "">
                            <p><span>Nivel:</span> {{$libro -> niv_nombre}}</p>
                        </div>                        
                        
                        <div class = "">
                            <p><span>Carrera:</span> {{$libro -> car_nombre}}</p>
                        </div>

                        <div class="text-center">
                            <p><span>Descargar PDF</span></p>
                            <a href="{{ asset('storage/' . $libro->lib_archivo) }}" download="{{ $libro->lib_titulo }}.pdf" class="icon-pdf" style="width: max-content; margin:10px auto;">
                                <i class="fa-solid fa-file-pdf fa-beat-fade"></i>
                            </a>
                            <!-- <img style="width: 200; height: auto;" src="{{ asset('storage').'/'.$libro -> lib_foto }}" alt="foto del libro"> -->
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
@foreach ($libros as $libro)
    <div id="delete-{{$libro -> lib_id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/admin/libros/inventario/delete/'.$libro -> id) }}" method = "post">
                    @csrf
                    {{ method_field ('DELETE') }}
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar libro</h4>
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

@foreach ($libros as $libro)
    <div id="deletepdf-{{$libro -> lib_id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/admin/libros/inventario/digitales/destroy/'.$libro -> id) }}" method = "post">
                    @csrf
                    {{ method_field ('DELETE') }}
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar Libro PDF</h4>
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

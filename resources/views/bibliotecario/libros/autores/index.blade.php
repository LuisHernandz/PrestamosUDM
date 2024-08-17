@extends('layouts.nav-librarian') 
@section('titulo', 'UDM - Autores') 

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
                            <h2>Autores</h2>
                        </div>
                        <div class="" style="width: 50%;">
                            <a href="#add" class="btn btn-add" data-toggle="modal">  
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Agregar Nuevo</span>
                            </a>
                            
                        </div>
                    </div>
                </div>

                <div class="containerButtonsIndex">
                    <div style="display: flex;">
                        <form action="{{ route('/bibliotecario/libros/autores.index') }}" class="input-search"> 
                                <input type="text" value="{{ $busqueda }}" name="busqueda" placeholder="Buscar por nombre."> 
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form> 
                    </div>
                </div> 


                <table class="table table-striped table-hover">
                    <thead>
                        <tr>

                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($autores as $autor )
                        <tr>
                            <td>{{$autor -> aut_nombre}}</td>
                            
                            <td>
                                <a href="#edit-{{$autor -> aut_id}}" class="edit" data-toggle="modal">
                                    <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                </a>
                                <a href="#delete-{{$autor -> aut_id}}" class="delete" data-toggle="modal">
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
                        Mostrando registros del <b>{{ $autores->firstItem() }}</b> al <b>{{ $autores->lastItem() }}</b> de un total de <b>{{ $autores->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($autores->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$autores->onFirstPage() ? $autores->appends(['busqueda' => $busqueda])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($autores->currentPage() - 2, 1);
                            $endPage = min($autores->currentPage() + 2, $autores->lastPage());
                        @endphp

                        @if ($autores->lastPage() <= 5)
                            @foreach ($autores->getUrlRange(1, $autores->lastPage()) as $page => $url) 
                                <li class="page-item {{ $page == $autores->currentPage() ? 'active' : '' }}">
                                    {{-- <a href="{{ $url }}" class="page-link">{{ $page }}</a>  --}}
                                    <a href="{{ $autores->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $autores->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $autores->appends(['busqueda' => $busqueda])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor 
                        @endif

                
                        <!-- Enlace a la página siguiente --> 
                        @if ($autores->hasMorePages())
                            <li class="page-item">
                                {{-- <a href="{{ $autores->nextPageUrl() }}" class="page-link page-next">Siguiente</a> --}}
                                <a href="{{ $autores->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $autores->appends(['busqueda' => $busqueda])->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $autores->url($autores->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $autores->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $autores->currentPage() ? 'selected' : '' }}>
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

<!-- Edit Modal HTML -->
@foreach ($autores as $autor )
<div id="edit-{{$autor -> aut_id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/bibliotecario/libros/autores/modificar') }}" method="post">
            @csrf
            @method('PATCH')
                <div class="modal-header">						
                    <h4 class="modal-title">Editar autor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name = "aut_nombre" required value="{{ $autor -> aut_nombre }}">
                    </div>                        
                    <div class="form-group">
                        <input type="text" class="form-control" name = "aut_id" value="{{ $autor -> aut_id }}" hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Guardar">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


<!-- Delete Modal HTML -->
@foreach ($autores as $autor)
<div id="delete-{{$autor -> aut_id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/bibliotecario/libros/autores/delete/'.$autor -> aut_id) }}" method = "post">
                @csrf
                {{ method_field ('DELETE') }}
                <div class="modal-header">						
                    <h4 class="modal-title">Eliminar autor</h4>
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


<!-- Add Modal HTML -->
<div id="add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{ route('/bibliotecario/libros/autores.store') }}" method="POST">
            @csrf
                <div class="modal-header">						
                    <h4 class="modal-title">Agregar autor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name = "aut_nombre" required>
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


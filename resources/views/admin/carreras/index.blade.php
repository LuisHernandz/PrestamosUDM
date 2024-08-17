@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Carreras')

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
                            <h2>
                                @if($nivel_id == 1)
                                    Bachillerato
                                @elseif($nivel_id == 2)
                                    Licenciaturas
                                @elseif($nivel_id == 3)
                                    Especialidades
                                @elseif($nivel_id == 4)
                                    Maestrías
                                @else
                                    Doctorados
                                @endif
                            </h2>
                        </div>
                        <div class="" style="width: 50%;">
                            <a href="#add" class="btn btn-add" data-toggle="modal">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Agregar Nuevo</span>
                            </a>
                            
                            <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						 -->
                        </div>
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
                        @foreach ($carreraNiveles as $carreraNivel )
                        <tr>
                            <td>{{$carreraNivel -> car_nombre}}</td>
                            
                            <td>
                                <a href="#edit-{{$carreraNivel -> car_id}}" class="edit" data-toggle="modal">
                                    <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                </a>
                                <a href="#delete-{{$carreraNivel -> car_id}}" class="delete" data-toggle="modal">
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
                        Mostrando registros del <b>{{ $carreraNiveles->firstItem() }}</b> al <b>{{ $carreraNiveles->lastItem() }}</b> de un total de <b>{{ $carreraNiveles->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($carreraNiveles->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$carreraNiveles->onFirstPage() ? $carreraNiveles->appends([])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($carreraNiveles->currentPage() - 2, 1);
                            $endPage = min($carreraNiveles->currentPage() + 2, $carreraNiveles->lastPage());
                        @endphp

                        @if ($carreraNiveles->lastPage() <= 5)
                            @foreach ($carreraNiveles->getUrlRange(1, $carreraNiveles->lastPage()) as $page => $url) 
                                <li class="page-item {{ $page == $carreraNiveles->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $carreraNiveles->appends([])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $carreraNiveles->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $carreraNiveles->appends([])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor 
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($carreraNiveles->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $carreraNiveles->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $carreraNiveles->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $carreraNiveles->url($carreraNiveles->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $carreraNiveles->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $carreraNiveles->currentPage() ? 'selected' : '' }}>
                                            Página {{ $page }}
                                        </option>
                                    @endfor
                                </select>
                                
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
@foreach ($carreraNiveles as $carreraNivel )
    <div id="edit-{{$carreraNivel -> car_id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('admin/carreras/modificar') }}" method="post">
                @csrf
                @method('PATCH')
                    <div class="modal-header">						
                        <h4 class="modal-title">Editar carrera</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name = "car_nombre" required value="{{ $carreraNivel -> car_nombre }}">
                        </div>                        
                        <div class="form-group">
                            <input type="text" class="form-control" name = "car_id" value="{{ $carreraNivel -> car_id }}" hidden>
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
@foreach ($carreraNiveles as $carreraNivel)
    <div id="delete-{{$carreraNivel -> car_id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content"> 
                <form action="{{ url('admin/carreras/eliminar/'.$carreraNivel -> car_id) }}" method = "post">
                    @csrf
                    {{ method_field ('DELETE') }}
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar carrera</h4>
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
        <form action="{{ route('admin/carreras.store') }}" method="POST">
            @csrf
                <div class="modal-header">						
                    <h4 class="modal-title">Agregar carrera</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name = "car_nombre" required>

                        @error('car_nombre')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="niv_id" value = "{{ $nivel_id }}" hidden>
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


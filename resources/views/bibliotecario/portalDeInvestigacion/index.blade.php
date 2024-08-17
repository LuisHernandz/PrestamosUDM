@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Enlaces de investigación')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">

<style>
    .validate-message{
        color: red;
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

    @error('pdi_imagen')
        <p class="validate-message">{{ $message }}</p>
    @enderror

        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="" style="width: 50%;"> 
                            <h2>Enlaces De Investigación</h2>
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
                            <!-- <th>ID</th> -->
                            <th>Nombre</th>
                            <th>Enlace</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paginas as $pagina )
                        <tr>


                            <td>
                                {{ Str::limit($pagina -> pdi_nombre, 30) }}
                            </td>
                            <td> 
                                {{ Str::limit($pagina -> pdi_enlace, 45) }}
                            </td>
                            
                            <td>
                                <a href="#show-{{$pagina -> id}}" class="show" data-toggle="modal" title="Ver más información">
                                    <i class="fa-solid fa-ellipsis"></i> 
                                </a>
                                <a href="#edit-{{$pagina -> id}}" class="edit" data-toggle="modal">
                                    <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>

                                </a>
                                <a href="#delete-{{$pagina -> id}}" class="delete" data-toggle="modal">
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
                        Mostrando registros del <b>{{ $paginas->firstItem() }}</b> al <b>{{ $paginas->lastItem() }}</b> de un total de <b>{{ $paginas->total() }}</b>
                    </div>
                    <ul class="pagination">
                        <!-- Enlace a la página anterior -->
                        @if ($paginas->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link page-next" href="#">Anterior</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-next" href="{{ !$paginas->onFirstPage() ? $paginas->appends([])->previousPageUrl() : '#' }}">Anterior</a>
                            </li>
                        @endif
                                        
                        <!-- Enlaces a las páginas individuales (máximo 5) -->
                        @php
                            $startPage = max($paginas->currentPage() - 2, 1);
                            $endPage = min($paginas->currentPage() + 2, $paginas->lastPage());
                        @endphp

                        @if ($paginas->lastPage() <= 5)
                            @foreach ($paginas->getUrlRange(1, $paginas->lastPage()) as $page => $url) 
                                <li class="page-item {{ $page == $paginas->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $paginas->appends([])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Enlaces a las páginas intermedias (máximo 5) -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $page == $paginas->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $paginas->appends([])->url($page) }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endfor 
                        @endif

                
                        <!-- Enlace a la página siguiente -->
                        @if ($paginas->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $paginas->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li> 
                        @else
                            <li class="page-item disabled">
                                <a href="{{ $paginas->nextPageUrl() }}" class="page-link page-next">Siguiente</a>
                            </li>
                        @endif

                                        
                        <!-- Select para dirigir a cada página -->
                        <li class="page-item">
                            <form action="{{ $paginas->url($paginas->currentPage()) }}" method="get" class="page-link" style="border: none;">
                                <select name="page" class="form-control" style="font-size: 0.8rem; height: auto;">
                                    @for ($page = 1; $page <= $paginas->lastPage(); $page++)
                                        <option value="{{ $page }}" {{ $page == $paginas->currentPage() ? 'selected' : '' }}>
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

    <!-- Show Modal HTML -->
    @foreach ($paginas as $pagina)
        <div id="show-{{$pagina -> id}}" class="modal fade">
            <div class="modal-dialog"  style="max-width: 500px;">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">						
                            <h4 class="modal-title">Datos de la página:</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                            <div class = "">
                                <p><span>Nombre: </span>
                                    {{ $pagina -> pdi_nombre }}
                                </p>
                            </div>

                            <div class = "">
                                <p><span>Descripción:</span> {{$pagina -> pdi_descripcion}}</p>
                            </div>

                            <div class = "">
                                <p style="text-align:initial;"><span>Enlace:</span> {{$pagina -> pdi_enlace}}</p>
                            </div>

                            @if (empty($pagina -> pdi_imagen))
                                <i>Sin Imagen</i>
                            @else
                            
                            <div class = "">
                                <p><span>Foto:</span></p> 
                                <div class="media justify-content-center mt-4">
                                    <span class="" style="width: 150px; height: 100%;">
                                        <img class="img-fluid" src="{{ asset('storage').'/'.$pagina -> pdi_imagen }}" alt="...">                                               
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

    <!-- Edit Modal HTML -->
    @foreach ($paginas as $pagina )
        <div id="edit-{{$pagina -> id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ url('/bibliotecario/portal-de-investigacion/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <div class="modal-header">						
                            <h4 class="modal-title">Editar pagina</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">					
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" name = "pdi_nombre" required value="{{ $pagina -> pdi_nombre }}">
                            </div>
                            <div class="form-group">
                                <label>Enlace</label>
                                <input type="text" class="form-control" name = "pdi_enlace" required value="{{ $pagina -> pdi_enlace }}">
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" class="form-control" name = "pdi_descripcion" value="{{ $pagina -> pdi_descripcion }}">
                            </div>
                            <div class="form-group">
                                <label>Imagen</label>
                                <input type="file" class="form-control" name = "pdi_imagen" id="file-input-update-{{ $pagina -> id }}" accept="image/*"><br>
                                <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                    <div class="media">
                                        <span class="rounded-circle" style="margin: 0 auto; width: 150px; height: 150px;">
                                            <img src="{{ asset('storage').'/'.$pagina -> pdi_imagen }}" alt="" id="selected-image-update-{{ $pagina -> id }}" width="auto" height="100%" >                                                    
                                        </span>
                                    </div>    
                                </div>  
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name = "id" value="{{ $pagina -> id }}" hidden>
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
     @foreach ($paginas as $pagina)
        <div id="delete-{{$pagina -> id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ url('/bibliotecario/portal-de-investigacion/destroy/'.$pagina -> id) }}" method = "post">
                        @csrf
                        {{ method_field ('DELETE') }}
                        <div class="modal-header">						
                            <h4 class="modal-title">Eliminar pagina</h4>
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
            <form action="{{ url('/bibliotecario/portal-de-investigacion/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">						
                        <h4 class="modal-title">Agregar página</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name = "pdi_nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Enlace</label>
                            <input type="text" class="form-control" name = "pdi_enlace" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" name = "pdi_descripcion">
                        </div>
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name = "pdi_imagen" required id="file-input-register" accept="image/*">

                            <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                <div class="media">
                                    <span class="rounded-circle" style="margin: 0 auto; width: 150px; height: 150px;">
                                        <img src="" alt="" id="selected-image-register" width="auto" height="100%" >                                                    
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

        handleImagePreview('file-input-register', 'selected-image-register');

        @foreach($paginas as $pagina)
            handleImagePreview('file-input-update-{{ $pagina -> id }}', 'selected-image-update-{{ $pagina -> id }}');
        @endforeach

    </script>

 
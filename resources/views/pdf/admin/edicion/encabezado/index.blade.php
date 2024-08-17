@extends('layouts.nav-admin')
@section('titulo', 'UDM - PDF (Encabezado)')


<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">

<style> 

    .table-pdf{
        width: 80%;
        height: 100px;
        border: 1px solid rgb(212, 212, 212);
        margin: 10px 0;
    }

    .table-pdf thead{
        height: 100px;
    }
    
    .table-pdf thead tr{
        width: 100%;
    }
    
    .element-image{
        height: 100%;
        text-align: center
    }

    .element-image img{
        width: 200px;
        height: auto;
        max-height: 100%;
        object-fit: contain;
    }

    .element-text{
        padding: 0 10px;
    }

    .element-text p{
        width: 100%;
        display: block;
        text-align: center;
        font-size: 0.75rem;
        font-weight: 400;
        line-height: 1rem;
    }

    .message-error-validation{
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

    @error('contenidoImagen')
        <p class="message-error-validation">{{ $message }}</p>
    @enderror

        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="" style="width: 50%;">
                            <h2>PDF - Encabezado</h2>
                        </div>
                        <div class="" style="width: 50%;">
                            <a href="#add" class="btn btn-add" data-toggle="modal">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Agregar Elemento</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Diseño de encabezado actual:</p>

                    <table class="table-pdf">
                        <thead>
                            <tr>
                                @if ($elementosPDF->count() > 0)
                                    @foreach ($elementosPDF as $elementoPDF)
                                        @if (is_null($elementoPDF -> contenidoImagen))
                                            <th class="element-pdf element-text">
                                                @if ($elementoPDF->contenidoTexto)
                                                    @php
                                                        $contenidoArray = json_decode($elementoPDF->contenidoTexto);
                                                    @endphp

                                                    @if (is_array($contenidoArray))
                                                        @foreach ($contenidoArray as $parrafo)
                                                            <p>{{ $parrafo }}</p>
                                                        @endforeach
                                                    @else
                                                        No se pudo decodificar el contenido.
                                                    @endif
                                                @else
                                                    No hay contenido de texto disponible.
                                                @endif
                                                   
                                            </th>
                                        @else
                                            <th class="element-pdf element-image">
                                                <img src="{{ asset('storage/' . $elementoPDF->contenidoImagen) }}">        
                                            </th>
                                        @endif
                                    @endforeach
                                @else
                                    <th>
                                        <p class="msg-sinregistros">Aún no se asignado ningún elemento.</p>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Número de orden</th>
                            <th>Tipo</th>
                            <th>Contenido</th>
                            <th>Acciones</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                        ?>

                        @foreach ($elementosPDF as $elementoPDF )
                        <tr>


                            <td>
                                <?php
                                    $acumulador = $i;
                                    echo $acumulador;
                                    ++$i;
                                ?>
                            </td>
                            <td>{{$elementoPDF -> tipo}}</td>
                            
                            <td>
                                @if (is_null($elementoPDF -> contenidoImagen))
                                    @php
                                        $contenidoArray = json_decode($elementoPDF->contenidoTexto);
                                    @endphp
                                
                                    @if (is_array($contenidoArray)) 
                                        @foreach ($contenidoArray as $parrafo)
                                            <p>{{ $parrafo }}</p>
                                        @endforeach
                                    @else
                                        No se pudo decodificar el contenido.
                                    @endif

                                @else

                                        <span class="avatar avatar-sm" style="width: 60px; height: 60px; border-radius: 0; background-color: transparent;">
                                            <img src="{{ asset('storage').'/'.$elementoPDF -> contenidoImagen }}" style="object-fit: contain;
                                            border-radius: 0;">  
                                        </span>
                                        
                                @endif
                            </td>

                            <td>
                                {{-- <a href="" class="edit">
                                    <i class="fa-solid fa-pen-to-square"  data-toggle="tooltip" title="Editar"></i>
                                </a> --}}
                                <a href="#deleteElemento-{{$elementoPDF -> id}}" class="delete" data-toggle="modal">
                                    <i class="fa-solid fa-trash" data-toggle="tooltip" title="Eliminar"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>         
    </div>

    <script>
        $(document).ready(function() {
        var itemCount = $('.element-pdf').length;
        var widthPercentage = 100 / itemCount;
        
        $('.element-pdf').css('width', 'calc(' + widthPercentage + '% )'); // Restamos 2px para tener en cuenta los bordes
    });

    </script>
@endsection

    

     <!-- Delete Modal HTML -->
     @foreach ($elementosPDF as $elementoPDF )
        <div id="deleteElemento-{{$elementoPDF -> id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ url('admin/edicion-pdf/encabezado/eliminar/'.$elementoPDF -> id) }}" method = "post">
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
            <form action="{{ route('admin/edicion-pdf/encabezado.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">						
                        <h4 class="modal-title">Agregar página</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h5>¿Que tipo de elemento deseas agregar?</h5>
        
                        <div class="">
                            <input type="radio" name="opcion" value="si" onclick="mostrarContenido(event)">
                            <label class="">Texto</label>

                            <input type="radio" name="opcion" value="no" onclick="mostrarContenido(event)">
                            <label class="">Imagen</label>
                        </div>
                    
		
                        <div class="form-group contenido contenidoSi" style="display: none;">
                            <p>
                                El texto que asignes se dividirá en párrafos, puedes asignarle al texto un máximo de tres párrafos.
                            </p><br>

                            <label>Párrafo 1:</label> 
                            <input type="text" class="form-control" name = "contenidoTexto[]">

                            <label>Párrafo 2:</label> 
                            <input type="text" class="form-control" name = "contenidoTexto[]">

                            <label>Párrafo 3:</label> 
                            <input type="text" class="form-control" name = "contenidoTexto[]">
                        </div>
                        <div class="form-group contenido contenidoNo" style="display: none;">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name = "contenidoImagen" id="file-input" accept="image/.png, .jpg, .jpeg">
                            <div style="display:flex; align-items:center; justify-content:center; width:100%; height: 186px; overflow:hidden">   
                                <div class="media">
                                    <span class="rounded-circle" style="margin: 0 auto; width: 100%; height: 150px;">
                                        <img src="" alt="" id="selected-image" width="auto" height="100%" >                                                  
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
        function mostrarContenido(event) {
        var modalContainer = event.target.closest(".modal-body");
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

        document.getElementById('file-input-update').addEventListener('change', function() {
            const selectedImage = document.getElementById('selected-image-update');
            const fileInput = document.getElementById('file-input-update');
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
<!-- JQUERY -->
<script src="{{url('/assets/js/jquery.js')}}"></script>    
   
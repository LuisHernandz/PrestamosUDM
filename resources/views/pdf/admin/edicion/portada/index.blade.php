@extends('layouts.nav-admin')
@section('titulo', 'UDM - PDF (Imagen de Portada)')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">

<style> 


    .table-pdf{
        width: 40%;
        height: 200px;
        border: 1px solid rgb(212, 212, 212); 
        margin: 0 auto;

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
                            <h2>PDF - Portada</h2> 
                        </div>
                        <div class="" style="width: 50%;">
                            <a href="#add" class="btn btn-add" data-toggle="modal">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span>Nueva Imagen</span>
                            </a>
                        </div>
                    </div> 
                </div>
                <div>
                    <p>Imagen de portada actual:</p>

                    <table class="table-pdf">
                        <thead style="height: 100%;">
                            <tr>
                                @if (isset($elementoPDF))
                                    <th class="element-pdf element-image">
                                        <img src="{{ asset('storage/' . $elementoPDF->contenidoImagen) }}">        
                                    </th>
                                @else
                                    <th>
                                        <p class="msg-sinregistros">Aún no se asignado ninguna imagen de portada.</p>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>         
    </div>

@endsection

    <!-- Add Modal HTML -->

    <div id="add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ route('admin/edicion-pdf/portada.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">		  				
                        <h4 class="modal-title">Nueva imagen</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Imagen</label>
                            <input type="file" class="form-control" name = "contenidoImagen" required id="file-input-register" accept="image/*">

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

        @if(isset($elementoPDF))
            handleImagePreview('file-input-update-{{ $elementoPDF->id }}', 'selected-image-update-{{ $elementoPDF->id }}');
                    
        @endif

            


    </script>

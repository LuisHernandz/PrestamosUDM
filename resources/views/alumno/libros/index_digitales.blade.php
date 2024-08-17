@extends('layouts.nav-student')
@section('titulo', 'UDM - Libros Digitales')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/modal_libro.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/carrusel.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">  

@section('main')
    @if (session('success')) 
        <div class="msg-registro" id="myDiv" style="margin-bottom: 1rem;">
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


    <div class="peliculas-recomendadas contenedor">
        <div class="contenedor-titulo-controles">
            <p class="numLibros">Titulos Localizados:  <span id="numeroLibros">{{ count($libros) }}</span> </p>
    
        </div>

		<div class="contenedor-principal" >
			<button role="button" id="flecha-izquierda" class="flecha-izquierda"><i class="fas fa-angle-left"></i></button>

			<div class="contenedor-carousel">
				<div class="carousel" id="carousel">   
                    @foreach ($libros as $libro)
                        <a href="#showPdf-{{ $libro->lib_id }}" data-toggle="modal" title="Ver más información" class="pelicula show" id="libro">
                            <div class="img-container">
                                <img src="{{url('/assets/images/logo-pdf.png')}}">
                            </div>

                            <div>
                                <p class="book-title">{{ $libro->lib_titulo }}</p>
                                <p class="book-author">{{ $libro->aut_nombre }}</p> 
                            </div> 
                        </a>
                    @endforeach
				</div>
			</div>

			<button role="button" id="flecha-derecha" class="flecha-derecha"><i class="fas fa-angle-right"></i></button>
		</div>

        <div class="indicadores">
            
        </div>
    </div>

<script src="{{url('/assets/js/carrusel.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

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
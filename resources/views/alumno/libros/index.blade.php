@extends('layouts.nav-student')
@section('titulo', 'UDM - Libros Fisicos')

<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/modal_libro.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/carrusel.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">  

@section('main')
    @if (session('success'))
        <div class="msg-registro" id="myDiv" style="margin-bottom: 1rem">
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

    <div class="container-filter">
        <div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="option">Nivel:</label>
                    <div class="container-input form-control"  style="height: 30.4px;">
                        <select name="option" id="firstSelect">
                            <option value="" hidden selected>Seleccionar</option>
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel -> niv_id }}">{{ $nivel -> niv_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
            </div> 

            <div class="col-md-4">
                <div class="form-group">
                    <label for="firstSelect">Carrera:</label>
                    <div class="container-input form-control"  style="height: 30.4px;">
                        <select id="secondSelect">
              
                        </select>
                    </div>
                </div>  
            </div> 

            <div class="col-md-4">
                <div class="form-group">
                    <label for="firstSelect">Búsqueda:</label>
                    <div class="container-input form-control barra-busqueda"  style="height: 30.4px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" placeholder="Buscar por título o autor.">
                    </div>
                </div>  
            </div> 

            
        </div>
        
    </div>

    <div class="peliculas-recomendadas contenedor">
        <div class="contenedor-titulo-controles">
            <p class="numLibros">Titulos Localizados:  <span id="numeroLibros"></span> </p>
    
        </div>

		<div class="contenedor-principal" >
			<button role="button" id="flecha-izquierda" class="flecha-izquierda"><i class="fas fa-angle-left"></i></button>

			<div class="contenedor-carousel">
				<div class="carousel" id="carousel">   
                        
				</div>
			</div>

			<button role="button" id="flecha-derecha" class="flecha-derecha"><i class="fas fa-angle-right"></i></button>
		</div>

        <div class="indicadores">
            
        </div>
    </div>

    <script>
        let carrera_id = {!! json_encode($carrera_id) !!};
        let usuario_id = "{{ session('usuario_id') }}"; 

        $(document).ready(function() {
            $.ajax({
                url: '{{ route("/obtener-librosAlumno") }}',   
                method: 'GET',
                data: {
                    carrera_id: carrera_id
                },
                success: function(response) {

                // Vaciar contenido de los siguientes elementos: 
                $('#carousel').html(''); 
                $('#carreraNombre').text('');
                $('#numeroLibros').text('');

                // Obtener el número de datos dentro del arreglo "response[0]"
                let numeroLibros = response[0].length;

                // Asignar al elemento el contenido de la variable numeroLibros
                $('#numeroLibros').text(numeroLibros);

                //Iterar sobre los datos devueltos dentro de la primera variable del arreglo (los libros)
                response[0].forEach(function(registro) {

                    // Por cada dato o registro (libro) ...

                    // Crear nuevo elemento y almacenarlo dentro de la variable divLibro
                    let divLibro = $('<a href="" data-toggle="modal" title="Ver más información" class="pelicula show" id="libro"></a>');

                    // Agregar los datos, excepto los dos últimos, al div del libro, se agrega solo la Imagen
                    for (let i = 0; i < registro.length - 4; i++) {
                        divLibro.append(registro[i]);
                    }

                    // Para los dos ultimos datos...

                    // Crear un nuevo elemento div
                    let divAdicional = $('<div></div>'); 

                    // Crear div para ejemplares
                    let divEjemplares = $('<div class="container-book_ejemplares"></div>');
                    
                    // Agregar datos 2 y 3 a ese div
                    divEjemplares.append(registro[registro.length - 3]);  
                    divEjemplares.append(registro[registro.length - 4]);  

                    // Agregar el penúltimo dato al div adicional (titulo)
                    divAdicional.append(registro[registro.length - 2]); 

                    // Agregar el último dato al div adicional (nombre)
                    divAdicional.append(registro[registro.length - 1]); 

                    // Agregar el div adicional dentro del div del libro
                    divLibro.append(divAdicional); 
                    divLibro.append(divEjemplares); 

                    // Agregar el div del libro al div "libros", es decir, al contenedor.
                    $('#carousel').append(divLibro); 

                    // Llamar a la función para establecer la paginación después de haber agregado los elementos
                    establecerPaginacion();
                });

                // Almacenar el segundo elemento o dato (carrera seleccionada) y agregar al elemento con la id correspondiente.
                let carrera = response[1];
                $('#carreraNombre').text(carrera);

                //Iterar sobre los datos devueltos dentro del tercer dato del arreglo (los libros)
                response[2].forEach(function(registro) {
                    
                    // Obtener y almacenar el dato (id) de cada registro
                    let identificador = registro; 

                    // Crear nueva variable y asignarle el contenido...
                    let href = '#show-' + identificador; 

                    // Seleccionar el elemento <a> y asignarle el href, y dentro de ella su respectivo valor
                    let elementoA = $('#carousel a').eq(response[2].indexOf(registro));
                    elementoA.attr('href', href);
                    elementoA.data('id', identificador); // Almacena el identificador como un atributo de datos 'id'


                    elementoA.on('click', function(event) {
                        event.preventDefault();
                        let id = $(this).data('id'); // Obtiene el identificador almacenado como atributo de datos 'id'

                        let libros = {!! json_encode($libros) !!};

                        // Recorrer cada elemento en la variable libros
                        libros.forEach(function(libro) {
                            if (libro.lib_id == id) {
                                // Asignar datos a los elementos correspondientes...
                                $('#lib_titulo').text(libro.lib_titulo); 
                                $('#lib_descripcion').text(libro.lib_descripcion); 
                                $('#lib_autor').text(libro.aut_nombre); 
                                $('#lib_ejemplares').text(libro.lib_ejemplares); 
                                $('#lib_eDisponibles').text(libro.lib_eDisponibles); 
                                $('#lib_editorial').text(libro.edi_nombre); 

                                // Asignar datos a los atributos value de los elementos inputs correspondientes... 
                                $('#input_lib_id').val(libro.lib_id);
                                $('#input_alu_id').val(usuario_id);

                                // Obtener el valor de libro.lib.foto
                                let lib_foto =  "{{ asset('storage') }}" + '/' + libro.lib_foto;

                                $('#lib_foto').attr('src', lib_foto);
                            }
                        });

                        // Abrir la ventana modal y mostrar el ID
                        $('#myModal').modal('show');
                        $('#myModal').data('id', id); // Almacena el identificador como un atributo de datos 'id' en el modal
                        
                    });

                });
                }
 
            });
        });
        
    </script>
    
    <script>
        
        $(document).ready(function() {
            $('#firstSelect').change(function() {
    
                var opcionSeleccionada = $(this).val();

                // Realiza la solicitud AJAX al controlador
                $.ajax({
                    url: '{{ route("/obtener-opciones") }}',   
                    type: 'GET',
                    data: {
                        opcionSeleccionada: opcionSeleccionada
                    },
                    success: function(response) {
                        $('#carousel').html(''); // Vaciar contenido previo del div "libros"
                        $('#carreraNombre').text('');
                        $('#numeroLibros').text('');

                        // Actualiza las opciones del segundo select
                        var secondSelect = $('#secondSelect');
                        secondSelect.empty(); // Vaciar contenido previo del elemento select

                        // Agregar un option vacío al principio
                        secondSelect.append('<option value="" hidden>Selecciona una opción.</option>');

                        // Agregar los registros como options
                        secondSelect.append(response);
                    } 
                });
            });
        });

    </script>

    <script>
            $(document).ready(function() { // Asegurarse de que el código se ejecute cuando el documento HTML ha sido completamente cargado. 
            $('#secondSelect').change(function() { // Ejecutar cuando ocurra un cambio en el elemento.
                let opcionSeleccionada = $(this).val(); // Obtener valor del elemento seleccionado.

                // Realizar la solicitud AJAX al controlador
                $.ajax({
                    url: '{{ route("/obtener-libros") }}',   
                    type: 'GET',
                    data: {
                        opcionSeleccionada: opcionSeleccionada // Datos que se enviarán 
                    },

                    // Ejecutar cuando la solicitud AJAX se haya completado exitosamente. El parámetro response contiene los datos devueltos por el servidor.
                    success: function(response) {

                        // Vaciar contenido de los siguientes elementos: 
                        $('#carousel').html(''); 
                        $('#carreraNombre').text('');
                        $('#numeroLibros').text('');

                        // Obtener el número de datos dentro del arreglo "response[0]"
                        let numeroLibros = response[0].length;

                        // Asignar al elemento el contenido de la variable numeroLibros
                        $('#numeroLibros').text(numeroLibros);
 
                        //Iterar sobre los datos devueltos dentro de la primera variable del arreglo (los libros)
                        response[0].forEach(function(registro) {

                            // Por cada dato o registro (libro) ...

                            // Crear nuevo elemento y almacenarlo dentro de la variable divLibro
                            let divLibro = $('<a href="" data-toggle="modal" title="Ver más información" class="pelicula show" id="libro"></a>');

                            // Agregar los datos, excepto los dos últimos, al div del libro, se agrega solo la Imagen
                            for (let i = 0; i < registro.length - 4; i++) {
                                divLibro.append(registro[i]);
                            }

                            // Para los dos ultimos datos...

                            // Crear un nuevo elemento div
                            let divAdicional = $('<div></div>'); 

                            // Crear div para ejemplares
                            let divEjemplares = $('<div class="container-book_ejemplares"></div>');

                            // Agregar datos 2 y 3 a ese div
                            divEjemplares.append(registro[registro.length - 3]);  
                            divEjemplares.append(registro[registro.length - 4]);  

                            // Agregar el penúltimo dato al div adicional (titulo)
                            divAdicional.append(registro[registro.length - 2]); 

                            // Agregar el último dato al div adicional (nombre)
                            divAdicional.append(registro[registro.length - 1]); 

                            // Agregar el div adicional dentro del div del libro
                            divLibro.append(divAdicional); 
                            divLibro.append(divEjemplares); 

                            // Agregar el div del libro al div "libros", es decir, al contenedor.
                            $('#carousel').append(divLibro); 

                            // Llamar a la función para establecer la paginación después de haber agregado los elementos
                            establecerPaginacion();
                        });

                        // Almacenar el segundo elemento o dato (carrera seleccionada) y agregar al elemento con la id correspondiente.
                        let carrera = response[1];
                        $('#carreraNombre').text(carrera);

                        //Iterar sobre los datos devueltos dentro del tercer dato del arreglo (los libros)
                        response[2].forEach(function(registro) {
                            
                            // Obtener y almacenar el dato (id) de cada registro
                            let identificador = registro; 

                            // Crear nueva variable y asignarle el contenido...
                            let href = '#show-' + identificador; 

                            // Seleccionar el elemento <a> y asignarle el href, y dentro de ella su respectivo valor
                            let elementoA = $('#carousel a').eq(response[2].indexOf(registro));
                            elementoA.attr('href', href);
                            elementoA.data('id', identificador); // Almacena el identificador como un atributo de datos 'id'


                            elementoA.on('click', function(event) {
                                event.preventDefault();
                                let id = $(this).data('id'); // Obtiene el identificador almacenado como atributo de datos 'id'

                                let libros = {!! json_encode($libros) !!};

                                // Recorrer cada elemento en la variable libros
                                libros.forEach(function(libro) {
                                    if (libro.lib_id == id) {
                                        // Asignar datos a los elementos correspondientes...
                                        $('#lib_titulo').text(libro.lib_titulo); 
                                        $('#lib_descripcion').text(libro.lib_descripcion); 
                                        $('#lib_autor').text(libro.aut_nombre); 
                                        $('#lib_ejemplares').text(libro.lib_ejemplares); 
                                        $('#lib_eDisponibles').text(libro.lib_eDisponibles); 
                                        $('#lib_editorial').text(libro.edi_nombre); 

                                        // Asignar datos a los atributos value de los elementos inputs correspondientes... 
                                        $('#input_lib_id').val(libro.lib_id);
                                        $('#input_alu_id').val(usuario_id);


                                        // Obtener el valor de libro.lib.foto
                                        let lib_foto =  "{{ asset('storage') }}" + '/' + libro.lib_foto;

                                        $('#lib_foto').attr('src', lib_foto);
                                    }
                                });

                                // Abrir la ventana modal y mostrar el ID
                                $('#myModal').modal('show');
                                $('#myModal').data('id', id); // Almacena el identificador como un atributo de datos 'id' en el modal
                                
                            });
             
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Función para realizar la petición Ajax
        function searchBooks(query) {
            $.ajax({
   
            url: '{{ route("/buscarLibros") }}', 
            method: 'GET',
            data: {
                query: query // El valor del input que se enviará en la petición
            },
            success: function(response) {

                // Vaciar contenido de los siguientes elementos: 
                $('#carousel').html(''); 
                $('#numeroLibros').text('');

                // Obtener el número de datos dentro del arreglo "response[0]"
                let numeroLibros = response[0].length;

                // Asignar al elemento el contenido de la variable numeroLibros
                $('#numeroLibros').text(numeroLibros);

                //Iterar sobre los datos devueltos dentro de la primera variable del arreglo (los libros)
                response[0].forEach(function(registro) {

                    // Por cada dato o registro (libro) ...

                    // Crear nuevo elemento y almacenarlo dentro de la variable divLibro
                    let divLibro = $('<a href="" data-toggle="modal" title="Ver más información" class="pelicula show" id="libro"></a>');

                    // Agregar los datos, excepto los dos últimos, al div del libro, se agrega solo la Imagen
                    for (let i = 0; i < registro.length - 4; i++) {
                        divLibro.append(registro[i]);
                    }

                    // Para los dos ultimos datos...

                    // Crear un nuevo elemento div
                    let divAdicional = $('<div></div>'); 

                    // Crear div para ejemplares
                    let divEjemplares = $('<div class="container-book_ejemplares"></div>');

                    // Agregar datos 2 y 3 a ese div
                    divEjemplares.append(registro[registro.length - 3]);  
                    divEjemplares.append(registro[registro.length - 4]);  

                    // Agregar el penúltimo dato al div adicional (titulo)
                    divAdicional.append(registro[registro.length - 2]); 

                    // Agregar el último dato al div adicional (nombre)
                    divAdicional.append(registro[registro.length - 1]); 

                    // Agregar el div adicional dentro del div del libro
                    divLibro.append(divAdicional); 
                    divLibro.append(divEjemplares); 

                    // Agregar el div del libro al div "libros", es decir, al contenedor.
                    $('#carousel').append(divLibro); 

                    // Llamar a la función para establecer la paginación después de haber agregado los elementos
                    establecerPaginacion();
                });

                console.log(response[1]);


                //Iterar sobre los datos devueltos dentro del segundo dato del arreglo (los libros)
                response[1].forEach(function(registro) {
                    
                    // Obtener y almacenar el dato (id) de cada registro
                    let identificador = registro; 

                    // Crear nueva variable y asignarle el contenido...
                    let href = '#show-' + identificador; 

                    // Seleccionar el elemento <a> y asignarle el href, y dentro de ella su respectivo valor
                    let elementoA = $('#carousel a').eq(response[1].indexOf(registro));
                    elementoA.attr('href', href);
                    elementoA.data('id', identificador); // Almacena el identificador como un atributo de datos 'id'


                    elementoA.on('click', function(event) {
                        event.preventDefault();
                        let id = $(this).data('id'); // Obtiene el identificador almacenado como atributo de datos 'id'

                        let libros = {!! json_encode($libros) !!};

                        // Recorrer cada elemento en la variable libros
                        libros.forEach(function(libro) {
                            if (libro.lib_id == id) {
                                // Asignar datos a los elementos correspondientes...
                                $('#lib_titulo').text(libro.lib_titulo); 
                                $('#lib_descripcion').text(libro.lib_descripcion); 
                                $('#lib_autor').text(libro.aut_nombre); 
                                $('#lib_ejemplares').text(libro.lib_ejemplares); 
                                $('#lib_eDisponibles').text(libro.lib_eDisponibles); 
                                $('#lib_editorial').text(libro.edi_nombre); 

                                // Asignar datos a los atributos value de los elementos inputs correspondientes... 
                                $('#input_lib_id').val(libro.lib_id);
                                $('#input_alu_id').val(usuario_id);

                                // Obtener el valor de libro.lib.foto
                                let lib_foto =  "{{ asset('storage') }}" + '/' + libro.lib_foto;

                                $('#lib_foto').attr('src', lib_foto);
                            }
                        });

                        // Abrir la ventana modal y mostrar el ID
                        $('#myModal').modal('show');
                        $('#myModal').data('id', id); // Almacena el identificador como un atributo de datos 'id' en el modal
                        
                    });

                });
                },
                error: function(xhr) {
                // Manejo de errores
                console.log(xhr.responseText);
            }
            });
        }

        // Función para manejar el evento keyup en el input
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
            var query = $(this).val(); // Obtener el valor actual del input
            searchBooks(query); // Llamar a la función de búsqueda con el valor del input
            });
        });
    </script>

    <script>
        $('#cerrarModal').on('click', function() {
            $('#myModal').modal('hide');
        });

    </script>

<script src="{{url('/assets/js/carrusel.js')}}"></script>
@endsection
  
 
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <!-- Contenido de la ventana modal -->
      <div class="modal-body">
        <div class="modal-body_header">
            <div class="image_container">
                <img src="" alt="" id="lib_foto">
            </div>
            <div class="text_container">
                <p class="lib_titulo" id="lib_titulo"></p>
                <p class="lib_descripcion" id="lib_descripcion"></p>
            </div>

            <div class="clear"></div>
            
        </div>
        
        <!-- <div id="modalContentContainer"></div> -->

        <div class="modal-body_main">
            <div>
                <label for="">Autor: </label>
                <p id="lib_autor"></p>
            </div>

            <div>
                <label for="">Editorial: </label>
                <p id="lib_editorial"></p>
            </div>

            <div>
                <label for="">Disponibles: </label>
                <p>
                    <span id="lib_eDisponibles"></span>
                    de
                    <span id="lib_ejemplares"></span> 
                </p>
            </div>
        </div>
            
      </div>
      <!-- Pie de la ventana modal -->
      <form action="{{ route('/bibliotecario/solicitudes/registro.store') }}" method="POST">
        @csrf
        <input type="text" name="lib_id" id="input_lib_id" hidden>
        <input type="text" name="alu_id" id="input_alu_id" hidden>

        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
            <!-- <button type="button" class="btn btn-primary">Solicitar préstamo</button> -->
            <!-- <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar"> -->
            <button id="cerrarModal" type="button" class="btn btn-default">Cerrar</button>
            <input type="submit" class="btn btn-success" value="Solicitar préstamo">
        </div>
      </form>
    </div>
  </div>
</div> 

<!-- JQUERY -->
<script src="{{url('/assets/js/jquery.js')}}"></script>  
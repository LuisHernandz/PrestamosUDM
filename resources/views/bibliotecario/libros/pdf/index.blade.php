
@extends('layouts.nav-librarian')
@section('title', 'UDM - Generar Reporte De Libros')

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')
<div class="container-form" style="max-width: 400px">
    <form action="{{ route('/bibliotecario/libros/inventario/pdf/filtro.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-title">
            <h2 style="font-size: 1rem;">Reporte De Libros</h2>
        </div>

        

        <div style="height: 340px; overflow: auto; padding: 0 15px 0 0;">
           
    
            <div class="form-group">
                <p>Selecciona el conjunto de libros que deseas generar.</p><br>
                <label>Por nivel</label>
                <div class="container-input form-control">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <select id="firstSelect" name="opcionNivel">            
                        <option value="" hidden selected>Seleccionar</option>
                        <option value="0">Todos</option>
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel -> niv_id }}">{{ $nivel -> niv_nombre }}</option>
                            @endforeach
                    </select> 
                </div>
    
                @error('niv_id')
                    <p class= "msg-error">{{$message}}</p>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Tambien puedes especificar la carrera...</label>
                <div class="container-input form-control">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <select id="secondSelect" name="opcionCarrera">
    
                    </select>
                </div>
    
                @error('car_id')
                    <p class= "msg-error">{{$message}}</p>
                @enderror
            </div>
    
           <div>
    
            <p>ACTUALIZO</p><br>
    
            <div class="form-group">
                @php
                    $nombreAdministrador = ''; // Inicializa la variable vacía
                @endphp

                @foreach ($bibliotecarios as $usuario)
                    @if (auth()->user()->id == $usuario->usuarios_id)
                        @php
                            $nombreAdministrador = $usuario->bib_nombre . ' ' . $usuario->bib_apellidos; // Guarda el valor en la variable
                        @endphp
                    @endif
                @endforeach

                <label>Nombre:</label>
                <input type="text" class="form-control" value="{{ $nombreAdministrador }}" name="actualizo_nombre" required>
    
                @error('lib_titulo')
                    <p class= "msg-error">{{$message}}</p>  
                @enderror
            </div>
    
            <div class="form-group">
                <label>Cargo:</label>
                <input type="text" class="form-control" value="BIBLIOTECARIO" name="actualizo_cargo" required>
    
                @error('lib_titulo')
                    <p class= "msg-error">{{$message}}</p> 
                @enderror
            </div>
           </div>
    
           <div>
    
            <p>REVISO</p><br>
    
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" class="form-control" value="ING. César Augusto Cruz López" name="reviso_nombre" required>
    
                @error('lib_titulo')
                    <p class= "msg-error">{{$message}}</p>
                @enderror
            </div>
    
            <div class="form-group">
                <label>Cargo:</label>
                <input type="text" class="form-control" value="COORDINADOR PLANTEL PERIFERICO" name="reviso_cargo" required> 
    
                @error('lib_titulo')
                    <p class= "msg-error">{{$message}}</p>
                @enderror
            </div>
           </div>
        </div>

        

        <div class="container-buttons">
            <!-- <input type="submit" value="Registrar" class="btn-register"> -->
            <input type="submit" class="btn btn-success" value="Generar PDF">
            
            <a href="{{ route('/bibliotecario/libros/inventario.index') }}" class="btn-cancel">
                <input type="button" class="btn btn-default" value="Cancelar">
                <!-- <button>Cancelar</button> -->
            </a>
        </div>
    </form>


</div>

<script>
        
    $(document).ready(function() {
        $('#firstSelect').change(function() {

            var opcionSeleccionada = $(this).val();

            // Realiza la solicitud AJAX al controlador
            $.ajax({
                url: '/obtenerCarrerasPDF',
                type: 'GET',
                data: {
                    opcionSeleccionada: opcionSeleccionada
                },
                success: function(response) {
                    // Actualiza las opciones del segundo select
                    var secondSelect = $('#secondSelect');
                    secondSelect.empty(); // Vaciar contenido previo del elemento select

                    // Agregar un option vacío al principio
                    secondSelect.append('<option value="" hidden></option>');

                    // Agregar los registros como options
                    secondSelect.append(response);
                } 
            });
        });
    });

    console.log($('#secondSelect'));

</script>
@endsection


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        *{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        
        }
        main{
            padding-top: 80px; /* Asegura que el contenido del main no se oculte detrás del encabezado */
            padding-bottom: 50px;
            text-align: center
        } 

        header { 
            position: fixed;
            top: 0;
            width: 100%;
            height: 80px;
            text-align: center;
            font-size: 12px;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 80px;
            text-align: center;
            font-size: 10px;
        }

        .table-pdf{
            width: 100%;
            height: 80px;
            border-collapse: collapse;
            border: none;
        } 

        .element-image{
            height: 100%;
            text-align: center
        }

        .element-image img{
            width: auto;
            max-width: 200px;
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
    </style>
</head>
<body>

    
    <header>


        <table class="table-pdf">
            <thead>
                <tr>
                    @if ($elementosPDF->count() > 0)
                        @php 
                            $anchoPorElemento = 100 / $elementosPDF->count();
                        @endphp
        
                        @foreach ($elementosPDF as $elementoPDF)
                            @if (is_null($elementoPDF -> contenidoImagen))
                                <th class="element-pdf element-text" style="width: {{ $anchoPorElemento }}%;">
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
                                <th class="element-pdf element-image" style="width: {{ $anchoPorElemento }}%;">
                                    <img src="{{ asset('storage/' . $elementoPDF->contenidoImagen) }}">        
                                </th>
                            @endif
                        @endforeach
                    @else
                        
                    @endif
                </tr>
            </thead>
        </table>
    </header> 

    <main>
        <h1 style="color: #44546A; font-size: 1.5rem;">Inventario General</h1>
        <h2 style="color: #44546A; margin: 0; font-size: 1.2rem; text-decoration: underline;">
            @if (is_null($nombreNivel))
                
            @else
                <span style="display: block;">Libros de nivel: {{ $nombreNivel -> niv_nombre}}</span>
            @endif

            @if (is_null($nombreCarrera)) 
                
            @else
                <span style="display: block;">Carrera: {{ $nombreCarrera->car_nombre }}.</span>
            @endif
        </h2> <br> 

        @if (isset($imagenPortada))
            <div style="width: 400px; max-width: 400px; height: 400px;  max-height: 400px; margin:0 auto;">
                <img src="{{ asset('storage/' . $imagenPortada->contenidoImagen) }}" style="width: 100%; height: 100%; object-fit: cover;">  
            </div>   
        @else
            
        @endif    

        <div style="margin: 1rem 0;">
            <b style="color: #44546A; font-size: 1.5rem;">Fecha De Actualización</b><br><br>
            <b style="color: #44546A; text-decoration: underline; text-transform: uppercase;">{{ $fechaGeneracion }}</b>
        </div>
    </main>

    <footer> 

        <table class="table-pdf">
            <thead>
                <tr>
                    @if ($elementosPiePDF->count() > 0)
                    @php
                        $anchoPorElemento = 100 / $elementosPiePDF->count();
                    @endphp
        
                        @foreach ($elementosPiePDF as $elementoPiePDF)
                            @if (is_null($elementoPiePDF -> contenidoImagen))
                                <th class="element-pdf element-text" style="width: {{ $anchoPorElemento }}%;">
                                    @if ($elementoPiePDF->contenidoTexto)
                                        @php
                                            $contenidoArray = json_decode($elementoPiePDF->contenidoTexto);
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
                                <th class="element-pdf element-image" style="width: {{ $anchoPorElemento }}%;">
                                    <img src="{{ asset('storage/' . $elementoPiePDF->contenidoImagen) }}">        
                                </th>
                            @endif
                        @endforeach
                    @else
                        
                    @endif
                </tr>
            </thead>
        </table>
    </footer>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Inventario</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #9edff5;
        }

        tr{
            width: 100%;
        }

        .td-lib_num{
            width: 5%
        }

        .td-lib_titulo{
            width: 20%
        }

        .td-lib_autor{
            width: 15%;
        }

        .td-lib_aPublicacion{
            width: 5%;
        }

        .td-lib_ejemplares{
            width: 5%;
        }

        .td-lib_descripcion{
            width: 30%;
        }

        .td-lib_editorial{
            width: 10%:
        }

        .td-lib_foto{
            width: 10%;
        }
    </style>
</head>
<body>
    <h1>Reporte De Inventario De Libros</h1>

    <p>
        @if (is_null($nombreNivel))
            INVENTARIO GENERAL   
        @else
            Nivel: {{ $nombreNivel -> niv_nombre}}

            @if (is_null($nombreCarrera))
                .
            @else
                . Carrera: {{ $nombreCarrera->car_nombre }}.
            @endif
        @endif
       
    </p>



    <?php 
        $i = 1;
    ?>

    @if ($libros->count() > 0)

        <table>
            <thead>
                <tr>
                    {{-- <th>#</th> --}}
                    <th>NOMBRE DEL LIBRO (TITULO)</th>
                    <th>AUTOR</th>
                    <th>EDITORIAL</th>
                    <th>AÑO DE IMPRESIÓN</th>
                    <th>CANTIDAD</th>
                    <th>IMAGEN</th>                 
                </tr>
            </thead>
            <tbody>
                
            @foreach ($libros as $libro)
                <tr>
                    {{-- <td class="td-lib_num">
                        <?php
                            $acumulador = $i;
                            echo $acumulador;
                            ++$i;
                        ?>
                    </td> --}}
                    <td class="td-lib_titulo"> {{$libro->lib_titulo}} </td>
                    <td class="td-lib_autor"> {{ $libro->aut_nombre }} </td>
                    <td class="td-lib_editorial">{{ $libro->edi_nombre }}  </td>
                    <td class="td-lib_aPublicacion"> {{$libro->lib_aPublicacion}} </td>
                    <td class="td-lib_ejemplares"> {{$libro->lib_ejemplares}} </td> 
                    <td class="td-lib_foto"> 

                    <img src="{{ asset('storage/' . $libro->lib_foto) }}" alt="Imagen">
                    {{-- <img src="{{ public_path('storage/' . $libro->lib_foto) }}" style="width: 100px; height: 100px"> --}}
                    
                    </td>
                </tr>
            @endforeach 

            </tbody>
        </table>
    
    @else
        <p>No se encontraron Libros.</p>
    @endif

    
</body>
</html>

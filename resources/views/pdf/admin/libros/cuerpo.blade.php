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
            font-size: 1.2rem;
            color: #44546A;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 0.8rem;
        }

        .table-libros th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .t.head th {
            background-color: #B4C6E7;
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

        b{
            display: block;
        }
    </style>
</head>
<body>
    <main>
        <h1>INVENTARIO GENERAL</h1>

        <p>
            <span style="font-weight: bold;">AREA:</span>
            BIBLIOTECA
        </p>
    
    
    
        <?php 
            $i = 1;
        ?>
    
        @if ($libros->count() > 0)
    
            <table class="table-libros">
                <thead class="t-head">
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
    
                            {{-- <img src="{{ asset('storage/' . $libro->lib_foto) }}" alt="Imagen"> --}}
                            <img src="{{ public_path('storage/' . $libro->lib_foto) }}" style="width: 100px; height: 100px">
                        
                        </td>
                    </tr>
                @endforeach 
    
                </tbody>
            </table>
        
        @else
            <p>No se encontraron Libros.</p>
        @endif
    
    
        <table>
            <tbody>
                <tr>
                    <td style="border: none;">
                        <b>ACTUALIZO</b>
                        <b style="margin-top: 4rem">ING. CÉSAR AUGUSTO CRUZ LÓPEZ</b><br>
                        <b>COORDINADOR PLANTEL PERIFERICO</b>
                    </td>
                    <td style="border: none;">
                        <b>REVISO</b>
                        <b style="margin-top: 4rem">LIC. FRANCISCO PAULO CRUZ SANTOS</b><br>
                        <b>DIRECTOR DEL PLANTEL OCOSINGO</b>
                    </td>
                </tr>
            </tbody>
    
        </table>
    </main>

    
</body>
</html>

<!DOCTYPE html>
<html>
<head>
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

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
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
        <h1>VISITAS AL SISTEMA</h1>
            <table>
                @if ($selectedOption === 'month')
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Mes</th>
                            <th>Inicios de Sesión</th>                
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td class="td-lib_titulo">{{ $row['year'] }}</td>
                                <td class="td-lib_titulo">{{ $row['month'] }}</td>
                                <td class="td-lib_titulo">{{ $row['login_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                @else
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            {{-- <th>Mes</th> --}}
                            <th>Inicios de Sesión</th>                
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td class="td-lib_titulo">
                                    {{ $row['interval'] }}
                                    {{ $row['year'] }}
                                </td>
                                {{-- <td class="td-lib_titulo">{{ $row['month'] }}</td> --}}
                                <td class="td-lib_titulo">{{ $row['login_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                @endif

            </table>
    </main>
</body>
</html>

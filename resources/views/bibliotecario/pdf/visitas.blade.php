@extends('layouts.nav-librarian') 
@section('titulo', 'UDM - Visitas PDF')

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')
    <div class="container-form" style="max-width: 400px">
        <form action="{{ route('/admin/visitas/pdf.store') }}" method="POST">
            @csrf

            <div class="form-title">
                <h2 style="font-size: 1rem;">Reporte De Visitas</h2>
            </div>

            <div class="form-group">
                <p>Filtrar visitas por...</p><br>
                <div class="container-input form-control">
                    <select name="option" id="option">
                        <option value="month" {{ $selectedOption === 'month' ? 'selected' : '' }}>Mes</option>
                        <option value="interval" {{ $selectedOption === 'interval' ? 'selected' : '' }}>Cuatrimestre</option>
                    </select>
                </div>

                @error('niv_id')
                    <p class= "msg-error">{{$message}}</p>
                @enderror
            </div>

            <div class="container-buttons">
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Generar PDF">
                
                <a href="{{ route('/admin/visitas.index') }}" class="btn-cancel">
                    <input type="button" class="btn btn-default" value="Cancelar">
                </a>
            </div>
        </form>
    </div>

    <script>
        moment.locale('es');

        var data = @json($data);

        var labels = data.map(function(row) {
            if ("{{ $selectedOption }}" === 'month') {
                return moment.months(row.month - 1) + ' ' + row.year;
            } else {
                return row.year + ' - ' + row.interval;
            }
        });

        var ctx = document.getElementById('loginChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Inicios de Sesión',
                    data: data.map(function(row) { return row.login_count; }),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/locale/es.js"></script>
@extends('layouts.nav-librarian') 
@section('titulo', 'UDM - Visitas') 

<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/grafico.css')}}">

@section('main')

    <section class="page-section portfolio" id="pelis">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase mb-0 mt-0">Visitas</h2>

            {{-- <p class="page-section-description">En este apartado se muestran las visitas de alumnos realizadas dentro del sistema. </p> --}}
            
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="divider-custom-line"></div>
            </div>
        </div>
    </section>

    <div class="chart-container">
        <form action="{{ route('/bibliotecario/visitas.index') }}" method="get" style="margin-bottom: 0;">
            
            <div style="display: flex; justify-content:center;">
                <div class="col-md-4">
                    <div class="form-group">
                        {{-- <label for="option">Filtrar por:</label> --}}
                        <div class="container-input form-control"  style="height: 30.4px;">
                            <select name="option" id="option">
                                <option value="month" {{ $selectedOption === 'month' ? 'selected' : '' }}>Por Mes</option>
                                <option value="interval" {{ $selectedOption === 'interval' ? 'selected' : '' }}>Por Cuatrimestres</option>
                            </select>
                        </div>
                    </div>  
                </div> 

                <div class="btn-update">
                    <button type="submit">Actualizar</button>
                </div>
             
                <a href="{{ route('/bibliotecario/visitas/pdf.index') }}" class="icon-pdf" title="Reporte PDF" style="margin-left: 15px;">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
               
            </div>
        </form>

        <canvas id="loginChart"></canvas>
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
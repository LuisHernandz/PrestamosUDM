@extends('layouts.nav-admin') 
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

            <input type="hidden" name="chartImageBase64" id="chartImageBase64">

            <div class="container-buttons">
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Generar PDF">
                
                <a href="{{ route('/admin/visitas.index') }}" class="btn-cancel">
                    <input type="button" class="btn btn-default" value="Cancelar">
                </a>
            </div>
        </form>
    </div>
@endsection

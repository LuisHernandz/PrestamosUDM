
@extends('layouts.nav-admin')
@section('titulo', 'UDM - Edición De PDF')

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

<style>
    .options-pdf{
        display: flex;
        justify-content: center; 
        align-items: center;
        flex-wrap: wrap;
    }
    .option-pdf{
        display: inline-block;
        width: 100%;
        margin-top: 1rem;
        text-align: center;
    }
    .option-pdf a input{
        width: 200px;
    }
</style>

@section('main')
    <div class="container-form" style="max-width: 400px">
        <form action="" method="POST">
            <div class="form-title">
                <h2 style="font-size: 1rem;">Edición PDF - Libros</h2>
            </div>

            <div class="form-group">
                <p>En este apartado puedes editar algunas de las secciones para los reportes PDF de los Libros.</p><br>

                <div class="options-pdf">
                    <div class="option-pdf">
                        <a href="{{ route('admin/edicion-pdf/encabezado.index') }}">
                            <input type="button" class="btn btn-success" value="Encabezado">
                        </a>
                    </div>
        
                    <div class="option-pdf">
                        <a href="{{ route('admin/edicion-pdf/portada.index') }}">
                            <input type="button" class="btn btn-success" value="Imagen De Portada">
                        </a>
                    </div>
        
                    <div class="option-pdf">
                        <a href="{{ route('admin/edicion-pdf/pie.index') }}">
                            <input type="button" class="btn btn-success" value="Pie de página">
                        </a>
                    </div>
                </div>
        
            </div>
        </form>
    </div>
@endsection


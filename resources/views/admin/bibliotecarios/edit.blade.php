@extends('layouts.nav-admin') 
@section('titulo', 'UDM - Modificar Bibliotecario')

<link rel="stylesheet" href="{{url('/assets/css/form-registro.css')}}">

@section('main')
    <div class="container-form">
        <form action="{{ route('/admin/usuarios/bibliotecarios.update',['id' => $usuario -> id]) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-title">
                <h2>Modificar Bibliotecario</h2>

                <div class="btn-back">
                    <a href="{{ route('/admin/usuarios/bibliotecarios.index') }}" >
                    <i class="fa-solid fa-circle-arrow-left"></i>
                        <p>Regresar</p>
                    </a>
                </div>
            </div> 

            <h3>1. Datos personales</h3>

            <div class="row form-sub">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" value="{{ $bibliotecario -> bib_nombre }}" name="bib_nombre">

                        @error('bib_nombre')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{ $bibliotecario -> bib_apellidos }}" name="bib_apellidos" id="lastname">

                        @error('bib_apellidos')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Número de teléfono</label>
                        <input type="tel" class="form-control" value="{{ $bibliotecario -> telefono }}" name="telefono">

                        @error('telefono')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección (Domicilio)</label>
                        <input type="text" class="form-control" value="{{ $bibliotecario -> domicilio }}" name="domicilio">

                        @error('domicilio')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                    
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Género</label>
                        <div class="container-input form-control">

                            <select class = "select" name="generos_gen_id" id="" >

                                <option value="{{ $genero -> gen_id }}" hidden selected>
                                    {{ $genero -> gen_nombre }}
                                </option>

                                @foreach($generos as $genero)
                                    <option value="{{ $genero -> gen_id }}" {{ old('generos_gen_id') == $genero->gen_id ? 'selected' : '' }}> 
                                        {{ $genero -> gen_nombre }} 
                                    </option>
                                @endforeach
                            </select>  
                        </div>

                        @error('generos_gen_id')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                  </div>
                </div>

            <h3>2. Datos de usuario</h3>

            <div class="row form-sub">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="text" class="form-control" value="{{ $usuario -> email }}" name="email">

                        @error('email')
                            <p class= "msg-error">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <input type="text" name="roles_rol_id" value="3" hidden>

            <div class="container-buttons"> 
                <!-- <input type="submit" value="Registrar" class="btn-register"> -->
                <input type="submit" class="btn btn-success" value="Modificar">
                
                <a href="{{ route('/admin/usuarios/bibliotecarios.index') }}" class="btn-cancel">
                    <input type="button" class="btn btn-default" value="Cancelar">
                    <!-- <button>Cancelar</button> -->
                </a>
            </div>
        </form>
    </div>
@endsection
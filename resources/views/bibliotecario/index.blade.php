@extends('layouts.nav-librarian')
@section('titulo', 'UDM - Inicio')

<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">

@section('main')
    <section class="page-section portfolio" id="pelis">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase mb-0">¡Bienvenido a la interfaz del bibliotecario!</h2>

            <p class="page-section-description"> 
                Nos complace darte la bienvenida. 
                Mediante esta interfaz tendrás acceso a un conjunto de funciones diseñadas 
                para gestionar eficientemente los aspectos relacionados con el proceso de prestámo de libros. 
            </p>
            
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-house"></i></div>
                <div class="divider-custom-line"></div>
            </div>
        </div>
    </section>
@endsection  


 
@extends('layouts.nav-admin')
@section('titulo', 'UDM - Inicio')

<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">

@section('main')
    <section class="page-section portfolio" id="pelis">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase mb-0">¡Bienvenido al sistema administrativo!</h2>

            <p class="page-section-description"> 
                

                Nos complace darle la bienvenida como administrador del sistema. 
                Mediante esta interfaz tendrás acceso a un conjunto de funciones diseñadas 
                para gestionar eficientemente los aspectos de la aplicación. 
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


 
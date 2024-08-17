@extends('layouts.nav-student')
@section('title', 'Portal de investigación')

<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">

@section('main') 
    <section class="page-section portfolio" id="pelis">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase mb-0">Portal de investigación</h2>

            <!-- Icon Divider--> 
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-globe"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                @foreach ($enlaces as $enlace) 
                    <div class="col-md-6 col-lg-4 mb-5 contenedor-enlace">
                        <a href="#portfolioModal-{{$enlace->id}}" class="show" data-toggle="modal">
                            <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal-{{$enlace->id}}">
                                <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                                </div>

                                <img class="img-fluid" src="{{ asset('storage').'/'.$enlace -> pdi_imagen }}" alt="..." />
                            </div>
                            <p class="enlace-nombre">{{ $enlace->pdi_nombre }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
 
@foreach ($enlaces as $enlace)  
    <div id="portfolioModal-{{$enlace->id}}" class="modal fade">
        <div class="modal-dialog"  style="max-width: 500px;">
            <div class="modal-content">
                <form>
                    <div class="modal-header"> 						

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="container" style="padding: 0 0 1.5rem 0; text-align:center;">
                            <div class="row justify-content-center">
                                <div class="">
                                    <h2 class="portfolio-modal-title text-uppercase mb-0">
                                        {{ $enlace->pdi_nombre }}
                                    </h2>

                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fa-solid fa-globe"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>

                                    <div class="media justify-content-center mt-4">
                                        <span class="" style="width: 150px; height: 100%;">
                                            <img class="img-fluid" src="{{ asset('storage').'/'.$enlace -> pdi_imagen }}" alt="..." />                                               
                                        </span>
                                    </div>    
                                   
    
                                    <p class="mb-4" style="margin-top: 10px; line-height: 1.5rem;">{{ $enlace->pdi_descripcion }}</p>
                                    
                                    <a href="{{ $enlace->pdi_enlace }}" class="btn btn-primary" target="_blank">
                                        Visitar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach  

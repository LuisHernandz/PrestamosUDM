@extends('layouts.nav-student')
@section('titulo', 'UDM - Publicaciones')

<link rel="stylesheet" href="{{url('/assets/css/portal.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/consulta.css')}}">
<link rel="stylesheet" href="{{url('/assets/css/publicaciones.css')}}">

@section('main') 
    <section class="page-section portfolio" id="pelis">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase mb-0">Publicaciones</h2>
            
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"> <i class="fa-solid fa-image"></i></div>
                <div class="divider-custom-line"></div>
            </div>

        </div>
    </section>

    @foreach ($publicaciones as $publicacion)
        <div class="new-publication" style="">

            <div class="user-information" style="margin-top: 1rem;">
                <div class="user-profile">
                    @if (is_null($publicacion -> foto))
                        <img style="" src="{{url('/assets/images/no-user.png')}}">
                        
                    @else
                        <img src="{{ asset('storage').'/'.$publicacion -> foto }}" alt="">
                    @endif
                </div>
                <div class="user-name">
                    @if ($publicacion -> rol_id == 1)
                        <p>{{ $publicacion -> adm_nombre }} {{ $publicacion -> adm_apellidos }}</p>
                    @elseif ($publicacion -> rol_id == 2)
                        <p>{{ $publicacion -> bib_nombre }} {{ $publicacion -> bib_apellidos }}</p>
                    @endif
                    <p class="publications-date">{{ $publicacion->created_at }}</p>
                </div>
            </div>

            <div>
                <p class="new-publication-description">{{ $publicacion -> descripcion }}</p>

                @if ($publicacion->pub_foto)
                    @if (Str::endsWith($publicacion->pub_foto, ['.jpg', '.jpeg', '.png', '.gif']))
                        <img class="new-publication-image" src="{{ asset('storage').'/'. $publicacion->pub_foto }}" alt="Imagen">
                    @elseif (Str::endsWith($publicacion->pub_foto, ['.mp4', '.avi', '.mov']))
                        <video class="new-publication-video" controls>
                            <source src="{{ asset('storage').'/'. $publicacion->pub_foto }}" type="video/mp4">
                            Tu navegador no admite el elemento de video.
                        </video>
                    @endif
                @endif
            </div>
        </div>
    @endforeach

@endsection



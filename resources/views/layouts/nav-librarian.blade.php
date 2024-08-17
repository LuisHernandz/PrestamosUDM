@extends('layouts.app')

@section('content')

    <div class="layout has-sidebar fixed-sidebar fixed-header">
        <aside id="sidebar" class="sidebar break-point-sm has-bg-image">
            <a id="btn-collapse" class="sidebar-collapser"><i class="fa-solid fa-circle-left"></i></a>
            <div class="image-wrapper">
                <img src="{{url('/assets/images/escudo.png')}}" alt="sidebar background" />
            </div>
            <div class="sidebar-layout">
                <div class="sidebar-header">
                <div class="pro-sidebar-logo">
                    <div>
                    <img src="{{url('/assets/images/escudo.png')}}" alt="sidebar background" />
                    </div>
                    <div class="pro-sidebar-text">
                    <div>
                        <a href="{{route('admin.index')}}">
                        <p>UDM</p>
                        <p>Universidad De México</p>
                        </a>
                    </div>
                    </div>
                </div>
                <!-- <p>BIBLIOTECA</p> -->
                </div>
          
                <div class="sidebar-content">
                <nav class="menu open-current-submenu">
                    <ul>
                        <li class="menu-header">
                            <span> GENERAL </span>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('bibliotecario.index') }}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-house"></i>
                                </span>
                                <span class="menu-title">Inicio</span> 
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{route('bibliotecario/portal.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <span class="menu-title">Portal de investigación</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{route('/bibliotecario/publicaciones.index')}}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-image"></i>
                            </span>
                            <span class="menu-title">Publicaciones</span>
                            </a>
                        </li>

                        <li class="menu-header" style="padding-top: 20px"><span> PRESTÁMOS </span></li>

                        <li class="menu-item">
                            <a href="{{ route('/bibliotecario/solicitudes.index') }}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-paper-plane"></i>
                            </span>
                            <span class="menu-title">Solicitudes</span>
                            <span class="menu-suffix">
                                <span class="badge primary">
                                    {{ $notificacionesNoLeidas }}
                                    Nuevos
                                </span>
                              </span>
                            </a>
                        </li>

                        <li class="menu-item"> 
                            <a href="{{ route('/bibliotecario/prestamos.index') }}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </span>
                            <span class="menu-title">Prestámos</span>
                            </a>
                        </li>

                        <li class="menu-header" style="padding-top: 20px"><span> GESTIÓN DE DATOS </span></li>
                        </li>

                        <li class="menu-item sub-menu">
                        <a href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-circle-user"></i>
                            </span>
                            <span class="menu-title">Usuarios</span>
                            </a>
                            <div class="sub-menu-list">
                            <ul>
                                <li class="menu-item">
                                <a href="{{route('bibliotecario/usuarios/alumnos.index')}}">
                                    <span class="menu-title">Alumnos</span>
                                </a>
                                </li>
                            </ul>
                            </div>
                        </li>

                        

                        <li class="menu-item sub-menu">
                            <a href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-book"></i>
                            </span>
                            <span class="menu-title">Libros</span>
                            </a>
                            <div class="sub-menu-list">
                            <ul>
                                <li class="menu-item">
                                <a href="{{ route('/bibliotecario/libros/inventario.index') }}">
                                    <span class="menu-title">Inventario</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="{{ route('/bibliotecario/libros/autores.index') }}">
                                    <span class="menu-title">Autores</span>
                                </a>
                                </li>
                                <li class="menu-item">
                                <a href="{{ route('/bibliotecario/libros/editoriales.index') }}">
                                    <span class="menu-title">Editoriales</span>
                                </a>
                                </li>                               
                            </ul>
                            </div>
                        </li>

                        @php
                            use App\Models\Nivel;

                            $niveles = Nivel::all();
                        @endphp


                        <li class="menu-item sub-menu">
                            <a href="#">
                            <span class="menu-icon">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <span class="menu-title">Carreras</span>
                            </a>
                            <div class="sub-menu-list">
                            <ul>

                                @foreach ($niveles as $nivel)
                                    <li class="menu-item">
                                    <a href="{{ url('bibliotecario/carreras/index/'.$nivel -> niv_id) }}">
                                        <span class="menu-title">{{ $nivel -> niv_nombre }}</span>
                                    </a>
                                    </li>
                                @endforeach
                            </ul>
                            </div>
                        </li>

                        <li class="menu-item">
                            <a href="{{route('/bibliotecario/portal-de-investigacion.index')}}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                                <span class="menu-title">Enlaces de investigación</span>
                            </a>
                        </li>

                        <li class="menu-header">
                            <span> OTROS </span>
                        </li>

                        <li class="menu-item">
                            <a href="{{ route('/bibliotecario/visitas.index') }}">
                            <span class="menu-icon">
                                <i class="fa-solid fa-chart-simple"></i>
                            </span>
                            <span class="menu-title">Estadísticas de visitas</span>
                            </a>
                        </li>


                        <li class="menu-item">
                            <a href="{{route('bibliotecario/edicion-pdf.index')}}">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </span>
                                <span class="menu-title">Edición De PDF Para Libros</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                </div>
            </div>
        </aside>
        <div id="overlay" class="overlay"></div>

        <div class="layout">
            <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
                <div class="container-fluid">
                <!-- User -->
                <ul class="navbar-nav align-items-center d-md-flex">
                    <li class="nav-item_icon">
                    <a href="{{ route('generar-backup') }}">
                        <i class="bi bi-database-fill-down"></i>
                    </a>
                    </li>
                    <li class="nav-item_icon">
                    <div class="dropdown">
                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border: none; outline: none; cursor: pointer;">
                            <a href="" style="position: relative">
                                <i class="fa-solid fa-bell"></i>
                                <div class="numNotificaciones">
                                    <p>
                                        {{ $notificacionesNoLeidas }}
                                    </p>
                                </div> 
                            </a> 
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 10rem; top: 25px; left: -220px;">
                         
                                @foreach ($bibliotecarios as $usuario)
                                    @if (auth()->user()->id  == $usuario->usuarios_id)
                                        <a class="dropdown-item" href="{{ url('bibliotecario/perfil/'.$usuario -> usuarios_id) }}" style="font-size: 0.8rem">
                                            @if ($notificacionesNoLeidas === 0)
                                                No tienes nuevas notificaciones.
                                            @else
                                                Tienes ({{ $notificacionesNoLeidas }}) nuevas notificaciones.
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                
                        </div> 
                    </div>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">

                        @foreach ($bibliotecarios as $usuario)
                            @if (auth()->user()->id  == $usuario->usuarios_id) 
                                <!-- <img style="" src="{{ asset('storage').'/'.$usuario -> foto }}"> -->
                                @if (empty($usuario -> foto))
                                    <img style="" src="{{url('/assets/images/no-user.png')}}">
                                @else
                                    <img style="" src="{{ asset('storage').'/'.$usuario -> foto }}">
                                @endif 

                            @endif
                        @endforeach
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">
                            <!-- {{ auth()->user()->email }} -->

                            @foreach ($bibliotecarios as $usuario)
                                @if (auth()->user()->id  == $usuario->usuarios_id)
                                    {{ $usuario->bib_nombre }}
                                @endif 
                            @endforeach
                            </span>
                        </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" style="position:absolute;">
                        <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">CUENTA</h6>
                        </div>

                            

                            @foreach ($bibliotecarios as $usuario)
                                @if (auth()->user()->id  == $usuario->usuarios_id)
                                <a href="{{ url('bibliotecario/perfil/'.$usuario -> usuarios_id) }}" class="dropdown-item">
                                    <i class="fa-solid fa-user"></i>
                                    <button style="border:none; background:none">Mi perfil</button>
                                </a>
                                @endif
                            @endforeach


                        <a href="{{ route('login.destroy') }}" class="dropdown-item">
                            <i class="fa-solid fa-right-from-bracket fa-rotate-180"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </div>
                    </li>
                </ul>

                <a id="btn-toggle" href="#" class="sidebar-toggler break-point-sm">
                    <i class="fa-solid fa-bars"></i> 
                </a>
                </div>
            </nav>
            <main class="content">
                @yield('main')
            </main> 
        <div class="overlay"></div>
    </div> 

    @section('scripts_unicos')
        <script src="{{url('/assets/js/menu-vertical.js')}}"></script>                   
    @endsection
@endsection
  

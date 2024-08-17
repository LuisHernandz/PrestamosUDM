<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta etiquetas -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> @yield('titulo') </title>

    <!-- Favicon --> 
    <link rel="shortcut icon" href="{{url('/assets/images/escudo.png')}}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{url('/assets/images/escudo.png')}}">

    <!-- Iconos -->
    <link rel="stylesheet" href="{{url('/fonts/fontawesome/css/all.min.css')}}">

    <!-- Archivos CSS -->
    <link rel="stylesheet" href="{{url('/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{url('/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('/assets/scss/style.css')}}">
    <link rel="stylesheet" href="{{url('/assets/css/menu-horizontal/argon-dashboard.css?v=1.1.2')}}"> 

    <link rel="stylesheet" href="{{url('/assets/css/layaout.min.css')}}">
    <link rel="stylesheet" href="{{url('/assets/css/menu-vertical.css')}}">

    @yield('estilos_unicos') 
    
</head>

<body>
    
    @yield('content')

    <!-- Scripts -->
    <script src="{{url('/assets/js/popper.min.js')}}" ></script> 
    <script src="{{url('/assets/js/recargando.js')}}"></script> 

    <!-- Core -->
    <script src="{{url('/assets/js/menu-horizontal/plugins/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('/assets/js/menu-horizontal/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Optional JS -->
    <script src="{{url('/assets/js/menu-horizontal/plugins/chart.js/dist/Chart.min.js')}}"></script>
    <script src="{{url('/assets/js/menu-horizontal/plugins/chart.js/dist/Chart.extension.js')}}"></script>
    
    @yield('scripts_unicos')
</body>
</html>
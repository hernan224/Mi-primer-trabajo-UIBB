@section('styles')
    {{-- Fonts --}}
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic,700italic|Montserrat:400,700'>
    {{-- Styles --}}
    <link rel="stylesheet" href="{{ url('css/vendor/normalize.css') }}">
    <link rel="stylesheet" href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    {{-- <link rel="stylesheet" href="{{ elixir('css/estilos.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('css/estilos.css') }}">
@endsection

@section('scripts')
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    {{-- <script "></script> --}}
    <script src="{{ url('js/main.js') }}"></script>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @if (trim($__env->yieldContent('title')))
            @yield('title') | Mi Primer Trabajo
        @else
            Mi Primer Trabajo | Un servicio de la UIBB
        @endif
    </title>

    {{-- Incluyo estilos --}}
    @yield('styles')

</head>
<body>
    {{-- Definicion iconos svg --}}
    @include('layouts.svg_icons')

    <div class="container-general-flex">
        <div id="contenedorPrincipal">

            @yield('header')

            @yield('content')

        </div> {{-- /#contenedorPrincipal --}}

        {{-- Footer (con o sin clase home) --}}
        @if (isset($home) && $home)
            @include('layouts.footer', ['home' => $home])
        @else
            @include('layouts.footer', ['home' => false ])
        @endif
    </div>  {{-- /container --}}

    {{-- Incluyo scripts --}}
    @yield('scripts')

</body>

</html>

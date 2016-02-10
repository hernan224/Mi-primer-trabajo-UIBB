@extends('layouts.base')
{{-- La base arma el layout general del HTML y BODY,
        incluye footer, define estilos y scripts, y define secciones de titulo, header y content --}}

@section('header')
    @include('layouts.header_auth')
@endsection
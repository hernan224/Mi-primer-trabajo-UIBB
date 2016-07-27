{{-- Vista (pública) de una publicación --}}
@extends('layouts.base')

@section('title')
    {{ $publicacion->titulo }}
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-md-4">
                    <a id="volverListado" class="link-nav-listado texto-blanco text-left"
                       href="{{ (Auth::check() && Auth::user()->hasRole('admin')) ?
                            route('publicaciones.admin_publicaciones') : url('publicaciones') .'/'.$publicacion->categoria }}">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Volver {{ Auth::check() && Auth::user()->hasRole('admin') ?
                            'al listado de notas' : 'a '.trans('app.'.$publicacion->categoria) }}
                    </a>
                </div>
                @if (Auth::check() && Auth::user()->hasRole('admin'))
                    <div class="col-xs-2 col-md-2 col-md-offset-2">
                        <a id="editar" href="{{ route('publicaciones.publicacion_edit',['id'=>$publicacion->id]) }}" class="link-nav-listado">
                            <span class="glyphicon glyphicon-edit"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Editar</span>
                        </a>
                    </div>
                    <div class="col-xs-2 col-md-2">
                        <a id="eliminar" href="#" class="link-nav-listado" data-toggle="modal" data-target="#confirmarEliminar">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Eliminar</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav> {{-- /.nav-listado --}}

    <div class="container">
        <main class="contenido-nota-individual gap-header-acceso">
            <section class="info-general">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-xs-12 clearfix">

                        <h2>{{ $publicacion->titulo }}</h2>

                        <div class="datos-nota">
                            <span class="dato seccion">
                                <strong>Sección:</strong>
                                <a href="{{ url('publicaciones') .'/'.$publicacion->categoria }}">{{ trans('app.'.$publicacion->categoria) }}</a>
                            </span>
                            <span class="dato fec-publicacion">
                                <strong>Publicado:</strong> {{ $publicacion->updated_at }}
                            </span>
                            <span class="dato edad">
                                <strong>Autor:</strong> {{ $publicacion->autor->name }}
                            </span>
                        </div>

                        @if ($publicacion->imagen)
                            <figure class="container-foto-nota">
                                <img src="{{ $publicacion->getUrlImagen() }}" alt="Imagen destacada"
                                     class="img-responsive foto-destacada">
                            </figure>
                        @endif

                        {!! $publicacion->texto !!}

                    </div>
                </div>
            </section> {{-- /.info-general--}}


        </main> {{-- /contenido-instituciones --}}

        @if (Auth::check() && Auth::user()->hasRole('admin'))
            @include('publicaciones.modal_eliminar')
        @endif

    </div>
@endsection
{{-- Formulario para creación / edición de publicaciones --}}
@extends('layouts.base')

@section('title')
    @if ($nuevo)
        Cargar nueva nota informativa
    @else
        Editar nota informativa
    @endif
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

{{-- Agrego estilos y scripts --}}
@section('scripts')
    @parent
    <script src="{{ url('js/form_alumno.js') }}"></script> {{-- Para preview foto --}}
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '#cuerpoInfo',
            menubar: false,  // removes the menubar
            height: 400,
            skin: "miprimertrabajo",
            skin_url: "{{ url('css/vendor/tinymce/miprimertrabajo') }}",
            lenguage: "es",
            language_url: "{{ url('js/vendor/tinymce/langs/es.js') }}",
            statusbar: false,
            plugins: "link, image, preview",
            toolbar1: "styleselect | undo, redo | cut, copy, paste | link image, preview",
            toolbar2: " bold, italic, underline | alignleft, aligncenter, alignright, alignjustify | bullist, numlist, outdent, indent, blockquote, subscript, superscript"
        });
    </script>
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-5 col-md-3">
                    <a id="volverListado" href="{{ route('publicaciones.admin_publicaciones') }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Volver al listado de notas
                    </a>
                </div>
                @if (!$nuevo)
                    {{-- Si esta editando: boton eliminar --}}
                    <div class="col-xs-3 col-sm-2 col-md-offset-7 col-sm-offset-5 col-xs-offset-3">
                        <a id="eliminar" href="#" class="link-nav-listado" data-toggle="modal" data-target="#confirmarEliminar">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Eliminar</span>
                        </a>
                    </div> {{-- btn eliminar --}}
                @endif
            </div> {{-- .row --}}
        </div>
    </nav> {{-- /.nav-listado --}}

    <div class="container">
        <article class="cargar-nota">
            {{ Form::model($publicacion, [
                'route' => ($nuevo) ? 'publicaciones.publicacion_nueva_post' : ['publicaciones.publicacion_edit_put',$id],
                'method' => ($nuevo) ? 'POST' : 'PUT', 'files' => true,
                'role'=>"form", 'class'=>"fila-flex form-mpt" ] ) }}

            <main class="cargar-datos">
                <h3 class="titulo-seccion texto-azul">
                    {{ ($nuevo) ? 'Cargar nueva nota informativa' : 'Editar nota informativa' }}
                </h3>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ ucfirst($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <fieldset class="row">
                    <div class="form-group col-xs-12{{ $errors->has('titulo') ? ' has-error' : '' }}">
                        {{ Form::label('titulo', 'Título', ["class"=>"sr-only input-label small"]) }}
                        {{ Form::text('titulo',null,['class'=>'form-control titulo-info','placeholder'=>'Título','required'=>'required']) }}
                    </div>

                    <div class="form-group col-md-9 col-xs-12 {{ $errors->has('categoria') ? ' has-error' : '' }}">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                {{ Form::label('categoria', 'Tipo de información:', ["class"=>"input-label"]) }}
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                {{ Form::select('categoria',
                                    [
                                        'capacitaciones' => 'Capacitación',
                                        'practicas' => 'Práctica Profesionalizante',
                                    ],
                                    null,
                                    ['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12{{ $errors->has('texto') ? ' has-error' : '' }}">
                        {{ Form::label('texto', 'Cuerpo de la información', ["class"=>"sr-only"]) }}
                        {{ Form::textarea('texto', null,['class'=>'form-control', 'id'=>"cuerpoInfo"]) }}
                    </div>
                </fieldset>
            </main>

            <aside class="datos-fijos">
                <section class="cargar-foto">

                    <label for="cargarFoto" class="cargar-foto-btn text-center">
                        <figure id='foto-preview' class="foto-bg foto-alumno foto-placeholder foto-destacada"
                                {!! (!$nuevo && $publicacion->imagen) ? 'style="background-image: url('.$publicacion->getUrlImagen().');"' : '' !!} >
                        </figure>

                        <strong>{{ (!$nuevo && $publicacion->imagen) ? 'Cambiar la ' : 'Cargar una ' }}imagen destacada</strong>
                        {{ Form::file('imagen',['id'=>"cargarFoto", 'accept'=>".jpeg, .jpg, .png"]) }}
                    </label>

                    <span class="error small"></span>
                    <span class="small">Formato: JPG, JPEG o PNG. Peso máximo: 1Mb. </span>
                </section>
                <section class="guardar-datos panel-bg-color">
                    <div class="contenedor-datos-fijos">
                        @if ($nuevo)
                            <p><strong>Autor: </strong>{{ Auth::user()->name }}</p>
                        @else
                            <p><strong>Creado / Editado: </strong>{{ $publicacion->updated_at }}</p>
                            <p><strong>Autor: </strong>{{ $publicacion->autor->name }}</p>
                        @endif
                    </div>

                    <div class="contenedor-btns">
                        <div class="panel-privado">
                            <div class="panel-body">
                                <div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('borrador','si',!$nuevo && $publicacion->borrador) }}
                                        Guardar como borrador
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{ Form::button( ($nuevo) ? 'Crear nota' : 'Guardar cambios', ['type' => 'submit','class' => 'btn btn-primary btn-guardar']) }}
                        @if ($nuevo)
                            {{--<button type="reset" class="btn btn-link btn-descartar">Descartar</button>--}}
                            <a href="{{ route('publicaciones.admin_publicaciones') }}" class="btn btn-link btn-descartar">Descartar</a>
                        @else
                            <a href="{{ route('publicacion_show',['categoria' => $publicacion->categoria,'id' => $id ]) }}" class="btn btn-link btn-descartar">Descartar cambios</a>
                            <a href="#" class="btn btn-link btn-descartar" data-toggle="modal" data-target="#confirmarEliminar">Eliminar nota</a>
                        @endif
                    </div>
                </section>

            </aside>

            {{ Form::close() }} {{-- .fila-flex --}}
        </article> {{-- ./cargar-nota --}}
    </div> {{-- ./container --}}

    @include('layouts.spinner')

    @include('publicaciones.modal_eliminar')
@endsection
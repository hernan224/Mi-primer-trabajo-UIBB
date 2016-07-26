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
            skin_url: "css/vendor/tinymce/miprimertrabajo",
            lenguage: "es",
            language_url: "css/vendor/tinymce/langs/es.js",
            statusbar: false,
            plugins: "link, image, preview",
            toolbar1: "styleselect | undo, redo | cut, copy, paste | link image, preview",
            toolbar2: " bold, italic, underline | alignleft, aligncenter, alignright, alignjustify | bullist, numlist, outdent, indent, blockquote, subscript, superscript"
        });
    </script>
@endsection
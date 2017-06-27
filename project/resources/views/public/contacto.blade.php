{{-- Pantalla contacto. URL: /contacto --}}
@extends('layouts.base')

@section('title')
    Contacto
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            // mostrar spinner
            $('form').submit(function() {
                $('.spinner-container').show();
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
    <main class="contenido-contacto gap-header-acceso">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
            <!--<div class="col-xs-12">-->
                <h2 class="texto-azul">Contacto</h2>
                <p>Si desea obtener más información, o hacernos llegar su
                    comentario, acerca de la plataforma <strong>Mi Primer Trabajo</strong>, contáctenos a través
                    del siguiente formulario. A la brevedad, un miembro de de la UIBB se pondrá en contacto con
                    usted.</p>
            </div>
            <!--<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">-->
            <div class="col-md-8 col-md-offset-2">

                <form action="{{ route('contacto') }}" method="POST" role="form"
                      class="contacto-form form-mpt panel-bg-color form-invertido">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="sr-only input-label small" for="nombre">Nombre y Apellido</label>
                        <input type="text" class="form-control" name="nombre"
                               id="nombre" placeholder="Nombre y Apellido" required>
                    </div><!--/input Nombre y Apellido-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="email">Email</label>
                        <input type="email" class="form-control" name="email"
                               id="email" placeholder="Email"  required>
                    </div><!--/input Email de contacto-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono"
                               id="telefono" placeholder="Teléfono">
                    </div><!--/input telefono-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="asunto">Asunto</label>
                        <input type="text" class="form-control" name="asunto"
                               id="asunto" placeholder="Asunto"  required>
                    </div><!--/input Asunto-->

                    <div class="form-group">
                        <label class="sr-only input-label small" for="mensaje">Mensaje</label>
                        <textarea name="mensaje" class="form-control" id="mensaje" rows="4" placeholder="Mensaje"  required></textarea>
                    </div> <!--/textarea Mensaje-->

                    <div class="contenedor-btns">
                        <button type="submit" class="btn btn-primary btn-login center-block">Enviar
                        </button>
                    </div>

                </form>

            {{-- Link solicitar acceso: pantalla deshabilitada
                <p class="text-center texto-especial"><em>Si usted es <strong>asociado de la UIBB o es directivo de una institución
                    educativa</strong> y
                    desea participar de la plataforma <strong>Mi Primer Trabajo</strong>, contáctese desde aquí:</em></p>

                <a class="btn btn-registro" href="{{ url('/solicitar-acceso')}}">Solicitar acceso a la plataforma</a>
            --}}
            </div>

        </div>
    </main>
</div>
@include('layouts.spinner')
@endsection
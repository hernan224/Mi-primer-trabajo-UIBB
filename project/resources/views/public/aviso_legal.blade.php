{{-- Pantalla contacto. URL: /contacto --}}
@extends('layouts.base')

@section('title')
    Aviso legal
@endsection

@section('header')
    @include('layouts.header_simple')
@endsection


@section('content')
<div class="container">
    <main class="aviso-legal">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <h3 class="texto-azul">Aviso legal</h3>
                <div class="panel-bg-color">
                    <p>Se deja expresa constancia que la UIBB, no se responsabiliza de
                    la veracidad de los datos
                    vertidos por las Escuelas Técnicas y/o Institutos de Enseñanza Superior participantes del
                    presente programa, siendo los mismos exclusiva incumbencia de dichos establecimientos.</p>

                    <p>La presente plataforma virtual de inserción laboral, no implica ninguna relación jurídica
                        y/o
                        contractual y/o laboral con las empresas asociadas a la UIBB, ni con los estudiantes y/o
                        egresados que figuren en los registros, resultando el proyecto, solo un nexo de
                        vinculación
                        entre el sector productivo y las instituciones educativas participantes.</p>
                </div>
            </div>
            <!--<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">-->


        </div>
    </main><!--/.contenido-login-->
</div>
@endsection
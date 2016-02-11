{{-- Pantalla login. URL: /login --}}
@extends('layouts.base')

@section('title')
    Login
@endsection

@section('header')
    @include('layouts.header_simple')
@endsection

@section('content')
<div class="container">
    <main class="contenido-login">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
                <h3 class="texto-azul">Iniciar Sesión</h3>
                <form method="POST" action="{{ url('/login') }}" role="form" class="login-form panel-bg-color form-mpt form-invertido">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="sr-only input-label small" for="usuario">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="sr-only input-label small" for="pass">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" checked>
                            Permanecer conectado
                        </label>
                    </div>

                    <div class="contenedor-btns">
                        <button type="submit" class="btn btn-primary btn-login center-block">
                            Iniciar Sesión
                        </button>
                        {{-- ToDo: implementar recuperación de contraseña?? 
                        <a class="btn btn-link center-block recuperar-pass" href="{{ url('/password/reset') }}">
                            Recuperar contraseña
                        </a>
                        --}}
                    </div>
                </form>

                <p>Si usted es <strong>asociado de la UIBB o es directivo de una institución educativa</strong> y
                    desea participar de la plataforma Mi Primer Trabajo, contáctese con nosotros:</p>

                <a class="btn btn-registro" href="#ToDo">Solicitar acceso a la plataforma</a>
            </div>

        </div>
    </main>
</div>

@endsection

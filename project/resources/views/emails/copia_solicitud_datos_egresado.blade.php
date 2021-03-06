<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Solicitud de datos de egresado</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <h2>Solicitud de datos de egresado</h2>
        <br>
        <p><i>El presente mail es una copia del email enviado a la empresa que solicitó los datos del egresado.</i></p>
        <h3>Datos solicitante</h3>
        <div><strong>Nombre y apellido: </strong> {{$nombre}}</div>
        @if ($empresa)
            <div><strong>Empresa: </strong> {{$empresa}}</div>
        @endif
        <div><strong>Email: </strong> {{$email}}</div>
        <br>
        <h3>Datos egresado solicitado</h3>
        <div><strong>Nombre y apellido: </strong> {{$egresado->nombre}} {{$egresado->apellido}}</div>
        {{-- <div><strong>DNI: </strong> {{$egresado->dni}}</div> --}}
        <div><strong>Servicio educativo: </strong> {{$egresado->institucion->name}}</div>
        <div><strong>Especialidad: </strong> {{$egresado->curriculum->especialidad}}</div>
        @if ($egresado->domicilio)
            <div><strong>Dirección: </strong> {{$egresado->domicilio}}</div>
        @endif
        @if ($egresado->localidad || $egresado->barrio)
            <div><strong>Localidad / barrio: </strong> {{ $egresado->localidad or '' }} {{ ($egresado->barrio) ? '(Barrio '.$egresado->barrio.')' : ''}}</div>
        @endif
        @if ($egresado->tel_fijo)
            <div><strong>Teléfono: </strong> {{$egresado->tel_fijo}}</div>
        @endif
        @if ($egresado->celular)
            <div><strong>Celular: </strong> {{$egresado->celular}}</div>
        @endif
        @if ($egresado->email)
            <div><strong>E-mail: </strong> {{$egresado->email}}</div>
        @endif
        <br>
        <div><strong><a href="{{route('egresado_show',['id'=>$egresado->id])}}">Link al perfil en la web</a></strong></div>
        <br>
        <br>
        <p>
            <u>AVISO LEGAL</u><br>
            Se deja expresa constancia que la UIBB, no se responsabiliza de la veracidad de los datos vertidos
            por las Escuelas Técnicas y/o Institutos de Enseñanza Superior participantes del presente programa,
            siendo los mismos exclusiva incumbencia de dichos establecimientos.
            La presente plataforma virtual de inserción laboral, no implica ninguna relación jurídica y/o contractual y/o laboral
            con las empresas asociadas a la UIBB, ni con los estudiantes y/o egresados que figuren en los registros,
            resultando el proyecto, solo un nexo de vinculación entre el sector productivo y las instituciones educativas participantes.
        </p>
    </body>
</html>
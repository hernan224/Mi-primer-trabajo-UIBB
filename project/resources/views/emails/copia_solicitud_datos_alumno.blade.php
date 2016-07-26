<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Solicitud de datos de alumno</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <h2>Solicitud de datos de alumno</h2>
        <br>
        <h3>Datos solicitante</h3>
        <div><strong>Nombre y apellido: </strong> {{$nombre}}</div>
        @if ($empresa)
            <div><strong>Empresa: </strong> {{$empresa}}</div>
        @endif
        <div><strong>Email: </strong> {{$email}}</div>
        <br>
        <h3>Datos alumno solicitado</h3>
        <div><strong>Nombre y apellido: </strong> {{$alumno->nombre}} {{$alumno->apellido}}</div>
        <div><strong>DNI: </strong> {{$alumno->dni}}</div>
        <div><strong>Servicio educativo: </strong> {{$alumno->escuela->name}}</div>
        <div><strong>Especialidad: </strong> {{$alumno->curriculum->especialidad}}</div>
        @if ($alumno->domicilio)
            <div><strong>Dirección: </strong> {{$alumno->domicilio}}</div>
        @endif
        @if ($alumno->localidad || $alumno->barrio)
            <div><strong>Localidad / barrio: </strong> {{ $alumno->localidad or '' }} {{ ($alumno->barrio) ? '(Barrio '.$alumno->barrio.')' : ''}}</div>
        @endif
        @if ($alumno->tel_fijo)
            <div><strong>Teléfono: </strong> {{$alumno->tel_fijo}}</div>
        @endif
        @if ($alumno->celular)
            <div><strong>Celular: </strong> {{$alumno->celular}}</div>
        @endif
        @if ($alumno->email)
            <div><strong>E-mail: </strong> {{$alumno->email}}</div>
        @endif
        <br>
        <div><strong><a href="{{route('alumno_show',['id'=>$alumno->id])}}">Link al perfil en la web</a></strong></div>
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
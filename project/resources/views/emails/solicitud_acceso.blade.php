<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Solicitud de acceso</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
   <body>
        <h2>Solicitud de acceso a la plataforma</h2>
        <h3>{{ ($tipo == 'empresa') ? 'Empresa' : 'Institución educativa' }}</h3>
        @if ($tipo == 'empresa')
            <div><strong>Razón social: </strong> {{$razon_social}}</div>
            <div><strong>CUIT: </strong> {{$cuit}}</div>
            <div><strong>Email contacto: </strong> {{$email}}</div>
        @else
            <div><strong>Nombre: </strong> {{$nombre}}</div>
            <div><strong>Docente: </strong> {{$docente}}</div>
            <div><strong>Email contacto: </strong> {{$email}}</div>
        @endif
   </body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Formulario de contacto</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
   <body>
        <h2>Formulario de contacto</h2>
        <h3>{{$asunto}}</h3>
        <div><strong>Nombre y Apellido: </strong> {{$nombre}}</div>
        <div><strong>Email: </strong> {{$email}}</div>
        <div><strong>Teléfono: </strong> {{$telefono}}</div>
        <div><strong>Mensaje:</strong><br/>
            <pre>{{$mensaje}}</pre>
        </div>
   </body>
</html>
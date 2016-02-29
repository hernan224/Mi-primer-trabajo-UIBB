<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Alumno | Mi Primer Trabajo</title>

    <link rel="stylesheet" href="css/vendor/normalize.css" media="print">

    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <!--<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic,700italic|Montserrat:400,700'>-->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="css/vendor/font-awesome.min.css" media="print">
    <!--<link rel="stylesheet" href="css/estilos.css">-->
    <link rel="stylesheet" href="css/generar-pdf.css" media="print">

</head>
<body>

<div class="container-general-flex">
    <div class="contenedor-principal">
        <div class="container">

            <header class="header-acceso acceso-asociado fila-flex">
                <div class="marca-container">

                    <figure class="logo-mpt">
                        <img src="img/logo-mpt.png" alt="Mi Primer Trabajo"
                             class="img-responsive logo-pdf">
                    </figure>

                </div> <!--.marca-container-->
            </header>


            <article class="alumno-individual">
                <header class="alumno-info-principal">

                    <div class="contenedor-foto">
                        <figure class="foto-bg foto-alumno masculino">
                            <img src="img/foto-alumno-test.jpg" alt="Gilberto Manhatan Ruiz"
                                 class="img-responsive alumno-img">
                        </figure> <!--/.foto-alumno-->
                    </div>

                    <div class="info-alumno">
                        <h2 class="nombre-alumno">Gilberto Manhatan Ruiz</h2>

                        <div class="datos-alumno">
                            <span class="sexo"><strong>Sexo:</strong> Masculino</span>
                            <span class="fec-nac"><strong>Fecha de Nac.:</strong> 25/10/1996</span>
                            <span class="edad"><strong>Edad:</strong> 19 años</span>
                            <span class="nacionalidad"><strong>Nacionalidad:</strong> Argentino</span>
                            <span class="dni"><strong>DNI:</strong> 40.258.367</span>
                        </div>
                    </div>

                    <div class="promedio">
                        <strong class="promedio-titulo">Promedio General</strong>
                        <span class="promedio-valor">8,25</span>
                    </div> <!--.promedio-->

                </header> <!--/header info principal-->
                <div class="fila-flex">
                    <aside class="info-contactos">
                        <section class="contacto-alumno panel-bg-color">
                            <h5 class="subtitulo texto-azul">Datos de contacto</h5>

                            <ul class="fa-ul lista-contacto">
                                <li><span class="sr-only">Ciudad / Barrio: </span><i class="fa fa-li fa-home"></i>Mitre 206, piso 3, dpto C</li> <!--ciudad / barrio-->
                                <li><span class="sr-only">Dirección: </span><i class="fa fa-li fa-map-marker"></i>Bahía Blanca (Barrio Centro)</li> <!--Dirección-->
                                <li><span class="sr-only">Teléfono: </span><i class="fa fa-li fa-phone"></i>0291 - 454 5072</li> <!--Teléfono-->
                                <li><span class="sr-only">Celular: </span><i class="fa fa-li fa-mobile"></i>0291 - 505 0862</li> <!--Celular-->
                                <li><span class="sr-only">E-mail: </span><i class="fa fa-li fa-at"></i><a href="#">hernan224@gmail.com</a></li> <!--E-mail-->
                                <li><span class="sr-only">Facebook: </span><i class="fa fa-li fa-facebook"></i><a href="#">facebook.com/hernan224</a></li> <!--Facebook-->
                                <li><span class="sr-only">Twitter: </span><i class="fa fa-li fa-twitter"></i><a href="#">@hernan224</a></li> <!--Twitter-->
                                <li><span class="sr-only">LinkedIn: </span><i class="fa fa-li fa-linkedin"></i><a href="#">linkedin.com/in/hernan224</a></li> <!--Linkedin-->
                            </ul>
                        </section> <!--/.contacto-alumno-->

                        <section class="contacto-docente panel-bg-color">
                            <h5 class="subtitulo texto-azul">Docente de contacto</h5>
                            <ul class="list-unstyled">
                                <li><span class="sr-only">Nombre: </span><strong>Juana Ana Triana</strong></li> <!--Nombre docente a cargo-->
                                <li><span class="sr-only">Teléfono: </span>0291 - 505 0862</li> <!--Telefono-->
                                <li><span class="sr-only">E-mail: </span>juanana@gmail.com</li> <!--E-mail-->
                            </ul>
                        </section><!--/.contacto-docente-->
                    </aside><!--/.info-contactos-->

                    <main class="info-detalle">
                        <section class="info-curricular">
                            <h5 class="subtitulo texto-azul">Información curricular educativa</h5>
                            <p><strong>Servicio Educativo: </strong>Escuela de Educación Técnica N° 1</p>
                            <p><strong>Especialidad: </strong>Bachiller con orientación en Equipos e Instalaciones Electromecánicas</p>
                            <p><strong>Práctica Profecional: </strong>Equipos e Instalaciones Electromecánicas
                                <br>
                                (Realizada en <strong>Consorcio de Gestión del Puerto de Bahía Blanca</strong>)
                            </p>
                            <p><strong>Asignatura destacada: </strong>Física, Matemática</p>
                        </section> <!--/.info-curricular-->

                        <section class="actitudes">
                            <h5 class="subtitulo texto-azul">Actitudes destacadas</h5>

                            <ul class="list-inline fa-ul lista-actitudes">
                                <li><i class="fa fa-li fa-check texto-azul"></i>Responsabilidad</li>
                                <li><i class="fa fa-li fa-check texto-azul"></i>Puntualidad</li>
                                <li><i class="fa fa-li fa-check texto-azul"></i>Perseverancia</li>
                                <li><i class="fa fa-li fa-check texto-azul"></i>Trabajo en equipo</li>
                                <li><i class="fa fa-li fa-check texto-azul"></i>Liderazgo positivo</li>
                                <li><i class="fa fa-li fa-check texto-azul"></i>Hábitos saludables</li>
                            </ul>
                        </section> <!--/.actitudes-->

                        <section class="info-adicional">
                            <h5 class="subtitulo texto-azul">Información adicional</h5>
                            <div class="datos-alumno">
                                <p><strong>Hobbies, pasatiempos o actividades extracurriculares: </strong>
                                    Pesca con moscardones. Tirarle la goma al diablo. Fumar abajo del agua ras.</p>
                                <p><strong>Participación institucional, social o deportiva: </strong>
                                    Juega al futbol en el club nautico.</p>
                            </div>
                        </section> <!--/.info-adicional-->


                    </main> <!--/.info-detalle-->

                </div> <!--/.fila-flex-->
                <section class="carta-presentacion">
                    <h5 class="subtitulo texto-azul">Carta de presentación</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam consectetur deleniti doloremque ea ipsum laboriosam magnam nam provident quos, voluptas.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium fugit minus officiis sunt temporibus? Accusantium consequuntur deserunt doloremque facilis fugiat harum libero nam, nihil odit officia repellendus unde velit voluptate.</p>
                </section> <!--/.carta-presntacion-->
            </article> <!--/.alumno-individual-->

        </div> <!--/.container-->
    </div> <!--/#contenedorPrincipal-->
</div>

</body>
</html>
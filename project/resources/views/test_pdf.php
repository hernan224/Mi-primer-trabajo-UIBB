<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Alumno | Mi Primer Trabajo</title>

    <link rel="stylesheet" href="css/vendor/normalize.css">

    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,400italic,600italic,700italic|Montserrat:400,700'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/estilos.css" media="screen">
    <link rel="stylesheet" href="css/print-pdf.css" media="print">

</head>
<body>
<!--LOGO EN SVG-->
<svg class="hide-svg">
    <defs>
        <symbol id="logoMPT" viewBox="0 0 324.343 164.374"><path d="M19.233 147.655l-6.975-21.382H2v31h7v-23.08l6.358 23.08h7.203l8.44-23.08v23.08h7v-31H26.21m18.01-3.616c-2.326 0-4.15 1.87-4.15 4.194 0 2.28 1.824 4.15 4.15 4.15 2.325 0 4.193-1.87 4.193-4.15 0-2.32-1.868-4.19-4.194-4.19zM41 132.273h9v25h-9zm27.976-6H59v31h7v-13h3.02c6.065 0 9.894-3.256 9.894-9.09 0-5.974-3.328-8.91-9.938-8.91zm-.64 10H66v-4h2.337c1.687 0 2.736.222 2.736 1.954 0 1.778-1.003 2.046-2.736 2.046zM89 133.645v-1.372h-7v25h7v-15.467c0-1.504-.237-1.533 1.723-1.533H93v-8.45c-2-.002-2 .637-4 1.822zm9.2-10.988c-2.325 0-4.15 1.87-4.15 4.194 0 2.28 1.825 4.15 4.15 4.15s4.194-1.87 4.194-4.15c0-2.32-1.868-4.19-4.194-4.19zm-3.2 9.616h7v25h-7zm34.225-.59c-3.19 0-5.05 1.278-6.097 2.235-1.185-1.368-2.147-2.234-4.837-2.234-3.1 0-4.29 1.277-4.29 1.824v-1.235h-9v25h9v-16.15c0-1.78.32-2.92 2-2.92 1.74 0 2 1.186 2 2.965v16.105h7v-16.105c0-1.596 1.73-2.964 3.5-2.964 1.74 0 3.5 1.185 3.5 2.964v16.105h6v-16.97c0-4.698-2.48-8.62-8.77-8.62zm22.365-.135c-7.112 0-11.99 5.425-11.99 12.72 0 7.796 5.106 12.492 12.538 12.492 6.064 0 9.255-3.237 10.623-6.064l-5.6-3.283c-.86 1.368-2.37 2.735-4.97 2.735-2.82 0-4.65-1.876-4.97-3.876h16.28c.1-1 .1-1.96.1-2.69 0-7.293-4.51-12.034-11.99-12.034zm-4.194 10.725c.182-4 1.64-3.738 4.194-3.738 2.644 0 4.194-.262 4.377 3.738h-8.57zM175 133.645v-1.372h-9v25h9v-15.467c0-1.504-1.525-1.533.435-1.533H177v-8.45c-1-.002-2 .637-2 1.822zm11-1.372h5v25h8v-25h5v-6h-18m28 7.372v-1.372h-8v25h8v-15.467c0-1.504-1.27-1.533.69-1.533H217v-8.45c-1-.002-3 .637-3 1.822zm13.236-1.61c-5.972 0-8.943 3.238-9.08 8.238h6.793c0-2 .72-2.448 2.45-2.448 1.82 0 2.59.926 2.59 2.294v1c0-.41-2.23-.87-4.24-.87-5.06 0-8.46 3.19-8.41 8.02.04 5.19 4.29 8.34 9.08 8.34 2.32 0 3.56-.6 5.56-1.6v2.24h5V141.2c0-5.47-2.15-9.18-9.76-9.18zm-.326 18.798c-1.596 0-2.78-1.14-2.78-2.736 0-1.55 1.14-2.69 2.735-2.69s2.827 1.048 2.827 2.69c0 1.596-1.186 2.736-2.782 2.736zm27.55-19.285c-2.827 0-5.46 1.003-5.46 2.097v-11.372h-9v35h7v-2.564c2 1.32 3.77 2.05 6.186 2.05 7.568 0 12.878-5.38 12.878-12.63 0-7.53-4.173-12.59-11.604-12.59zm-1.972 18.647c-3.465 0-5.745-2.553-5.745-6.064 0-3.51 2.052-6.1 5.7-6.1 3.51 0 5.698 2.6 5.698 6.11.01 3.47-2.05 6.07-5.65 6.07zM288 157.273v-16.06c0-5.47-2.915-9.18-10.53-9.18-5.972 0-9.707 3.24-9.844 8.24h6.793c0-2 .98-2.45 2.72-2.45 1.82 0 2.86.927 2.86 2.295v1.003c0-.41-2.5-.86-4.5-.86-5.06 0-8.59 3.19-8.55 8.03.04 5.2 3.99 8.35 8.77 8.35 2.32 0 4.26-.59 5.26-1.59v2.25h7zm-11.62-6.44c-1.596 0-2.78-1.14-2.78-2.736 0-1.55 1.14-2.69 2.735-2.69s2.827 1.048 2.827 2.69c0 1.596-1.187 2.736-2.782 2.736z"/><path d="M290 155.94c0 1.093-1.037 2.332-2.723 2.332H286v6.055c2 .045 2.535.045 2.99.045 6.2 0 9.01-3.465 9.01-8.39v-23.71h-8v23.667zm2.748-33.283c-2.325 0-4.15 1.87-4.15 4.194 0 2.28 1.825 4.15 4.15 4.15s4.195-1.87 4.195-4.15c0-2.32-1.87-4.19-4.195-4.19zm18.692 8.89c-7.476 0-12.765 5.563-12.765 12.675 0 7.067 4.97 12.538 12.81 12.538 7.752 0 12.858-5.562 12.858-12.675 0-7.066-4.923-12.537-12.902-12.537zm.092 18.6c-3.282 0-5.562-2.55-5.562-5.97s2.052-6.02 5.517-6.02c3.328 0 5.562 2.6 5.562 6.02 0 3.374-2.06 5.97-5.52 5.97zM40.642 53.71c.668 5.877 4.386 10.815 9.532 13.22.05-.452.084-.91.084-1.376 0-5.83-4.126-10.696-9.616-11.843zm6.61-4.168l5.852-3.527 4.18 4.18-3.733 5.55c.94 1.526 2.3 3.202 2.76 4.984L64 62.48v5.083c7-2.275 10.564-8.46 10.564-15.754 0-9.23-7.797-16.7-17.02-16.7-6.758 0-12.725 4.02-15.352 9.8l.443 2.66c1.67.43 3.168 1.1 4.617 1.96zM35.132 64.37c-1.266-2.132-2.226-4.47-2.822-6.943l-2.498-.62c-2.31 2.203-3.754 5.303-3.754 8.747 0 5.507 3.685 10.15 8.72 11.612l-4.935-4.937 5.29-7.86zm1.28 13.144c.57.083 1.15.14 1.746.14 3.16 0 6.03-1.222 8.185-3.207-.89-.408-1.76-.85-2.59-1.354l-7.34 4.42z"/><path d="M102 27.6L49.73 0 0 27.83v54.28l50.424 25.3L102 82.107V27.6zM92 55.72l-10.127 1.896c-.603 2.423-1.776 4.706-3.024 6.796l4.78 8.132-5.83 5.766-7.77-5.205c-2.06 1.253-4.33 1.78-6.72 2.405l-2.3 8.764h-8.15l-.12-.14-5.33-3.367c-1.5.908-3.13 1.496-4.86 1.95l-1.65 6.557H35l-1.283-6.338c-1.905-.447-3.698-1.078-5.323-2.067l-5.9 3.6-4.18-4.15 3.833-5.68c-.918-1.55-1.032-3.23-1.464-5.03L15 68.07v-5.91l5.7-1.23c.448-1.822.874-3.538 1.82-5.1l-3.675-5.86 4.107-4.18 1.676 1.152 7.722-1.517c.617-2.513 1.596-4.882 2.902-7.038l-4.876-8.085 5.766-5.768 7.775 5.227c2.182-1.3 4.576-2.49 7.118-3.1l2.278-9.38h8.155l1.822 9.52c2.308.6 4.484 1.63 6.485 2.82l8.075-4.82 5.77 5.8-5.15 7.67c1.3 2.11 2.73 4.43 3.36 6.89L92 47.57v8.15z"/><circle cx="152.085" cy="31.478" r="2.472"/><path d="M169 44.418v25.855h15.588"/><path d="M212 82.11V27.602L159.73.002 110 27.832V82.11l50.424 25.298L212 82.11zm-75.714-5.982l-6.528 6.526 1.948-8.93 16.073-35.79c-1.83-1.333-3.17-3.485-3.17-5.92 0-3.776 3.38-6.886 6.38-7.282V20.88c0-.738.89-.607 1.62-.607.74 0 2.37-.13 2.37.606v4.06c3 .83 4.93 3.68 4.93 7.07 0 2.62-1.23 4.91-3.29 6.2 1.29 3.46 4.36 9.83 6.36 16.71V15.61l32.47 63.663h-24.68c1 2 1.57 4.72 1.44 4.72-.44 0-3.218-2.72-5.13-4.72H163V68.85c-4-7.85-7.978-19.645-10.602-26.54l-16.112 33.818zm142.217-23.793s3.978 4.187 6.223 8.25l.694-1.685c-3.04-3.582-6.917-6.565-6.917-6.565zm-1.233 19.213s1.302-.005 3.028-.21l.32-.78c-1.803.69-3.347.99-3.347.99z"/><path d="M322 82.11V27.602L269.73.002 220 27.832V82.11l50.424 25.298L322 82.11zm-30.17-42.222c1.673 0 3.03 1.356 3.03 3.03 0 1.672-1.357 3.028-3.03 3.028-1.673 0-3.03-1.356-3.03-3.03 0-1.673 1.357-3.028 3.03-3.028zm-3.416-7.754c.602 0 1.09.488 1.09 1.09 0 .602-.488 1.09-1.09 1.09s-1.09-.488-1.09-1.09c0-.6.488-1.09 1.09-1.09zm-4.175 4.604c1.04 0 1.89.85 1.89 1.897 0 1.047-.85 1.897-1.9 1.897-1.05 0-1.9-.85-1.9-1.897 0-1.048.85-1.897 1.89-1.897zm-34.6 34.606c-7.5-5.24 10.2-22.605 13.17-24.35 0 0 2.18-.668 2.18-3.237V30.71c-2-.493-3.07-.437-3.19-1.437h1.2v-6h-1.19c-.01 0-.03-.194-.03-.263 0-1.702 3.58-3.11 8.01-3.11 4.42 0 8.01 1.423 8.01 3.125 0 .07-.02.25-.02.25h2.2v6h-2.21c-.12 1 .21.883.21 1.36v13.123c0 2.57.57 3.236.57 3.236 1.22.72 3.43 4.086 7.43 8.163v-4.883h-.44c-.43 0-.77-.574-.77-1 0-.426.34-1 .77-1H294c.427 0 .772.574.772 1 0 .426-.345 1-.77 1H294v7.646l8.23 21.087s.385 4.32-12.165 4.115c-12.55-.205-12.768-2.777-12.87-4.218l1.47-3.592c-4.058.575-7.58.512-8.733.468-2.28.086-13.57.26-20.292-4.436z"/><path d="M294 48.273v2c.427 0 .772-.574.772-1 0-.427-.345-1-.772-1h-8.435c-.426 0-.77.574-.77 1 0 .426.344 1 .77 1H286v-2h8z"/><path d="M286 48.273h8v2h-8z"/></symbol>
    </defs>
</svg>
<div class="container-general-flex">
    <div class="contenedorPrincipal">
        <div class="container">

            <header class="header-acceso acceso-asociado fila-flex">
                <div class="marca-container">
                    <a href="#">
                        <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-azul">
                            <use xlink:href="#logoMPT"></use>
                        </svg>
                    </a>
                </div> <!--.marca-container-->

                <div class="acceso-usuario-container dropdown">
                    <a id="dropdownUsuario" class="fila-flex" data-target="#" href="http://uibb.org.ar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <figure class="foto-bg foto-usuario sin-foto"></figure>
                        <h5 class="nombre-usuario"><strong>Consorcio de Gestión del Puerto de Bahía Blanca</strong></h5>
                        <button class="btn-menu-usuario">
                            <span class="sr-only">Menú usuario</span>
                            <span class="glyphicon glyphicon-menu-down"></span>
                        </button>
                    </a>
                    <ul class="dropdown-menu submenu-usuario" aria-labelledby="dropdownUsuario">
                        <li><a href="#">Ayuda y Soporte</a></li>
                        <li><a href="#" class="cerrar-sesion"><strong>Cerrar sesión</strong></a></li>
                    </ul>
                </div>
            </header>

            <nav class="nav-listado">

                <div class="row">
                    <div class="col-xs-2 col-sm-4">
                        <a id="volverListado" href="#" class="link-nav-listado texto-blanco text-left">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                            <span class="hidden-xs">Volver al listado de alumnos</span>
                        </a>
                    </div>


                    <div class="col-xs-2 col-sm-2">
                        <a id="descargarPDF" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-save"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Descargar PDF</span>
                        </a>
                    </div> <!--btn pdf-->
                    <div class="col-xs-2 col-sm-2">
                        <a id="imprimir" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-print"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Inprimir</span>
                        </a>
                    </div> <!--btn imprimir-->

                    <!--BOTONES PARA MOSTRAR UNICAMENTE EN EL BACKEND (VISTA DE LAS ESCUELAS)-->
                    <div class="col-xs-2 col-sm-2">
                        <a id="editar" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-edit"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Editar</span>
                        </a>
                    </div> <!--btn editar-->
                    <div class="col-xs-2 col-sm-2">
                        <a id="eliminar" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Eliminar</span>
                        </a>
                    </div> <!--btn eliminar-->
                </div> <!--.row-->
            </nav> <!--/.nav-listado-->

            <article class="alumno-individual">
                <header class="alumno-info-principal">

                    <div class="contenedor-foto">
                        <figure class="foto-bg foto-alumno masculino" style="background-image: url(img/foto-alumno-test.jpg);">
                            <img src="img/foto-alumno-test.jpg" alt="Gilberto Manhatan Ruiz"
                                 class="img-responsive alumno-img visible-print-block">
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

                            <section class="carta-presentacion">
                                <h5 class="subtitulo texto-azul">Carta de presentación</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam consectetur deleniti doloremque ea ipsum laboriosam magnam nam provident quos, voluptas.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium fugit minus officiis sunt temporibus? Accusantium consequuntur deserunt doloremque facilis fugiat harum libero nam, nihil odit officia repellendus unde velit voluptate.</p>
                            </section> <!--/.carta-presntacion-->
                        </main> <!--/.info-detalle-->

                </div> <!--/.fila-flex-->

            </article> <!--/.alumno-individual-->

        </div> <!--/.container-->
    </div> <!--/#contenedorPrincipal-->

    <footer class="pie-pagina">
        <div class="container">
            <div class="contenido-footer row">
                <div class="col-sm-4">
                    <div class="marca-container">
                        <a href="#">
                            <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-blanco">
                                <use xlink:href="#logoMPT"></use>
                            </svg>
                        </a>
                    </div> <!--.marca-container-->
                    <div class="mpt-by">
                        <span class="texto-servicio">un servicio de:</span>
                        <a class="logo-uibb uibb-blanco" href="http://uibb.org.ar/">Unión Industrial Bahía Blanca</a>
                    </div> <!--.mpt-by-->
                </div>
                <div class="col-sm-8">
                    <ul class="list-inline nav-list menu-principal text-right">
                        <li ><strong><a href="#">Inicio</a></strong></li>
                        <li ><strong><a href="#">Empresas</a></strong></li>
                        <li ><strong><a href="#">Instituciones Educativas</a></strong></li>
                        <li ><strong><a href="#">Contacto</a></strong></li>
                        <li ><strong><a href="#">Acceder a la plataforma</a></strong></li>
                    </ul> <!--.menu-principal-->
                    <ul class="list-inline nav-list menu-tc-pp text-right">
                        <li ><a href="#">Términos y condiciones</a></li>
                        <li ><a href="#">Políticas de privacidad</a></li>
                    </ul> <!--.menu-tc-pp-->
                </div>
            </div> <!--.contenido-footer-->

            <div class="subfooter row">
                <div class="col-sm-6">
                    <p class="copy text-left">Copyright: <strong><a
                            href="http://uibb.org.ar/">Unión Industrial
                        Bahía Blanca</a> &copy;2016</strong></p>
                </div>
                <div class="col-sm-6">
                    <p class="imotion text-right">Diseño y desarrollo: <strong><a
                            href="http://www.imotionconsulting.com.ar">Imotion
                        Consulting</a></strong></p>
                </div>
            </div> <!--.subfooter-->
        </div> <!--.container-->
    </footer>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>

<script src="js/main.js"></script>
</body>
</html>
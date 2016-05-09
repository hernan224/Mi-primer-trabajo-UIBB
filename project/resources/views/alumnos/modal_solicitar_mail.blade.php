{{-- MODAL PARA SOLICITAR MAIL CON TODA LA INFO DE ALUMNO --}}
<div class="modal estilo-modal-bg fade" id="solicitarContacto" tabindex="-1" role="dialog" aria-labelledby="solicitarContacto">
    <div class="modal-dialog">
        <div class="modal-content estilo-modal-container">
            <div class="modal-header">
                <a href="#" class="btn-cerrar close" data-dismiss="modal" aria-label="Close">Cerrar</a>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title texto-azul">Solicitar información de contacto</h4>
            </div>
            <div class="modal-body formulario">
                <p>Por cuestiones de privacidad los datos de contacto de este alumno se los enviaremos por mail.</p>
                <p>Por favor, complete los siguientes campos para poder recibir la información solicitada.</p>
                <form action="{{ route('alumno_solicitar',['id' => $alumno_id]) }}" role="form"
                      class="solicitar-form form-mpt form-invertido">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="sr-only input-label small" for="nombre">Nombre y Apellido</label>
                        <input type="text" class="form-control" name="nombre"
                               id="nombre" placeholder="Nombre y Apellido" required>
                    </div>

                    <div class="form-group">
                        <label class="sr-only input-label small" for="empresa">Empresa</label>
                        <input type="text" class="form-control" name="empresa"
                               id="empresa" placeholder="Empresa" >
                    </div>

                    <div class="form-group">
                        <label class="sr-only input-label small" for="email">Email</label>
                        <input type="email" class="form-control" name="email"
                               id="email" placeholder="Email" required>
                    </div>

                    <p class="error">
                        Ocurrió un error, los datos no pudieron ser enviados.
                        <span class="mensaje"></span>
                        <br>
                        Por favor, revise los datos ingresados, e intente enviar de nuevo.
                    </p>
                </form>
                <div class="modal-footer">
                    <button id="solicitar-datos-alumno" type="button" class="btn btn-primary">Enviar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar
                    </button>
                </div>
            </div>
            <div class="modal-body post-ok">
                <p>Los datos fueron enviados correctamente, revise su casilla de email.</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
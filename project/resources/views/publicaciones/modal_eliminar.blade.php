{{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN DE ALUMNO --}}
<div class="modal estilo-modal-bg fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminar">
    <div class="modal-dialog">
        <div class="modal-content estilo-modal-container">
            <div class="modal-header">
                <a href="#" class="btn-cerrar close" data-dismiss="modal" aria-label="Close">Cerrar</a>
                <h4 class="modal-title texto-azul">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que quiere eliminar esta nota informativa?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                @if (isset($publicacion))
                    <a href="{{ route('publicaciones.publicacion_delete',['id'=> $publicacion->id])}}" class="btn btn-primary">SI</a>
                @else
                    <button type="button" class="btn btn-primary" id="confirmar-eliminar">SI</button>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-dialog modal-lg" role="document" style="max-width: 50%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">Observación</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <h5>Añadir observación</h5>
            <form action="" class="form">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="id_inventario" id="id_inventario" value="{{ $id }}" />
                <div class="input-group">
                    <textarea name="observacion" id="observacion" cols="5" rows="5" class="form-control">{{ $inv->observacion != NULL ?  $inv->observacion : ''}}</textarea>                    
                </div>
            </form>
            <br />
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-outline-success" id="btn_store_obs" onclick="btnStoreObs()">Guardar</button>
        </div>
    </div>
</div>
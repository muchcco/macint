<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Añadir archivo TXT </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <h5>Documentos Adjuntos</h5>
            <form action="" class="form">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <input type="file" class="form-control" name="txt_file" id="txt_file">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger " data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" onclick="btnStoreTxt()">Guardar</button>
        </div>
    </div>
</div>
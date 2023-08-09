<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Añadir asesor de servicio</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <h5>Agregar datos</h5>
            <form class="form-horizontal">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Nombres</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombres">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Apellido Paterno</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="ap_pat" id="ap_pat" placeholder="Apellido Paterno">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Apellido Materno</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="ap_mat" id="ap_mat" placeholder="Apellido Materno">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">DNI</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI" onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Entidad</label>
                    <div class="col-9">
                        <select id="entidad" name="entidad" class="form-select">
                            <option disabled selected>-- Seleccione una opción --</option>
                            @forelse ($entidad as $e)
                                <option value="{{ $e->id }}">{{ $e->nombre }}</option>                                
                            @empty
                                <option value="">No hay conexón</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Sexo</label>
                    <div class="col-9">
                        <select id="sexo" name="sexo" class="form-select">
                            <option value="0">Mujer</option>
                            <option value="1">Hombre</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-3 col-form-label">Teléfono</label>
                    <div class="col-9">
                        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" onkeypress="return isNumber(event)">
                    </div>
                </div>  
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger " data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-outline-success" id="btnEnviarForm" onclick="btnStoreAsesor()">Guardar</button>
        </div>
    </div>
</div>
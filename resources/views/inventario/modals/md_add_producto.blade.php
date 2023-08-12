<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
    <div class="modal-content" >
        <div class="modal-header">
            <h4 class="modal-title">Añadir archivo TXT </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <h5>Documentos Adjuntos</h5>
            <form action="" class="form">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                <div class="input-group">
                    <input type="text" name="cod_pronsace" id="cod_pronsace" class="form-control">
                    <button class="btn btn-primary" type="button" onclick="Buscar()" >Buscar</button>
                </div>
            </form>
            <br />
            <div class="table-show" id="table-show" style="display: none">
                <table class="table" id="table_det_asig">
                    <thead>
                        <tr>
                            <th>Cod. pronsace</th>
                            <th>Descripcion</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie / Medida</th>
                        </tr>
                    </thead>
                    <tbody id="table_det_asig_body">
                        
                    </tbody>                
                </table>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" onclick="btnStoreTxt()">Guardar</button>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    table_det_asig();
});

var tabla = $("#table_det_asig").DataTable();
var table_det_asig = () => {
    $.ajax({
        type: 'get',
        url: "{{ route('inventario.tablas.tb_add_producto') }}" ,
        dataType: "json",
        // data: {_token: "{{ csrf_token() }}"},
        success: function(data){
            tabla.destroy();
            $("#table_det_asig_body").html(data.html);
            tabla = $("#table_det_asig").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": false,
                language: {"url": "{{ asset('js/Spanish.json')}}"}, 
                "columns": [
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },                
                    { "width": "" }
                ]
            });
        },
        error: function(){
            console.log("error");
            // location.reload();
        }
    });
}

var Buscar = () => {

    document.getElementById("table-show").style.display = "block";

    var cod_pronsace = $('#cod_pronsace').val();

    table_det_asig(cod_pronsace);
    console.log("termino de cargar")

}

</script>
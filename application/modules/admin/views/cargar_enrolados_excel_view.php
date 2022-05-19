<div class="row-fluid">
    <h1>
        <center>CARGAR SUJETOS DESDE EXCEL</center>
    </h1>
</div>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/enrolamiento/get_sujetos_excel",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    //console.log(response); 
                    let respuesta = response;
                    var tabla = "";
                    console.log(respuesta);
                    for (ind in respuesta) {
                        var fila = "<tr>";
                        if (respuesta[ind].estado == "0") {

                            fila += "<td>" + respuesta[ind].id + "</td>";
                            fila += "<td>" + respuesta[ind].nombres + "</td>";
                            fila += "<td>" + respuesta[ind].apellidos + "</td>";
                            fila += "<td>" + respuesta[ind].dni + "</td>";
                            fila += "<td>" + respuesta[ind].cargo + "</td>";
                            fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                            fila += "<td style='text-align:center'><a href='admin/enrolamiento/vincular_sujeto_x/" + respuesta[ind].dni + "'class='btn btn-warning'>Vincular</a></td>";
                        } else {
                            fila += "<td>" + respuesta[ind].id + "</td>";
                            fila += "<td>" + respuesta[ind].nombres + "</td>";
                            fila += "<td>" + respuesta[ind].apellidos + "</td>";
                            fila += "<td>" + respuesta[ind].dni + "</td>";
                            fila += "<td>" + respuesta[ind].cargo + "</td>";
                            fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                            fila += "<td><h4><span class='label label-success'>Vinculado</span></h4></td>";
                        }

                        fila += "</tr>";
                        tabla += fila;
                    }
                    $("#cuerpo").html(tabla);

                    $("#tbl_excel").DataTable({
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay datos en la tabla",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                            "infoFiltered": "(filtrando de _MAX_ total de entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "No se encontraron registros coincidentes",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "aria": {
                                "sortAscending": ": Activar para ordenar la columna ascendente",
                                "sortDescending": ": Activar para ordenar la columna Descendente"
                            }
                        }
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (textStatus === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error: ' + jqXHR.responseText);
                }
            });
        }
        repetir();
    });
</script>
<br>
<br>
<br>

<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-blue">
                <div class="panel-heading">
                    <h4>Formulario para Cargar Sujetos desde un archivo excel</h4>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="admin/enrolamiento/cargar_sujetos_excel" method="POST" id="form_cargar">
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubigeo</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubigeo" id="ubigeo">
                                    <option value="">Elegir</option>
                                    <?php foreach ($ubigeo as $indice => $zona)
                                        foreach ($zona as $indice => $valor) : ?>
                                        <option value="<?php echo $valor; ?>"><?php echo $valor ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group row gutter">
                        <label for="inputEmail3" class="col-sm-2 control-label">Seleccionar Archivo</label>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <input type="file" class="filestyle" data-buttonText="Seleccione archivo" name="excel">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <input class="btn btn-warning btn-file" type='submit' name='enviar' value="Importar" />
                            </div>
                            <input type="hidden" value="upload" name="action" />
                            <input type="hidden" value="usuarios" name="mod">
                            <input type="hidden" value="masiva" name="acc">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4>EDICIÓN DE ACTIVOS MATRICULADOS</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_excel" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">NOMBRES</th>
                                <th style="text-align:center">APELLIDOS</th>
                                <th style="text-align:center">DNI</th>
                                <th style="text-align:center">CARGO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">VINCULAR</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
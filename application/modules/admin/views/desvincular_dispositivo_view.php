<div class="row-fluid">
    <h1>
        <center>DESVINCULACION DISPOSITIVO RFID</center>
    </h1>
</div>
<br>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/dispositivo_rfid/get_dispositivo_rfid",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    var respuesta = response.data;
                    var tabla = "";
                    // FECHA EN JQUERY
                    var d = new Date();
                    var month = d.getMonth() + 1;
                    var day = d.getDate();
                    var fecha_actual = d.getFullYear() + '-' +
                        (('' + month).length < 2 ? '0' : '') + month + '-' +
                        (('' + day).length < 2 ? '0' : '') + day;
                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].id + "</td>";
                        fila += "<td>" + respuesta[ind].mac + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                        fila += "<td>" + respuesta[ind].actividad + "</td>";
                        fila += "<td>" + respuesta[ind].usuario + "</td>";
                        fila += "<td>" + respuesta[ind].date + "</td>";
                        if (respuesta[ind].estado == "1") {
                            fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inve='" + respuesta[ind].id_device + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>DESVINCULAR DISPOSITIVO</button></a></td>";
                        }
                        fila += "</tr>";
                        tabla += fila;
                    }

                    $("#cuerpo").html(tabla);
                    $("#tbl_vinculacion").DataTable({
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
                    // LLAMO A MODAL ELIMINAR
                    //$('.boton_eliminar').click(function() {
                    $("body").on("click", ".boton_eliminar", function() {
                        //$('#miModal').modal('show'); //<-- you should use show in this situation
                        $('#miModal').modal();
                        var cod_inve = $(this).attr('cod_inve');
                        $('.eliminar').attr('href', 'admin/dispositivo_rfid/eliminar/' + cod_inve);
                    });
                }
            });
        }
        repetir();
    });
</script>
<!--PARA VER ERRORES-->
<!--<pre>
	<?php
    echo print_r($codigo);
    ?>
    </pre>-->
<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-facebook">
                <div class="panel-heading">
                    <h4>Tabla de Dispositivos Asignados</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">MAC</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACION</th>
                                <th style="text-align:center">ACTIVIDAD</th>
                                <th style="text-align:center">USUARIO</th>
                                <th style="text-align:center">FECHA DE ASIGNACION</th>
                                <th style="text-align:center">DESVINCULAR</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--    MODAL ELIMINAR-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>¿Desea desvincular el Dispositivo RFID?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary eliminar">Desvincular</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
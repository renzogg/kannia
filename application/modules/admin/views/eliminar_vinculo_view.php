<div class="row-fluid">
    <h1>
        <center>SALIDA PROGRAMADA DE ACTIVOS MATRICULADOS</center>
    </h1>
</div>
<br>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/vinculacion/get_activos_matriculados_fecha_salida",
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
                        fila += "<td>" + respuesta[ind].item + "</td>";
                        fila += "<td>" + respuesta[ind].cod_producto + "</td>";
                        fila += "<td>" + respuesta[ind].cod_rfid + "</td>";
                        fila += "<td>" + respuesta[ind].descripcion + "</td>";
                        fila += "<td>" + respuesta[ind].guia_remision + "</td>";
                        fila += "<td>" + respuesta[ind].date + "</td>";
                        if (respuesta[ind].programacion == "1") {
                            fila += "<td>" + respuesta[ind].fecha_salida + "</td>";
                            fila += "<td>" + respuesta[ind].orden_salida + "</td>";
                            if (respuesta[ind].fecha_salida != fecha_actual ) {
                                fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' disabled cod_inve='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Dar SALIDA</button></a></td>";
                            }
                            else{
                                fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inve='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Dar SALIDA</button></a></td>";
                            }
                        } else {
                            fila += "<td><span class = 'label label-warning'>NO PROGRAMADO</span></td>";
                            fila += "<td><span class = 'label label-warning'>NO TIENE ORDEN</span></td>";
                            fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-warning boton_eliminar' cod_inve='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Dar SALIDA</button></a></td>";
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
                        $('.eliminar').attr('href', 'admin/vinculacion/eliminar/' + cod_inve);
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
                    <h4>Tabla de Vinculación de Activos</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table success table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">GUÍA DE REMISIÓN</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">FECHA DE SALIDA PROGRAMADA</th>
                                <th style="text-align:center">ORDEN DE SALIDA</th>
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
                    <h4>¿Desea dar salida al activo?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary eliminar">Dar Salida</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
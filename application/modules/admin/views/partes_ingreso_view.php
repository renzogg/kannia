<div class="row-fluid">
    <h1>
        <center>PARTES DE INGRESO</center>
    </h1>
</div>
<br>
<style>
    .PISO {background-color: Palegreen !important;}
    .MUESTRA {background-color: #FAEF48 !important;}
    .ZOCALO {background-color: #fcf75e !important;}
    .PLLSA {background-color: lightcoral !important;}
    .SUBSUELO {background-color: chocolate !important;}
    .PERGO {background-color: #48DEFA !important;}
    .PERFIL {background-color: rosybrown !important;}
    .CINTA {background-color: #3492ae !important;}
    .SELLADOR {background-color: aquamarine !important;}
    .ESPUMA {background-color: #db9b88 !important;}
</style>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/inventario/get_parte_ingreso",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var respuesta = response.data;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].item + "</td>";
                        fila += "<td>" + respuesta[ind].correlativo + "</td>";
                        fila += "<td>" + respuesta[ind].cliente + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                        fila += "<td>" + respuesta[ind].guia_remision + "</td>";
                        fila += "<td>" + respuesta[ind].nro_dua + "</td>";
                        fila += "<td>" + respuesta[ind].jefe_almacen + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_parte + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_ingreso + "</td>";
                        fila += "<td>" + respuesta[ind].total_items + "</td>";
                        fila += "<td style='text-align:center'><a href='admin/inventario/ver_items/" + respuesta[ind].correlativo + "' class='btn btn-warning'>VER ITEMS</a></td>";
                        fila += "<td style='text-align:center'><a href='admin/inventario/editar_parte_ingreso/" + respuesta[ind].id + "'class='btn btn-success'>Editar</a></td>";
                        fila += "<td style='text-align:center'><a data-target='#miModalEliminar' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].correlativo +"'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
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
                }
            });
        }
        repetir();
       // LLAMO A MODAL ELIMINAR
    $("body").on("click", ".boton_eliminar", function() {
        //$('#miModal').modal('show'); //<-- you should use show in this situation
        $('#miModalEliminar').modal();
        var cod_inventario = $(this).attr('cod_inventario');
        $('.eliminar').attr('href', 'admin/inventario/eliminar_parte_ingreso/' + cod_inventario);
    });
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
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4>PARTES DE INGRESO CARGADOS EN EL SISTEMA</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CORRELATIVO</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACION</th>
                                <th style="text-align:center">GUÍA DE REMISIÓN</th>
                                <th style="text-align:center">NRO DUA</th>
                                <th style="text-align:center">JEFE DE ALMACÉN</th>
                                <th style="text-align:center">FECHA DE PARTE</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">TOTAL ITEMS</th>
                                <th style="text-align:center">VINCULACIÓN MASIVA</th>
                                <th style="text-align:center">EDITAR</th>
                                <th style="text-align:center">ELIMINAR</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--    MODAL CONFIRMAR ELIMINAR PARTE DE INGRESO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModalEliminar" style="max-width: inherit;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>¿Desea eliminar el PARTE DE INGRESO seleccionado?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary eliminar">Eliminar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
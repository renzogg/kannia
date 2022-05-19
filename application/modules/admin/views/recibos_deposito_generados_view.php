<div class="row-fluid">
    <h1>
        <center>HISTORIAL DE RECIBOS DE DEPÓSITO GENERADOS</center>
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
                url: "admin/inventario_tiempo_real/get_detalles_recibo",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    var respuesta = response;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        fila += "<td>" + respuesta[ind].id + "</td>";
                        fila += "<td>" + respuesta[ind].correlativo + "</td>";
                        fila += "<td>" + respuesta[ind].cliente + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                        fila += "<td>" + respuesta[ind].usuario + "</td>";
                        fila += "<td>" + respuesta[ind].jefe_almacen + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_finalizacion + "</td>";
                        if(respuesta[ind].status == "0"){
                            fila += "<td class='filaProgramada'><span class = 'label label-warning'>FINALIZADO</span></td>";
                        }
                        fila += "<td style='text-align:center'><a href='admin/inventario_tiempo_real/recibo_nro/" + respuesta[ind].correlativo + "'class='btn btn-info'>VER RECIBO GENERADO</a></td>";
                        fila += "<td style='text-align:center'><a href='admin/reporte/reporte_recibo_deposito/" + respuesta[ind].correlativo + "'class='btn btn-success'>PDF</a></td>";
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
                    <h4>DETALLE DE RECIBOS DE DEPÓSITOS GENERADOS</h4>
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
                                <th style="text-align:center">USUARIO</th>
                                <th style="text-align:center">JEFE DE ALMACÉN</th>
                                <th style="text-align:center">FECHA DE FINALIZACIÓN</th>
                                <th style="text-align:center">STATUS</th>
                                <th style="text-align:center">VER DETALLES</th>
                                <th style="text-align:center">EXPORTAR PDF</th>
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
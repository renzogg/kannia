<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/vinculacion/get_salida_activos_matriculados",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    var respuesta = response.data;
                    var tabla = "";
                    console.log(response)
                    for (ind in respuesta) {
                        var fila = "<tr>";

                        fila += "<td>" + respuesta[ind].id + "</td>";
                        fila += "<td>" + respuesta[ind].cod_producto + "</td>";
                        fila += "<td>" + respuesta[ind].cod_rfid + "</td>";
                        fila += "<td>" + respuesta[ind].descripcion + "</td>";
                        fila += "<td>" + respuesta[ind].item + "</td>";
                        fila += "<td>" + respuesta[ind].guia_remision + "</td>";
                        fila += "<td>" + respuesta[ind].orden_salida + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_ingreso + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_salida + "</td>";

                        fila += "</tr>";
                        tabla += fila;
                    }
                    $("#cuerpo").html(tabla);

                    $("#tbl_temperature").DataTable({
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
<!-- 

<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">ACTIVOS MATRICULADOS</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div> -->


<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4> VER SALIDA DE ACTIVOS MATRICULADOS</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">ITÉM</th>
                                <th style="text-align:center">GUÍA DE REMISIÓN</th>
                                <th style="text-align:center">ORDEN DE SALIDA</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">FECHA DE SALIDA</th>
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
<link rel="stylesheet" href="./dist/styles.css">
<link rel="stylesheet" href="./dist/all.css">
<div class="row-fluid">
</div>
<br>
<script>
    $(document).ready(function() {
        var table = $('#tbl_movimientos').DataTable({
            responsive: true,
            "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
                title: 'Inventario RFID - Tiempo Real'
            }],
            "ajax": {
                url: "<?php echo site_url('admin/inventario_tiempo_real/get_recibo_deposito/'.$correlativo); ?>",
                type: "post"
            },
            "columns": [
                {"data": "id"},
                {"data": "guia_remision"},
                {"data": "correlativo"},
                {"data": "item"},
                {"data": "cod_producto"},
                {"data": "cod_rfid"},
                {"data": "descripcion"},
                {"data": "familia_producto"},
                {"data": "ubigeo"},
                {"data": "ubicacion"},
                {"data": "date"}
            ],
            "bdestroy": true,
            "rowCallback": function(row, data, index) {
                if (data['fecha_lectura'] != "") {
                    $('td', row).css('background-color', 'Palegreen');
                    document.getElementById("caja_encontrados").textContent = data['c_encontrados'];
                    document.getElementById("caja_no_encontrados").textContent = data['c_no_encontrados'];
                    document.getElementById("total_activos").textContent = data['total_activos'];
                } else {
                    $('td', row).css('background-color', '#ffa19b');
                    document.getElementById("caja_no_encontrados").textContent = data['c_no_encontrados'];
                    document.getElementById("total_activos").textContent = data['total_activos'];
                }
            },
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
    });
</script>
<div>
    <!-- Stats Row Starts Here -->
    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
        <div class="shadow-lg bg-red-vibrant border-l-8 hover:bg-red-vibrant-dark border-red-vibrant-dark mb-2 p-2 md:w-1/4 mx-2">
            <div class="p-4 flex flex-col">
                <a id="caja_no_encontrados" href="#" class="no-underline text-white text-2xl">

                </a>
                <a href="#" class="no-underline text-white text-lg">
                    NO ENCONTRADOS
                </a>
            </div>
        </div>

        <div class="shadow bg-info border-l-8 hover:bg-info-dark border-info-dark mb-2 p-2 md:w-1/4 mx-2">
            <div class="p-4 flex flex-col" name="total_activos">
                <a id="total_activos" href="#" class="no-underline text-white text-2xl">

                </a>
                <a href="#" class="no-underline text-white text-lg">
                    TOTAL DE ACTIVOS
                </a>
            </div>
        </div>

        <div class="shadow bg-warning border-l-8 hover:bg-warning-dark border-warning-dark mb-2 p-2 md:w-1/4 mx-2">
            <div class="p-4 flex flex-col">
                <a href="#" class="no-underline text-white text-2xl">

                </a>
                <a href="#" class="no-underline text-white text-lg">
                    INVENTARIO TIEMPO REAL
                </a>
            </div>
        </div>

        <div class="shadow bg-success border-l-8 hover:bg-success-dark border-success-dark mb-2 p-2 md:w-1/4 mx-2">
            <div class="p-4 flex flex-col">
                <a id="caja_encontrados" href="#" class="no-underline text-white text-2xl">

                </a>
                <a href="#" class="no-underline text-white text-lg">
                    ACTIVOS LEIDOS
                </a>
            </div>
        </div>
    </div>
    <!-- /Stats Row Ends Here -->
</div>
<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--INICIO PANEL AZUL QUE ENGLOBA TODO (TABLA, PANELES, BOTONES)-->
            <div class="panel panel-light panel-facebook">
                <!--INICIO PANEL AZUL DONDE VA TITULO DE TABLA-->
                <div class="panel-heading">
                    <h4>Tabla RECIBO DE DEPÓSITO GENERADO - REAL TIME</h4>

                </div>
                <!--FIN DE PANEL AZUL-->

                <!--INICIO PANEL DONDE VA TABLA-->
                <div class="panel-body table-responsive">
                    <!--INICIO TABLA-->
                    <table class="table danger table-striped no-margin text-center" id="tbl_movimientos" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ID</th>
                                <th style="text-align:center">GUÍA DE REMISIÓN</th>
                                <th style="text-align:center">PARTE DE INGRESO</th>
                                <th style="text-align:center">ITÉM</th>
                                <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">FAMILIA DE PRODUCTO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACIÓN</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                    <!--FIN DE TABLA-->
                </div>
                <!--FIN DE PANEL AZUL-->
            </div>
            <!--FIN DE PANEL-->
        </div>
</div>
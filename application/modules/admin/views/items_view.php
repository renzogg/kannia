<div class="row-fluid">
    <h1>
        <center>ITEMS DEL PARTE DE INGRESO CARGADO</center>
    </h1>
</div>

<script>
    $(document).ready(function() {
      var table = $('#tbl_excel').DataTable({
         responsive: true,
         "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
            title: 'Cargar Parte de Ingreso desde Excel'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/inventario/ver_items_parte_ingreso/'.$correlativo); ?>",
            type: "post"
         },
         "columns": [
             {"data": "id"},
             {"data": "item"},
             {"data": "nro_dua"},
             {"data": "guia_remision"},
             {"data": "correlativo"},
             {"data": "ubigeo"},
             {"data": "ubicacion"},
             {"data": "codigo"},
             {"data": "cliente"},
             {"data": "familia_producto"},
             {"data": "descripcion"},
             {"data": "cantidad"},
             {"data": "unidad_medida"},
             {"data": "fecha_ingreso"},
             {"data": "fecha_parte"},
             {"data": "jefe_almacen"},
             {"data": null,
                "render": function(data,type,row){
                  if(data['observaciones'] == ""){
                    return '<h4><span class="label label-warning">Sin Observaciones</span></h4>';
                  }
                  else{
                    return data['observaciones'];
                  }
               }
             },
             {"data": null,
               "render": function(data,type,row){
                  if(data['estado_items'] == "1"){
                    return '<button class="btn btn-info"><a href="admin/vinculacion/vinculacion_masiva_tags/' + data['item'] + '/' + data['correlativo'] + '">VINCULACIÓN MASIVA</a></button>';
                  }
                  else{
                    return '<h4><span class="label label-success">VINCULACIÓN MASIVA COMPLETADA</span></h4>';
                  }
               }
            }
         ],
         "bdestroy": true,
         "rowCallback": function(row, data, index) {
                if (data['familia_producto'] == "ZOCALO") {
                    $('td', row).css('background-color', '#fcf75e');
                }else if(data['familia_producto'] == "MUESTRA"){
                    $('td', row).css('background-color', '#FAEF48');
                }else if(data['familia_producto'] == "SUBSUELO"){
                    $('td', row).css('background-color', 'chocolate');
                }else if(data['familia_producto'] == "PERGO"){
                    $('td', row).css('background-color', '#48DEFA');
                }else if (data['familia_producto'] == "PERFIL"){
                    $('td', row).css('background-color', 'rosybrown');
                }else if(data['familia_producto'] == "PISO"){
                    $('td', row).css('background-color', 'Palegreen');
                }else if(data['familia_producto'] == "CINTA"){
                    $('td', row).css('background-color', '#3492ae');
                }else if(data['familia_producto'] == "SELLADOR"){
                    $('td', row).css('background-color', 'aquamarine');
                }else if(data['familia_producto'] == "ESPUMA"){
                    $('td', row).css('background-color', '#db9b88');
                }else if(data['familia_producto'] == "SILENT"){
                    $('td', row).css('background-color', '#C8635B');
                }else if(data['familia_producto'] == "TRANSITSTOP"){
                    $('td', row).css('background-color', '#55A89F');
                }else if (data['familia_producto'] == "PLLSA") {
                 $('td', row).css('background-color', '#DA7C46');
                 $('td', row).css('color', '#FFFFFF');
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
<br>
<br>
<br>

<div class="main-container">
    <div class="col-sm-3"></div>
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4>ITEMS DEL PARTE DE INGRESO CARGADO EN EXCEL</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_excel" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ID</th>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">N° DUA</th>
                                <th style="text-align:center">GUIA DE REMISIÓN</th>
                                <th style="text-align:center">CORRELATIVO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACIÓN</th>
                                <th style="text-align:center">CÓDIGO</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">FAMILIA PRODUCTO</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">CANTIDAD</th>
                                <th style="text-align:center">UNIDAD DE MEDIDA</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">FECHA DE PARTE</th>
                                <th style="text-align:center">JEFE DE ALMACÉN</th>
                                <th style="text-align:center">OBSERVACIONES</th>
                                <th style="text-align:center">VINCULACIÓN</th>
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
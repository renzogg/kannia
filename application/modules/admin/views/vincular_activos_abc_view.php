<div class="row-fluid">
    <h1>
        <center>VINCULACIÓN AUTOMATICA 1x1</center>
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
            title: 'vINCULACIÓN AUTOMÁTICA'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/inventario/get_activos_abc'); ?>",
            type: "post"
         },
         "columns": [
            {"data": "indice"},
            {"data": "nro_dam"},
            {"data": "guia_remision"},
            {"data": "nro_operacion"},
            {"data": "item"},
            {"data": "codigo"},
            {"data": "ubigeo"},
            {"data": "ubicacion"},
            {"data": "cliente"},
            {"data": "familia_producto"},
            {"data": "descripcion"},
            {"data": "cantidad"},
            {"data": "unidad_medida"},
            {"data": null,
               "render": function(data,type,row){
                  if(data['estado'] == "0"){
                    return '<button class="btn btn-warning"><a href="admin/vinculacion/vincular_activo_x/' + data['id'] + '">vincular</a></button>';
                  }
                  else{
                    return '<h4><span class="label label-success">Vinculado</span></h4>';
                  }
               }
            }
         ],
         "bdestroy": true,
         "rowCallback": function(row, data, index) {
                if (data['familia_producto'] == "ZOCALO") {
                    $('td', row).css('background-color', '#fcf75e');
                }else if(data['familia_producto'] == "VERSA"){
                    $('td', row).css('background-color', '#0096d2');
                }else if(data['familia_producto'] == "SILENT"){
                    $('td', row).css('background-color', 'lightcoral');
                }else if(data['familia_producto'] == "SUBSUELO"){
                    $('td', row).css('background-color', 'chocolate');
                }else if(data['familia_producto'] == "TRANSISTOP"){
                    $('td', row).css('background-color', 'yellow');
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

      //LLENAR SELECT A PARTIR DE OTRO SELECT
      var ubicacion = $('#ubicacion');
      $("#ubigeo").change(function() {
         console.log("chris")
         var ubigeo = $(this).val(); //obtener el id seleccionado
         if (ubigeo != "") { //verificar haber seleccionado una opcion valida
            /*Inicio de llamada ajax*/
            $.ajax({
               url: '<?php echo site_url('admin/inventario/listar_ubicaciones'); ?>', //url que recibe las variables
               data: {
                  ubigeo: $("#ubigeo").val()
               }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
               type: "post", //mandar variables como post o get
               dataType: "JSON", //tipo de datos que esperamos de regreso
               success: function(response) {
                  console.log(response);
                  $("#ubicacion").html('');
                  $("#ubicacion").append(new Option('---SELECCIONAR UBICACION---', 0));
                  ubicacion.prop('disabled', false); //habilitar el select
                  if (response != '') {
                     for (ind in response) {
                        $("#ubicacion").append(new Option(response[ind]["ubicacion"]), response[ind]["ubicacion"]);
                     }
                  }
               }
            });
            /*fin de llamada ajax*/
         } else {
            alert("Eliga el Ubigeo");
            ubicacion.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            ubicacion.prop('disabled', true); //deshabilitar el select
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
                    <h4>MATRICULA AUTOMÁTICA DE ACTIVOS CARGADOS DESDE EXCEL -1x1</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_excel" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">N° DAM</th>
                                <th style="text-align:center">GUIA DE REMISIÓN</th>
                                <th style="text-align:center">N° OPERACIÓN</th>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACIÓN</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">FAMILIA PRODUCTO</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">CANTIDAD</th>
                                <th style="text-align:center">UNIDAD DE MEDIDA</th>
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
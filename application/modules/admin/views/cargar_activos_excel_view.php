<div class="row-fluid">
    <h1>
        <center>CARGAR ACTIVOS DESDE EXCEL</center>
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
            title: 'Cargar Activos desde Excel'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/inventario/get_activos_excel'); ?>",
            type: "post"
         },
         "columns": [
            {"data": "id"},
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
            {"data": "unidad_medida"}
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
   // MODAL DE LIMPIAR TABLA
    $("body").on("click", ".btn_reiniciar", function() {
        //$('#miModal').modal('show'); //<-- you should use show in this situation
        $('#miModal').modal();
        $('.reiniciar').attr('href', 'admin/inventario/limpiar_tabla');
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
                    <h4>Formulario para Cargar Activos desde un archivo excel</h4>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="admin/inventario/cargar_activos_excel" method="POST" id="form_cargar">
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Cliente</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="cliente" id="cliente">
                                    <option value="">Elegir</option>
                                    <?php foreach ($clientes as $indice => $cliente)
                                        foreach ($cliente as $tipo => $valor) : ?>
                                        <option value="<?php echo $valor; ?>"><?php echo $indice . "." . $valor ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('cliente', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
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
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubicacion" id="ubicacion" disabled>
                                    <option value="">Elegir</option>
                                </select>
                                <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group row gutter">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <input type="file" class="filestyle" data-buttonText="Seleccione archivo" name="excel">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <input class="btn btn-default btn-file" type='submit' name='enviar' value="Importar" />
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
                    <h4>MATRICULA DE ACTIVOS CARGADOS DESDE EXCEL</h4>
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
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- BOTON LIMPIAR TABLA EXCEL-->
        <div style="float: right; width: 225px">
            <a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_reiniciar">Limpiar tabla excel</button></a>
        </div>
        <!--FIN DE BOTON-->
    </div>
      <!--    MODAL CONFIRMAR LIMPIAR TABLA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModal" style="max-width: inherit;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>¿Desea Limpiar los registros de la tabla?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary reiniciar">Limpiar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script>
    $(document).ready(function() {
      var table = $('#tbl_inventario').DataTable({
         responsive: true,
         "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
            title: 'Edición - Eliminar ACTIVOS RFID'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/inventario/get_activos_vinculados_excel'); ?>",
            type: "post"
         },
         "columns": [
            {"data": "indice"},
            {"data": "nro_dua"},
            {"data": "guia_remision"},
            {"data": "correlativo"},
            {"data": "item"},
            {"data": "codigo"},
            {"data": "codigo_rfid"},
            {"data": "ubigeo"},
            {"data": "ubicacion"},
            {"data": "cliente"},
            {"data": "familia_producto"},
            {"data": "descripcion"},
            {"data": "cantidad"},
            {"data": "unidad_medida"},
            {"data": "fecha_vinculacion"},
            {"data": null,
               "render": function(data,type,row){
                    return '<td style="text-align:center"><input type="checkbox" style="width:20px;height:20px;"id="elegido" name="elegido[]" value="' + data["id"] + '"></td>';
               }
            }
         ],
         "bdestroy": true,
         "rowCallback": function(row, data, index) {
            if (data['familia_producto'] == "ZOCALO") {
               $('td', row).css('background-color', '#fcf75e');
            } else if (data['familia_producto'] == "VERSA") {
               $('td', row).css('background-color', '#0096d2');
            } else if (data['familia_producto'] == "SILENT") {
               $('td', row).css('background-color', 'lightcoral');
            } else if (data['familia_producto'] == "SUBSUELO") {
               $('td', row).css('background-color', 'chocolate');
            } else if (data['familia_producto'] == "TRANSISTOP") {
               $('td', row).css('background-color', 'yellow');
            } else if (data['familia_producto'] == "PERFIL") {
               $('td', row).css('background-color', 'rosybrown');
            } else if (data['familia_producto'] == "PISO") {
               $('td', row).css('background-color', 'Palegreen');
            } else if (data['familia_producto'] == "CINTA") {
               $('td', row).css('background-color', '#3492ae');
            } else if (data['familia_producto'] == "SELLADOR") {
               $('td', row).css('background-color', 'aquamarine');
            } else if (data['familia_producto'] == "ESPUMA") {
               $('td', row).css('background-color', '#db9b88');
            } else if(data['familia_producto'] == "PERGO"){
               $('td', row).css('background-color', '#48DEFA');
            }  else if (data['familia_producto'] == "PLLSA") {
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
   //ENVIAR DATA CON BOTON ELIMINAR MASIVA
   $(function() {
         $("#form_eliminar").submit(function(event) {
             event.preventDefault();
             var datos = $(this).serialize(),
                 url = $(this).attr('action');
             //console.log(datos);

             $.ajax({
                 type: "POST",
                 url: "admin/vinculacion/eliminacion_masiva_activos",
                 data: datos,
                 dataType: "json",
                 success: function(resultado) {
                     jAlert(resultado.respuesta, "Mensaje");
                     //refreshTable();
                     //document.getElementById("form_eliminar").reset();
                     setTimeout(function() {
                         document.location.reload(); //Actualiza la pagina
                     }, 2000);
                 },
                 error: function(error) {
                     alert('ERROR!');
                     //                $.unblockUI();
                 }
             });
             return false; //stop the actual form post !important!
         });
     });
</script>

<!-- 
<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">EDITAR - ELIMINAR INVENTARIO</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>
 -->
 <form action="" method="POST" id="form_eliminar">
   <div class="main-container">
      <div class="row gutter">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-brown">
               <div class="panel-heading">
                  <h4>ELIMINAR DE FORMA MASIVA ACTIVO MATRICULADO</h4>
               </div>
               <div class="panel-body table-responsive">
                  <table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
                     <thead>
                        <tr>
                           <th style="text-align:center">ITEM</th>
                           <th style="text-align:center">N° DUA</th>
                           <th style="text-align:center">GUIA DE REMISIÓN</th>
                           <th style="text-align:center">N° PARTE DE INGRESO</th>
                           <th style="text-align:center">ITEM</th>
                           <th style="text-align:center">CÓDIGO</th>
                           <th style="text-align:center">CÓDIGO RFID</th>
                           <th style="text-align:center">UBIGEO</th>
                           <th style="text-align:center">UBICACIÓN</th>
                           <th style="text-align:center">CLIENTE</th>
                           <th style="text-align:center">FAMILIA PRODUCTO</th>
                           <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                           <th style="text-align:center">CANTIDAD</th>
                           <th style="text-align:center">UNIDAD DE MEDIDA</th>
                           <th style="text-align:center">FECHA DE VINCULACIÓN</th>
                           <th style="text-align:center">ELIMINAR</th>
                        </tr>
                     </thead>
                     <tbody id="cuerpo">
                  </table>
               </div>

               </tbody>
            </div>
         </div>
      </div>
      <!-- BOTON ELIMINACION MASIVA-->
         <div style="float: right; width: 225px">
                  <a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-danger boton_eliminar">Eliminar Activos Matriculados</button></a>
         </div>
         <!--FIN DE BOTON-->
   </div>
</form>
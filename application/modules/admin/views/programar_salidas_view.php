<style>
   div.relative {
      position: relative;
      left: 500px;
   }
</style>
<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/dispositivo_rfid/get_dispositivo_rfid_programacion_salida",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               var respuesta = response.data;
               var tabla = "";
               //console.log(response)
               for (ind in respuesta) {
                  var fila = "<tr>";

                  fila += "<td>" + respuesta[ind].id + "</td>";
                  fila += "<td>" + respuesta[ind].mac + "</td>";
                  fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                  fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                  fila += "<td>" + respuesta[ind].actividad + "</td>";
                  fila += "<td>" + respuesta[ind].usuario + "</td>";
                  fila += "<td>" + respuesta[ind].date + "</td>";
                  fila += "</tr>";
                  tabla += fila;
               }
               $("#cuerpo").html(tabla);

               $("#tbl_dispositivos").DataTable({
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
      //LLENAR SELECT A PARTIR DE OTRO SELECT
      var ubicacion = $('#ubicacion');
      $("#ubigeo").change(function() {
         var ubigeo = $(this).val(); //obtener el id seleccionado
         if (ubigeo != "") { //verificar haber seleccionado una opcion valida
            /*Inicio de llamada ajax*/
            $.ajax({
               url: '<?php echo site_url('admin/vinculacion/listar_ubicacion'); ?>', //url que recibe las variables
               data: {
                  ubigeo: $("#ubigeo").val()
               }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
               type: "post", //mandar variables como post o get
               dataType: "JSON", //tipo de datos que esperamos de regreso
               success: function(response) {
                  console.log(response);
                  $("#ubicacion").html('');
                  if (response != '') {
                     $("#ubicacion").append(new Option(response), response);
                  }
               }
            });
            /*fin de llamada ajax*/
         } else {
            alert("Eliga el Ubigeo");
            ubicacion.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
         }
      });
   });

   //ENVIAR DATA
   $(function() {
      $("#form_programacion").submit(function(event) {
         event.preventDefault();
         var datos = $(this).serialize(),
            url = $(this).attr('action');
         console.log(datos);
         $.ajax({
            type: "POST",
            url: "admin/vinculacion/agregar_actividad2",
            data: datos,
            dataType: "json",
            success: function(resultado) {
               //console.log(data);
               //jAlert(resultado.respuesta, "Mensaje");
               window.location.assign("admin/vinculacion/programar_salida_automatica"); //Actualiza la pagina
            },
         }).fail(function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 0) {
               alert('Not connect: Verify Network.');
            } else if (jqXHR.status == 404) {
               alert('Requested page not found [404]');
            } else if (jqXHR.status == 500) {
               alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
               alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
               alert('Time out error.');
            } else if (textStatus === 'abort') {
               alert('Ajax request aborted.');
            } else {
               alert('Uncaught Error: ' + jqXHR.responseText);
            }
         });
      });
   });
</script>

<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-blue">
            <div class="panel-heading">
               <h4>PROGRAMACIÓN DE SALIDAS DE ACTIVOS</h4>
            </div>
            <div class="panel-body">
               <form class="form-horizontal" id="form_programacion" method="post" action="<?php echo base_url('admin/vinculacion/agregar_actividad') ?>" enctype="multipart/form-data">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2 control-label">Ubigeo</label>
                     <div class="col-sm-7 ">
                        <select class="form-control" name="ubigeo" id="ubigeo" required>
                        <option value="">ELEGIR</option>
                           <?php foreach ($atributos as $indice => $sub_atributos) : ?>
                              <option value="<?php echo $atributos[$indice]['ubigeo']; ?>"><?php echo $atributos[$indice]['ubigeo']; ?></option>
                           <?php endforeach ?>
                        </select>
                        <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
                     <div class="col-sm-7 ">
                        <select class="form-control" name="ubicacion" id="ubicacion">
                           <option value=""></option>
                        </select>
                        <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                     </div>
                     <button type="submit" class="btn btn-success" id="guardar">IR A PROGRAMACIÓN DE SALIDAS</button>
                  </div>
            
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-brown">
            <div class="panel-heading">
               <h4>LISTA DE DISPOSITIVOS RFID ASIGNADOS</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_dispositivos" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">MAC</th>
                        <th style="text-align:center">UBIGEO</th>
                        <th style="text-align:center">UBICACION</th>
                        <th style="text-align:center">ACTIVIDAD</th>
                        <th style="text-align:center">USUARIO</th>
                        <th style="text-align:center">FECHA DE ASIGNACION</th>
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
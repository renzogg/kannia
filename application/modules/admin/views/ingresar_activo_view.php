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
            url: "admin/inventario/get_activos_matriculados",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               var respuesta = response;
               var tabla = "";
               //console.log(response)
               for (ind in respuesta) {
                  var fila = "<tr>";

                  fila += "<td>" + respuesta[ind].id + "</td>";
                  fila += "<td>" + respuesta[ind].cod_producto + "</td>";
                  fila += "<td>" + respuesta[ind].cod_rfid + "</td>";
                  fila += "<td>" + respuesta[ind].descripcion + "</td>";
                  fila += "<td> S/." + respuesta[ind].valor + ".00</td>";
                  fila += "<td>" + respuesta[ind].unidad_medida + "</td>";
                  fila += "<td>" + respuesta[ind].cantidad + "</td>";
                  fila += "<td>" + respuesta[ind].cliente + "</td>";
                  fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                  fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                  fila += "<td>" + respuesta[ind].ancho + " m</td>";
                  fila += "<td>" + respuesta[ind].profundidad + " m</td>";
                  fila += "<td>" + respuesta[ind].peso + " Kg</td>";
                  fila += "<td>" + respuesta[ind].lote + "</td>";
                  fila += "<td>" + respuesta[ind].orden_ingreso + "</td>";
                  fila += "<td>" + respuesta[ind].date + "</td>";
                  fila += "</tr>";
                  tabla += fila;
               }
               $("#cuerpo").html(tabla);

               $("#tbl_inventario").DataTable({
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
         console.log("fffff")
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

   //LLAMAR CHIP
   $(function() {
      let llamar_chip = function() {
         $.ajax({
            url: "admin/alerta/get_ultimo_chip",
            type: "post",
            data: {},
            dataType: "json",
            error: function(ee) {
               console.log(ee);
            },
            success: function(response) {
               console.log(response.respuesta)
               var tag = response.respuesta;

               document.getElementById("rfid").value = tag;
               // console.log(response)
               //console.log("Depurar");
            }
         });
      }
      setInterval(function() {
         llamar_chip();
      }, 1000);
   });
   //ENVIAR DATA
   $(function() {
      $("#form_vinculacion").submit(function(event) {
         event.preventDefault();
         var datos = $(this).serialize(),
            url = $(this).attr('action');
         console.log(datos);

         $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "html",
            success: function(resultado) {
               jAlert(resultado, "Mensaje");
               //refreshTable();
               document.getElementById("form_vinculacion").reset();
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



<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-brown">
            <div class="panel-heading">
               <h4>Formulario de Matrícula de Activos</h4>
            </div>
            <div class="panel-body">
               <form class="form-horizontal" id="form_vinculacion" method="post" action="<?php echo base_url('admin/inventario/guardar_activo') ?>" enctype="multipart/form-data">
                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Descripcion</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Descripcion" id="descripcion" name="descripcion" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Código de Activo</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Codigo de Barras del activo" id="codigo_sensor" name="codigo_sensor" required>
                     </div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Código RFID</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="rfid" id="rfid" name="rfid" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputEmail3" class="col-sm-2 control-label">Tipo del cliente</label>
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
                     <label for="inputPassword3" class="col-sm-2 control-label">Valor</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="valor" id="valor" name="valor" required></div>
                  </div>
                  <div class="form-group row gutter">
                     <label for="inputEmail3" class="col-sm-2 control-label">Unidad de Medida</label>
                     <div class="col-sm-7 ">
                        <select class="form-control" name="unidad_medida" id="unidad_medida">
                           <option value="">Elegir</option>
                           <option value="Empaque">Empaque</option>
                           <option value="Paquete">Paquete</option>
                           <option value="Pallet">Pallet</option>
                        </select>
                        <?php echo form_error('unidad_medida', '<span class="label label-danger	">', '</span>'); ?>
                     </div>
                  </div>
                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Cantidad</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="cantidad" id="cantidad" name="cantidad" required></div>
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
                     <button type="submit" class="btn btn-success" id="guardar">Matricular</button>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Peso</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Peso" id="peso" name="peso" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Ancho</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Ancho" id="ancho" name="ancho" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Profundidad</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Profundidad" id="profundidad" name="profundidad" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Lote</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Lote" id="lote" name="lote" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Orden de ingreso</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Orden de ingreso" id="ingreso" name="ingreso" required></div>
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
               <h4>LISTA DE ACTIVOS MATRICULADOS</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                        <th style="text-align:center">CÓDIGO RFID</th>
                        <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                        <th style="text-align:center">VALOR</th>
                        <th style="text-align:center">UNIDAD DE MEDIDA</th>
                        <th style="text-align:center">CANTIDAD</th>
                        <th style="text-align:center">CLIENTE</th>
                        <th style="text-align:center">UBIGEO</th>
                        <th style="text-align:center">UBICACION</th>
                        <th style="text-align:center">ANCHO</th>
                        <th style="text-align:center">PROFUNDIDAD</th>
                        <th style="text-align:center">PESO</th>
                        <th style="text-align:center">LOTE</th>
                        <th style="text-align:center">ORDEN DE INGRESO</th>
                        <th style="text-align:center">FECHA DE INGRESO</th>
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
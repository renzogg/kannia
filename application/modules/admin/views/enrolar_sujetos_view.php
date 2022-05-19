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
            url: "admin/enrolamiento/get_sujetos_enrolados",
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
                  fila += "<td>" + respuesta[ind].nombres + "</td>";
                  fila += "<td>" + respuesta[ind].apellidos + "</td>";
                  fila += "<td>" + respuesta[ind].dni + "</td>";
                  fila += "<td>" + respuesta[ind].codigo_rfid + "</td>";
                  fila += "<td>" + respuesta[ind].cargo + "</td>";
                  fila += "<td><img src='static/main/img/" + respuesta[ind].imagen + "' alt='Activo' width='42' height='42' style='vertical-align:bottom'>" + "</td>";
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
   });

   $(document).ready(function() {
      $('input[type="file"]').change(function(e) {
         var fileName = e.target.files[0].name;
         //alert('The file "' + fileName +  '" archivo seleccionado.');
         //console.log(fileName);
         var image = new Image();

         var src = "static/main/img/" + fileName;
         console.log(src);
         var picture = "<img src=" + src +
            " alt='Activo' width='100' height='100' style='vertical-align:bottom'>";
         console.log(picture);
         /* image.picture = picture;
         $('#image').append(image); */
         var fotito = document.getElementById("editar_image");
         fotito.innerHTML = picture;
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

               document.getElementById("codigo_rfid").value = tag;
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
         event.preventDefault(); // Evitamos que salte el enlace. 
         /* Creamos un nuevo objeto FormData. Este sustituye al 
         atributo enctype = "multipart/form-data" que, tradicionalmente, se 
         incluía en los formularios (y que aún se incluye, cuando son enviados 
         desde HTML. */
         var paqueteDeDatos = new FormData();
         /* Todos los campos deben ser añadidos al objeto FormData. Para ello 
         usamos el método append. Los argumentos son el nombre con el que se mandará el 
         dato al script que lo reciba, y el valor del dato.
         Presta especial atención a la forma en que agregamos el contenido 
         del campo de fichero, con el nombre 'archivo'. */
         paqueteDeDatos.append('imagen', $('#name_file')[0].files[0]);
         paqueteDeDatos.append('nombres', $('#nombres').prop('value'));
         paqueteDeDatos.append('apellidos', $('#apellidos').prop('value'));
         paqueteDeDatos.append('dni', $('#dni').prop('value'));
         paqueteDeDatos.append('codigo_rfid', $('#codigo_rfid').prop('value'));
         paqueteDeDatos.append('cargo', $('#cargo').prop('value'));
         paqueteDeDatos.append('ubigeo', $('#ubigeo').prop('value'));
         var destino = $(this).attr('action'); // El script que va a recibir los campos de formulario.
         /* Se envia el paquete de datos por ajax. */
         $.ajax({
            type: 'POST', // Siempre que se envíen ficheros, por POST, no por GET.
            url: "admin/enrolamiento/guardar_enrolados",
            data: paqueteDeDatos,
            dataType: "html",
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            success: function(resultado) {
               console.log(resultado)
               jAlert(resultado, "Mensaje");
               // refreshTable();
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


<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">ENROLAR SUJETO</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-blue">
            <div class="panel-heading">
               <h4>Formulario de Enrolamiento de Sujetos</h4>
            </div>
            <div class="panel-body">
               <form class="form-horizontal" id="form_vinculacion" method="post">
                   <?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">CÓDIGO RFID</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="CÓDIGO RFID" id="codigo_rfid" name="codigo_rfid" required></div>
                  </div>
                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Nombres</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Nombres" id="nombres" name="nombres" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Apellidos</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Apellidos" id="apellidos" name="apellidos" required></div>
                     <button type="submit" class="btn btn-success" id="guardar">ENROLAR</button>
                     <div class="form-group row gutter">
                        <div class="col-sm-7" id="texto" style="display:none;"></div>
                     </div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">DNI</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="DNI" id="dni" name="dni" required></div>
                  </div>

                  <div class="form-group row gutter">
                     <label for="inputPassword3" class="col-sm-2 control-label">Cargo</label>
                     <div class="col-sm-7"><input type="text" class="form-control" placeholder="Cargo" id="cargo" name="cargo" required></div>
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
                     <label for="image" class="col-sm-2 control-label" id="select_file">Subir Imagen</label>
                     <input type="file" id="name_file" class="form-control-file" name="name_file" required>
                     <div id="editar_image" class="relative" required></div>
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
               <h4>LISTA DE SUJETOS ENROLADOS</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">NOMBRES</th>
                        <th style="text-align:center">APELLIDOS</th>
                        <th style="text-align:center">DNI</th>
                        <th style="text-align:center">CÓDIGO RFID</th>
                        <th style="text-align:center">CARGO</th>
                        <th style="text-align:center">IMAGEN</th>
                        <th style="text-align:center">FECHA ENROLAMIENTO</th>
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
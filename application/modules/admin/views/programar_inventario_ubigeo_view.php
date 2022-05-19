 <!-- Required meta tags -->
 <!--       <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet"> -->
 <!--  <link rel="stylesheet" href="calendario/fonts/icomoon/style.css">
 -->
 <link rel="stylesheet" href="calendario/css/rome.css">
 <!-- Bootstrap CSS -->
 <!-- <link rel="stylesheet" href="calendario/css/bootstrap.min.css"> -->
 <link rel="stylesheet" href="static/main/css/bootstrap.min.css">
 <!-- Style -->

 <!-- <link rel="stylesheet" href="calendario/css/style.css"> -->
 <link rel="stylesheet" href="static/main/css/estilos.css">

 <style>
     .filaProgramada {
         background-color: PaleGreen !important;
     }

     .filaNoProgramada {
         background-color: rgb(244, 246, 113) !important;
     }
     .finalizado {
         background-color: rgb(142, 190, 245) !important;
     }
 </style>
 <script>
     $(function() {
         let repetir = function() {
             $.ajax({
                 url: "admin/inventario_tiempo_real/get_programacion_inventario",
                 type: "post",
                 data: {},
                 dataType: "json",
                 success: function(response) {
                     var respuesta = response.data;
                     var tabla = "";
                     console.log(response)
                     // FECHA EN JQUERY
                     var d = new Date();
                     var month = d.getMonth() + 1;
                     var day = d.getDate();
                     var fecha_actual = d.getFullYear() + '-' +
                         (('' + month).length < 2 ? '0' : '') + month + '-' +
                         (('' + day).length < 2 ? '0' : '') + day;
                     for (ind in respuesta) {
                         var fila = "<tr>";
                         if (respuesta[ind].status == '0') {
                             if(respuesta[ind].fecha_inventario == fecha_actual){
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].indices + "</td>";
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].usuario + "</td>";
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].ubigeo + "</td>";
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].ubicacion + "</td>";
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].fecha_inventario + "</td>";
                                 fila += "<td class='filaProgramada'>" + respuesta[ind].fecha_programacion + "</td>";
                                 fila += "<td class='filaProgramada'><span class = 'label label-success'>PROGRAMADO</span></td>";
                                 fila += "<td class='filaProgramada' style='text-align:center'><a href='admin/tiemporeal/inventario_tiempo_real/"+ respuesta[ind].id +"' class='btn btn-success'>IR A INVENTARIO</a></td>";
                                 fila += "<td class='filaProgramada' style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
                             } 
                             else{
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].indices + "</td>";
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].usuario + "</td>";
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubigeo + "</td>";
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubicacion + "</td>";
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].fecha_inventario + "</td>";
                                 fila += "<td class='filaNoProgramada'>" + respuesta[ind].fecha_programacion + "</td>";
                                 fila += "<td class='filaNoProgramada'><span class = 'label label-success'>PROGRAMADO PERO NO DISPONIBLE EN ESTA FECHA</span></td>";
                                 fila += "<td class='filaNoProgramada style='text-align:center'><a href='admin/tiemporeal/inventario_tiempo_real'><button class='btn btn-danger' disabled>IR A INVENTARIO</button></a></td>";
                                 fila += "<td class='filaNoProgramada' style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
                              }
                         }
                         else{
                                 fila += "<td class='finalizado'>" + respuesta[ind].indices + "</td>";
                                 fila += "<td class='finalizado'>" + respuesta[ind].usuario + "</td>";
                                 fila += "<td class='finalizado'>" + respuesta[ind].ubigeo + "</td>";
                                 fila += "<td class='finalizado'>" + respuesta[ind].ubicacion + "</td>";
                                 fila += "<td class='finalizado'>" + respuesta[ind].fecha_inventario + "</td>";
                                 fila += "<td class='finalizado'>" + respuesta[ind].fecha_programacion + "</td>";
                                 fila += "<td class='finalizado'><span class = 'label label-info'>FINALIZADO</span></td>";
                                 fila += "<td class='finalizado' style='text-align:center'><a href='admin/tiemporeal/inventario_tiempo_real/"+ respuesta[ind].id +"'><button class='btn btn-info' disabled>IR A INVENTARIO</button></a></td>";
                                 fila += "<td class='finalizado' style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
                            
                        }
                             fila += "</tr>";
                             tabla += fila;
                    }
                     $("#cuerpo").html(tabla);
                     $("#tbl_activos_matriculados").DataTable({
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
                     // LLAMO A MODAL ELIMINAR
                     //$('.boton_eliminar').click(function() {
                     $("body").on("click", ".boton_eliminar", function() {
                         //$('#miModal').modal('show'); //<-- you should use show in this situation
                         $('#miModal').modal();
                         var cod_inventario = $(this).attr('cod_inventario');
                         $('.eliminar').attr('href', 'admin/inventario_tiempo_real/eliminar/' + cod_inventario);
                     });
                 }
             });
         }
         repetir();
         //LLENAR SELECT A PARTIR DE OTRO SELECT
         var ubicacion = $('#ubicacion');
         $("#ubigeo").change(function() {
             console.log("chris");
             var ubigeo = $(this).val(); //obtener el id seleccionado
             if (ubigeo != "") { //verificar haber seleccionado una opcion valida
                 /*Inicio de llamada ajax*/
                 $.ajax({
                     url: '<?php echo site_url('admin/inventario_tiempo_real/listar_ubicacion'); ?>', //url que recibe las variables
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
     //ENVIAR DATA CON BOTON CONFIRMAR UBICACION Y UBIGEO
     $(function() {
         $("#form_programacion").submit(function(event) {
             event.preventDefault();
             var datos = $(this).serialize(),
                 url = $(this).attr('action');
             console.log(datos);
             $.ajax({
                 type: "POST",
                 url: "admin/inventario_tiempo_real/agregar_actividad",
                 data: datos,
                 dataType: "json",
                 success: function(resultado) {
                     //console.log(data);
                     jAlert(resultado.respuesta, "Mensaje");
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
     //ENVIAR DATA CON BOTON PROGRAMAR SALIDA
     $(function() {
         $("#form_programar").submit(function(event) {
             event.preventDefault();
             var datos = $(this).serialize(),
                 url = $(this).attr('action');
             console.log(datos);

             $.ajax({
                 type: "POST",
                 url: "admin/inventario_tiempo_real/add_programacion_inventario",
                 data: datos,
                 dataType: "json",
                 success: function(resultado) {
                     jAlert(resultado.respuesta, "Mensaje");
                     //refreshTable();
                     document.getElementById("form_programar").reset();
                     setTimeout(function() {
                         document.location.reload(); //Actualiza la pagina
                         //window.location.assign("admin/tiemporeal/inventario_tiempo_real");
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
             <div class="panel panel-light panel-blue">
                 <div class="panel-heading">
                     <h4>FORMULARIO DE ELECCIÓN DE UBIGEO - UBICACIÓN</h4>
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
                             <button type="submit" class="btn btn-success" id="guardar">CONFIRMAR UBIGEO Y UBICACIÓN</button>

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
                     <h4> PROGRAMACION DE INVENTARIO EN TIEMPO REAL</h4>
                 </div>
                 <div class="panel-body table-responsive">
                     <table class="table danger table-striped no-margin text-center" id="tbl_activos_matriculados" class="display" action="<?php echo base_url('admin/inventario_tiempo_real/add_programacion_inventario') ?>">
                         <thead>
                             <tr>
                                 <th style="text-align:center">ITEM</th>
                                 <th style="text-align:center">USUARIO</th>
                                 <th style="text-align:center">UBIGEO</th>
                                 <th style="text-align:center">UBICACION</th>
                                 <th style="text-align:center">FECHA DE INVENTARIO PROGRAMADO</th>
                                 <th style="text-align:center">FECHA DE PROGRAMACIÓN</th>
                                 <th style="text-align:center">STATUS</th>
                                 <th style="text-align:center">INVENTARIO TIEMPO REAL</th>
                                 <th style="text-align:center">ELIMINAR</th>
                             </tr>
                         </thead>
                         <tbody id="cuerpo">
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-sm-3"></div>
     <div class="col-sm-6">

     </div>
     <form action="" method="POST" id="form_programar">
         <div class="content">
             <div class="container text-left">
                 <div class="row justify-content-center">
                     <div class="col-md-10 text-center">
                         <h2 class="mb-5 text-center">Calendario para Agendar Inventariado</h2>
                         <input type="text" name="fecha" class="form-control w-25 mx-auto mb-3" id="result" placeholder="Seleccionar Fecha" value="<?php echo date('Y-m-d') ?>">
                         <form action="#" class="row">
                             <div class="col-md-12">
                                 <div id="inline_cal"></div>
                             </div>
                         </form>
                         <div style="text-align: center;">
                             <button type="submit" class="btn btn-success" id="agendar">AGENDAR INVENTARIADO</button>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
 </div>
 </form>
 <!--    MODAL ELIMINAR-->
 <div class="modal fade" tabindex="-1" role="dialog" id="miModal">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body">
                 <h4>¿Desea eliminar este registro?</h4>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                 <a type="button" class="btn btn-primary eliminar">Eliminar</a>
             </div>
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

 <style>
     .big-btn {
         width: 90px;
         height: 40px;
         display: block;
         margin: 0 auto;
     }
 </style>
 <script src="calendario/js/rome.js"></script>
 <script src="calendario/js/main.js"></script>
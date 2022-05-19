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
 </style>
 <script>
     $(function() {
         let repetir = function() {
             $.ajax({
                 url: "admin/vinculacion/get_activos_matriculados_ubigeo_abc",
                 type: "post",
                 data: {},
                 dataType: "json",
                 success: function(response) {
                     //console.log("chris")
                     var respuesta = response;
                     var tabla = "";
                     console.log(respuesta)
                     for (ind in respuesta) {
                         var fila = "<tr>";
                         if (respuesta[ind].programacion == "0" && respuesta[ind].estado_lectura == "0") {
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].indice + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_producto + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_rfid + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].descripcion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cliente + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubigeo + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubicacion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].guia_remision + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].date + "</td>";
                             fila += "<td class='filaNoProgramada' style='text-align:center'><input type='checkbox' style='width:20px;height:20px;' id='elegido' name='elegido[]' value='" + respuesta[ind].id + "'></td>";
                         } else if (respuesta[ind].programacion == "0" && respuesta[ind].estado_lectura == "1") {
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].indice + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_producto + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_rfid + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].descripcion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cliente + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubigeo + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubicacion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].guia_remision + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].date + "</td>";
                             fila += "<td class='filaNoProgramada' style='text-align:center'><input type='checkbox' style='width:20px;height:20px;' id='elegido' name='elegido[]' value='" + respuesta[ind].id + "' checked></td>";
                         } else {
                             fila += "<td class='filaProgramada'>" + respuesta[ind].indice + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cod_producto + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cod_rfid + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].descripcion + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cliente + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].ubigeo + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].ubicacion + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].guia_remision + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].date + "</td>";
                             fila += "<td class='filaProgramada'><span class = 'label label-success'>PROGRAMADO</span></td>";
                         }
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
                 /*error: function(error) {
                     alert('ERROR!');
                     //MANDO ERROR
                 }*/
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
         }
         repetir();
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
                 url: "admin/vinculacion/agendar",
                 data: datos,
                 dataType: "json",
                 success: function(resultado) {
                     jAlert(resultado.respuesta, "Mensaje");
                     //refreshTable();
                     document.getElementById("form_programar").reset();
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

     //ACTUALIZAR TABLA DE PROGRAMACION CON LECTURAS
     $(function() {
         let programar_salidas = function() {
             $.ajax({
                 url: "admin/vinculacion/programacion_automatica",
                 type: "post",
                 data: {},
                 dataType: "json",
                 error: function(ee) {
                     console.log(ee);
                 },
                 success: function(response) {
                     console.log(response.respuesta)
                 }
             });
         }
         setInterval(function() {
             programar_salidas();
         }, 1000);
     });
 </script>

 <form action="" method="POST" id="form_programar">
     <div class="main-container">
         <div class="row gutter">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 <div class="panel panel-light panel-brown">
                     <div class="panel-heading">
                         <h4> PROGRAMAR SALIDA DE ACTIVOS</h4>
                         <div style="text-align: center;">
                             <a href="admin/vinculacion/programar_salida_automatica" style="position: absolute; top: 10%; right: 90px;" class="btn btn-success" id="refrescar">CONFIRMAR LECTURAS</a>
                         </div>
                         <div style="text-align: center;">
                             <a href="admin/vinculacion/limpiar_casillas" style="position: absolute; top: 10%; right: 600px;" class="btn btn-warning" id="refrescar_2">LIMPIAR CASILLAS DE LECTURAS</a>
                         </div>
                     </div>
                     <div class="panel-body table-responsive">
                         <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display" action="<?php echo base_url('admin/vinculacion/programar_salida_automatica') ?>">
                             <thead>
                                 <tr>
                                     <th style="text-align:center">ITEM</th>
                                     <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                     <th style="text-align:center">CÓDIGO RFID</th>
                                     <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                     <th style="text-align:center">CLIENTE</th>
                                     <th style="text-align:center">UBIGEO</th>
                                     <th style="text-align:center">UBICACION</th>
                                     <th style="text-align:center">GUIA DE REMISION</th>
                                     <th style="text-align:center">FECHA DE INGRESO</th>
                                     <th style="text-align:center">PROGRAMAR</th>
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
         <div class="content">
             <div class="container text-left">
                 <div class="row justify-content-center">
                     <div class="col-md-10 text-center">
                         <h2 class="mb-5 text-center">Calendario para Agendar Salidas</h2>
                         <input type="text" name="fecha" class="form-control w-25 mx-auto mb-3" id="result" placeholder="Seleccionar Fecha" value="<?php echo date('Y-m-d') ?>">
                         <form action="#" class="row">
                             <div class="col-md-12">
                                 <div id="inline_cal"></div>
                             </div>
                         </form>
                         <div style="text-align: center;">
                             <button type="submit" class="btn btn-success" id="agendar">AGENDAR SALIDA</button>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

 </form>


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
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
    .filaProgramada{background-color: PaleGreen !important;}
    .filaNoProgramada{background-color: rgb(244,246,113) !important;}
</style>
 <script>
     $(function() {
         let repetir = function() {
             $.ajax({
                 url: "admin/vinculacion/get_activos_matriculados",
                 type: "post",
                 data: {},
                 dataType: "json",
                 success: function(response) {
                     var respuesta = response.data;
                     var tabla = "";
                     console.log(response)
                     for (ind in respuesta) {
                         var fila = "<tr>";
                         if (respuesta[ind].programacion == "0") {
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].item + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_producto + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cod_rfid + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].descripcion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].cliente + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubigeo + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].ubicacion + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].orden_ingreso + "</td>";
                             fila += "<td class='filaNoProgramada'>" + respuesta[ind].date + "</td>";
                             fila += "<td class='filaNoProgramada' style='text-align:center'><input type='checkbox' id='elegido' name='elegido[]' value='" + respuesta[ind].id + "'></td>";
                         } else {
                             fila += "<td class='filaProgramada'>" + respuesta[ind].item + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cod_producto + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cod_rfid + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].descripcion + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].cliente + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].ubigeo + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].ubicacion + "</td>";
                             fila += "<td class='filaProgramada'>" + respuesta[ind].orden_ingreso + "</td>";
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
 </script>
 <!-- 

<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">ACTIVOS MATRICULADOS</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div> -->

 <form action="" method="POST" id="form_programar">
     <div class="main-container">
         <div class="row gutter">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 <div class="panel panel-light panel-brown">
                     <div class="panel-heading">
                         <h4> PROGRAMAR SALIDA DE ACTIVOS</h4>
                     </div>
                     <div class="panel-body table-responsive">
                         <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display" action="<?php echo base_url('admin/vinculacion/programar_salida_manual') ?>">
                             <thead>
                                 <tr>
                                     <th style="text-align:center">ITEM</th>
                                     <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                     <th style="text-align:center">CÓDIGO RFID</th>
                                     <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                     <th style="text-align:center">CLIENTE</th>
                                     <th style="text-align:center">UBIGEO</th>
                                     <th style="text-align:center">UBICACION</th>
                                     <th style="text-align:center">ORDEN DE INGRESO</th>
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
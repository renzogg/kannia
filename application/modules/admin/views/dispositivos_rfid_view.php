<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/dispositivo_rfid/get_dispositivo_rfid",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               var respuesta = response.data;
               var tabla = "";
               console.log(response)
               for (ind in respuesta) {
                  var fila = "<tr>";

                  fila += "<td>" + respuesta[ind].id + "</td>";
                  fila += "<td>" + respuesta[ind].mac + "</td>";
                  fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                  fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                  fila += "<td>" + respuesta[ind].actividad+ "</td>";
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
   });
</script>
<div class="row gutter">
   <h1>
      <center>DISPOSITIVOS RFID ASIGNADOS</center>
   </h1>

   <div style="width: 20%; float:left">
      <div class="col-md-8" id="imagen">
         <img src="static/main/img/Paleta.PNG">
      </div>
   </div>
   <div style="width: 20%; float:right">
      <img src="static/main/img/lector_rfid.png" alt="imagen 3" width="300">
   </div>
   <div style="width: 40%; float:right">
      <img src="static/main/img/tablet.PNG" alt="imagen 3" width="200">
   </div>

</div>


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-blue">
            <div class="panel-heading">
               <h4> LISTA DE DISPOSITIVOS RFID ASIGNADOS</h4>
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
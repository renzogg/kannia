<!--ESTILOS CSS-->
<style>
   #cuerpo tr:nth-child(1) td {
      color: #009966;
      background: #FFFF00 !important;
   }
</style>
<!--//primero se pintaba tu fila y despues la celda
    //mejor para asegurar pinta las celdas
    //las celdas son td -->
<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/rfid_tiempo_real/get_list_real",
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
                  fila += "<td>" + respuesta[ind].tag + "</td>";
                  fila += "<td>" + respuesta[ind].fecha + "</td>";
                  fila += "</tr>";
                  tabla += fila;
               }
               $("#cuerpo").html(tabla);
            }
         });
      }
      //repetir();
      setInterval(function() {
         repetir();
      }, 1000);
   });
</script>


<!--eso le puse pero solo me pinta las letras no la fila-->

<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">LECTURAS DE CHIPS RFID - TIEMPO REAL</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-brown">
            <div class="panel-heading">
               <h4>TIEMPOR REAL - LECTURAS RFID</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">TAG</th>
                        <th style="text-align:center">FECHA Y HORA</th>

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
<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/inventario/get_list_inventario",
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
                  fila += "<td>" + respuesta[ind].cod + "</td>";
                  fila += "<td>" + respuesta[ind].descripcion + "</td>";
                  fila += "<td><img src='static/main/img/" + respuesta[ind].imagen + "' alt='Activo' width='42' height='42' style='vertical-align:bottom'>" + "</td>";
                  if (respuesta[ind].status == "1") {
                     fila += "<td><span class = 'label label-success'>Vinculado</span></td>";
                  } else {
                     fila += "<td><span class = 'label label-warning'>Sin Vincular</span></td>";
                  }
                  fila += "<td>" + respuesta[ind].date + "</td>";
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
</script>


<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">INVENTARIO ACTUAL</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-brown">
            <div class="panel-heading">
               <h4> ACTIVOS DEL INVENTARIO</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">CÓDIGO DE INVENTARIO</th>
                        <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                        <th style="text-align:center">IMAGEN</th>
                        <th style="text-align:center">STATUS</th>
                        <th style="text-align:center">FECHA DE INVENTARIO</th>
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
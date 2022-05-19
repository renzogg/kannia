<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/enrolamiento/get_sujetos_enrolados",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               var respuesta = response;
               var tabla = "";
               console.log(response)
               for (ind in respuesta) {
                  var fila = "<tr>";

                  fila += "<td>" + respuesta[ind].id + "</td>";
                  fila += "<td>" + respuesta[ind].nombres + "</td>";
                  fila += "<td>" + respuesta[ind].apellidos + "</td>";
                  fila += "<td>" + respuesta[ind].dni + "</td>";
                  fila += "<td>" + respuesta[ind].codigo_rfid + "</td>";
                  fila += "<td>" + respuesta[ind].cargo + "</td>";
                  fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                  fila += "<td><img src='static/main/img/" + respuesta[ind].imagen + "' alt='Activo' width='42' height='42' style='vertical-align:bottom'>" + "</td>";
                  fila += "<td>" + respuesta[ind].date + "</td>";
                  fila += "<td style='text-align:center'><a href='admin/enrolamiento/editar/" + respuesta[ind].dni + "'class='btn btn-success'>Editar</a></td>";
                  fila += "<td style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_dni='" + respuesta[ind].dni + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";

                  fila += "</tr>";
                  tabla += fila;
               }
               $("#cuerpo").html(tabla);

               $("#tbl_sujetos").DataTable({
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
                  var cod_dni = $(this).attr('cod_dni');
                  $('.eliminar').attr('href', 'admin/enrolamiento/eliminar/' + cod_dni);
               });
            }
         });
      }
      repetir();
   });
</script>
<!-- 

<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">ACTIVOS MATRICULADOS</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div> -->


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-green">
            <div class="panel-heading">
               <h4> LISTA DE SUJETOS ENROLADOS</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_sujetos" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">NOMBRES</th>
                        <th style="text-align:center">APELLIDOS</th>
                        <th style="text-align:center">DNI</th>
                        <th style="text-align:center">CÓDIGO RFID</th>
                        <th style="text-align:center">CARGO</th>
                        <th style="text-align:center">UBIGEO</th>
                        <th style="text-align:center">IMAGEN</th>
                        <th style="text-align:center">FECHA ENROLAMIENTO</th>
                        <th style="text-align:center">EDITAR</th>
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
</div>
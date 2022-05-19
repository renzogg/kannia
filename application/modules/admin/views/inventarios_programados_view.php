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
                          if (respuesta[ind].fecha_inventario != fecha_actual) {
                              fila += "<td class='filaNoProgramada'>" + respuesta[ind].id + "</td>";
                              fila += "<td class='filaNoProgramada'>" + respuesta[ind].usuario + "</td>";
                              fila += "<td class='filaNoProgramada'>" + respuesta[ind].fecha_inventario + "</td>";
                              fila += "<td class='filaNoProgramada'>" + respuesta[ind].fecha_programacion + "</td>";
                              fila += "<td class='filaNoProgramada'><span class = 'label label-success'>PROGRAMADO PERO NO DISPONIBLE</span></td>";
                              fila += "<td class='filaNoProgramada style='text-align:center' class='botones'><a><button class='btn btn-danger boton_inventario' disabled ><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> IR A INVENTARIO</button></a></td>";
                              fila += "<td class='filaNoProgramada' style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
                          } else {
                              fila += "<td class='filaProgramada'>" + respuesta[ind].id + "</td>";
                              fila += "<td class='filaProgramada'>" + respuesta[ind].usuario + "</td>";
                              fila += "<td class='filaProgramada'>" + respuesta[ind].fecha_inventario + "</td>";
                              fila += "<td class='filaProgramada'>" + respuesta[ind].fecha_programacion + "</td>";
                              fila += "<td class='filaProgramada'><span class = 'label label-success'>PROGRAMADO</span></td>";
                              fila += "<td class='filaProgramada' style='text-align:center'><a href='admin/tiemporeal/inventario_tiempo_real'class='btn btn-success'>IR A INVENTARIO</a></td>";
                              fila += "<td class='filaProgramada' style='text-align:center' class='botones'><a data-target='#miModal' data-toggle='miModal'><button class='btn btn-danger boton_eliminar' cod_inventario='" + respuesta[ind].id + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Eliminar</button></a></td>";
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
      });
  </script>

  <div class="main-container">
      <div class="row gutter">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="panel panel-light panel-brown">
                  <div class="panel-heading">
                      <h4> PROGRAMACION DE INVENTARIO EN TIEMPO REAL</h4>
                  </div>
                  <div class="panel-body table-responsive">
                      <table class="table danger table-striped no-margin text-center" id="tbl_temperature" class="display" action="<?php echo base_url('admin/inventario_tiempo_real/add_programacion_inventario') ?>">
                          <thead>
                              <tr>
                                  <th style="text-align:center">ITEM</th>
                                  <th style="text-align:center">USUARIO</th>
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

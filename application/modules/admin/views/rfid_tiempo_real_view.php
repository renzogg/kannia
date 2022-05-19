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
 $(document).ready(function () {
     var table = $('#tbl_temperature').DataTable({      
               "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
                title: 'Lectura Tags RFID - Tiempo Real'
              }
            ],  
            "ajax":{
              url: "<?php echo site_url('admin/alerta/get_tags'); ?>",
              type: "post"
            }, 
            "columns": [
                {"data": "id"},
                {"data": "tag"},
                {"data": "fecha"}
            ],
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
 });

 setInterval(function() {
            var tablita = $('#tbl_temperature').DataTable();
            tablita.ajax.reload(null,false);
        },3000);
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
               <h4>TIEMPO REAL - LECTURAS RFID</h4>
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
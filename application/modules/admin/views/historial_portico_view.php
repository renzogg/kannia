<script>
   $(document).ready(function() {
      var table = $('#tbl_portico').DataTable({
         responsive: true,
         "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
            title: 'Inventario RFID - Tiempo Real'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/portico_tiempo_real/get_portico_tiempo_real'); ?>",
            type: "post"
         },
         "columns": [
            {"data": "id"},
            {"data": "nombres"},
            {"data": "apellidos"},
            {"data": "dni"},
            {"data": "codRFID"},
            {"data": "cargo"},
            {"data": "imagen",
               "render": function(data, type, row) {
                  //console.log(data);
                  for (ind in data) {
                     return '<img class="miImagen" src="static/main/img/' + data + '" alt="Activo" width="42" height="42" style="vertical-align:bottom">';
                  }
               }
            },
            {"data": "fecha_enrolacion"},
            {"data": "date"},
            {"data": null,
               "render": function(data,type,row){
                  //console.log(data['codRFID']);
                  return '<button class="btn btn-warning"><a href="admin/reporte/reporte_pdf_sujeto/' + data['codRFID']  + data['date'] +'">PDF</a></button>';
               }
            }
         ],
         "bdestroy": true,
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
</script>


<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">HISTORIAL - PORTICO RFID</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>


<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-green">
            <div class="panel-heading">
               <h4>DATOS EN TIEMPO REAL</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center" id="tbl_portico" class="display">
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
                        <th style="text-align:center">FECHA EVENTO</th>
                        <th style="text-align:center">REPORTE</th>
                     </tr>
                  </thead>
                  <tbody id="cuerpo">
                  </tbody>
               </table>

            </div>
         </div>
      </div>
   </div>
<style>
    .img-responsive{
        align-content:stretch;
        overflow:hidden;
        object-fit: cover;
        width: 100%;
        height: 215px;
    }
    .fit-image{
        width: 100%;
        object-fit: cover;
        height: 300px; /* only if you want fixed height */
    }
</style>
</div>
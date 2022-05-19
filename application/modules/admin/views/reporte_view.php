
<script>
 var time_set = 10000;

   $(document).ready(function () {

    var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!

      var yyyy = today.getFullYear();
      if(dd<10){
          dd='0'+dd;
      } 
      if(mm<10){
          mm='0'+mm;
      } 
    var today = yyyy+'-'+mm+'-'+dd;

    function conteoActual() {
        $.ajax({
            url: "<?php echo site_url('admin/reporte/get_conteo_actual'); ?>",
            data: {
                fecha: today
            },
            type: 'post',
            dataType: "json",
            success: function(resultado) {              
               // console.log(resultado[0][0]['total']);
                var normal = resultado[0][0]['total'];
                var atencion = resultado[1][0]['total'];
                var peligro = resultado[2][0]['total'];

                $('.e_normal').text(normal);
                $('.e_atencion').text(atencion);
                $('.e_peligro').text(peligro);

                setTimeout(conteoActual, time_set);
            },
            cache: false
        });
    }
   
   conteoActual();
   var table = $('#tbl_temperature').DataTable({   
    "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
                title: 'Historial Sensores'
              }
            ],   
            "ajax":{
              url: "<?php echo site_url('admin/reporte/get_list_temperature'); ?>",
              type: "post"
            }, 
            "columns": [
                {"data": "id"},
                {"data": "codigo_rodillo"},
                {"data": "bmac"},
                {"data": "tempc"},
                {"data": "tempf"},
                {"data": "hm"},
                {"data": "date"}
               
   
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
</script>
<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">REPORTE DE SENSORES</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
   <ul class="tasks pull-right clearfix">
      <li>
         <p >
            <div class="task-num e_normal"></div>
            <p class="task-type ">NORMAL</p>
         </p>
      </li>
      <li>
         <p>
            <div class="task-num  e_atencion"></div>
            <p class="task-type">ATENCION</p>
         </p>
      </li>
      <li>
         <p>
            <div class="task-num e_peligro"></div>
            <p class="task-type ">PELIGRO</p>
         </p>
      </li>
</div>
</ul>
</div>
</div>
<div class="main-container">
   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-green-two">
            <div class="panel-heading">
               <h4>Historial Sensores</h4>
            </div>
            <div class="panel-body table-responsive">
               <table class="table danger table-striped no-margin text-center"  id="tbl_temperature" class="display">
                  <thead>
                     <tr>
                        <th style="text-align:center">ITEM</th>
                        <th style="text-align:center">RODILLO</th>
                        <th style="text-align:center">SENSOR</th>
                        <th style="text-align:center">°C</th>
                        <th style="text-align:center">°F</th>
                        <th style="text-align:center">HUMEDAD </th>
                        <th style="text-align:center">FECHA Y HORA </th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<STYLE>
.col-lg-2{
   width: 20%;
}

.chart {
  width: 100%; 
  min-height: 100%;
}
</STYLE>



<script>
    $(function () {

    setInterval(function () {
    $("#div1").load("<?php echo base_url(); ?>admin/inicio/get_estado");
    }, 500);
    

    setInterval(function () {
    $("#div2").load("<?php echo base_url(); ?>admin/inicio/get_estado_rodillo");
    }, 500);
         
    } );
</script>



<div class="col-md-8 col-sm-6 col-xs-12">
   <h3 class="page-title">Medidor de Temperatura en Tiempo Real</h3>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
 
</div>
</div>


<div class="main-container">
   <div class="row gutter " >

 <div id="div1">

</div>

</div>
<div class="row gutter">
   <div class="col-lg-12">
      <div class="panel">
         <div class="panel-heading">
            <h4>Mapa de Rodillos</h4>
            
         </div>
         <div class="panel-body">

            <ul class="visitor-stats row gutter">

              <div id="div2">




              </div>
              
            </ul>
         </div>
      </div>
   </div>
</div>


</div>
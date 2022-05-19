<div class="row-fluid">
   <h1 class="page-title">
      <center>CONTROL DE ACCESO DE PERSONAL - RFID</center>
   </h1>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>
<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/portico_tiempo_real/get_portico_tiempo_real",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               console.log(response);
               var respuesta = response.data;
               // LLENO LOS CAMPOS
               document.getElementById("codigo_rfid").value = respuesta[0].codRFID;
               document.getElementById("dni").value = respuesta[0].dni;
               document.getElementById("nombres").value = respuesta[0].nombres;
               document.getElementById("apellidos").value = respuesta[0].apellidos;
               document.getElementById("cargo").value = respuesta[0].cargo;
               document.getElementById("enrolamiento").value = respuesta[0].date;
               // MUESTRO LA IMAGEN
               var image = new Image();
               var src = "static/main/img/" + respuesta[0].imagen;
               console.log(src);
               var picture = "<img src=" + src + " style='vertical-align:bottom'>";
               console.log(picture);
               /* image.picture = picture;
               $('#image').append(image); */
               var fotito = document.getElementById("image");
               fotito.innerHTML = picture;
            }
         });
      }
      //repetir();
      setInterval(function() {
         repetir();
      }, 1000);
   });
</script>

<style>
    .img-responsive{
        align-content:stretch;
        overflow:hidden;
        object-fit: cover;
        width: 200%;
        height: 300px;
    }
    .fit-image{
        width: 100%;
        object-fit: cover;
        height: 300px; /* only if you want fixed height */
    }
</style>

<div class="main-container">
   <div class="row gutter">
      <div class="col-sm-6 col-sm-offset-3">
         <div class="panel panel-light panel-green">
            <div class="panel-heading">
               <h4>IMAGEN</h4>
            </div>
            <div class="panel-body">
               <div class="col-md-12">
                  <div class="img-responsive" id="image" style="text-align: center;"></div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-blue">
            <div class="panel-heading">
               <h4>DATOS DEL SUJETO ENROLADO</h4>
            </div>
            <div class="panel-body">
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">CÓDIGO RFID</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" id="codigo_rfid" name="codigo_rfid">
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">DNI</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="dni" id="dni">
                     <?php echo form_error('dni', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">Nombres</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="nombres" id="nombres">
                     <?php echo form_error('nombres', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">Apellidos</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="apellidos" id="apellidos">
                     <?php echo form_error('apellidos', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">Cargo</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="cargo" id="cargo">
                     <?php echo form_error('cargo', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">Fecha Enrolamiento</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="enrolamiento" id="enrolamiento">
                     <?php echo form_error('enrolamiento', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
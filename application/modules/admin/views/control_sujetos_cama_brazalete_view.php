<div class="row-fluid">
   <h1 class="page-title">
      <center>CONTROL DE PACIENTES - RFID</center>
   </h1>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">

</div>
</div>
<script>
   $(function() {
      let repetir = function() {
         $.ajax({
            url: "admin/paciente/get_paciente_cama_brazalete",
            type: "post",
            data: {},
            dataType: "json",
            success: function(response) {
               console.log(response);
               var respuesta = response;
               if(respuesta[0].estado == "1"){
                  // LLENO LOS CAMPOS
                  document.getElementById("cama_paciente").value = respuesta[0].cama_paciente;
                  document.getElementById("rfid_cama").value = respuesta[0].rfid_cama;
                  document.getElementById("brazalete_paciente").value = respuesta[0].brazalete_paciente;
                  document.getElementById("rfid_brazalete").value = respuesta[0].rfid_brazalete;
                  document.getElementById("nombres").value = respuesta[0].nombres;
                  document.getElementById("apellidos").value = respuesta[0].apellidos;
                  // MUESTRO LA IMAGEN
                  var image = new Image();
                  var src = "static/main/img/" + respuesta[0].imagen;
                  console.log(src);
                  var picture = "<img src=" + src +
                     " alt='Activo' style='vertical-align:bottom'>";
                  console.log(picture);
                  /* image.picture = picture;
                  $('#image').append(image); */
                  var fotito = document.getElementById("image");
                  fotito.innerHTML = picture;
               }
               else{
                  // LLENO LOS CAMPOS
                  document.getElementById("cama_paciente").value = "PACIENTE Y CAMA NO CORRESPONDEN";
                  document.getElementById("rfid_cama").value = "PACIENTE Y CAMA NO CORRESPONDEN"
                  document.getElementById("brazalete_paciente").value = "PACIENTE Y CAMA NO CORRESPONDEN";
                  document.getElementById("rfid_brazalete").value = "PACIENTE Y CAMA NO CORRESPONDEN";
                  document.getElementById("nombres").value = "PACIENTE Y CAMA NO CORRESPONDEN";
                  document.getElementById("apellidos").value = "PACIENTE Y CAMA NO CORRESPONDEN"
                  // MUESTRO LA IMAGEN
                  var image = new Image();
                  var src = "static/main/img/error.png";
                  var picture = "<img src=" + src + "  style='vertical-align:bottom'>";
                  console.log(picture);
                  /* image.picture = picture;
                  $('#image').append(image); */
                  var fotito = document.getElementById("image");
                  fotito.innerHTML = picture;

               }
            }
         });
      }
      //repetir();
      setInterval(function() {
         repetir();
      }, 2000);
   });
</script>

<style>
    .img-responsive{
        align-content:center;
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
    .center {
        margin-left: auto;
        margin-right: auto;
        display: block;
}
    .padre{
        position: relative; /* Se usa para que no se salga la imagen de la caja, ya que la imagen tiene position absolute */
        width: 500px;
        height: 200px;
        background-color: #ddd;
    }
    .padre img{
        position: absolute; /* se usa en caso de este div, donde tiene la altura y el ancho definido, sin esto top, right y left no funcionarían */
        width: 100px;
        top: 25%; /* sirve en caso de un div como este, donde tiene una altura definida, en caso de que la altura no este definida esta edición no se pone ; */
        right: 0; /* se debe usar para que margin 0 auto funcione */
        left: 0; /* se debe usar para que margin 0 auto funcione */
        margin: 0 auto; /* Esto lo centra */
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
                  <div id="image" class="img-responsive center"></div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="row gutter">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="panel panel-light panel-red">
            <div class="panel-heading">
               <h4>DATOS DEL PACIENTE ENROLADO</h4>
            </div>
            <div class="panel-body">
               <label for="inputEmail3" class="col-md-4 control-label">NOMBRES</label>
               <div class="col-md-8">
                  <input type="text" readonly="readonly" class="form-control" name="nombres" id="nombres">
                  <?php echo form_error('nombres', '<span class="label label-danger">', '</span>'); ?>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">APELLIDOS</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="apellidos" id="apellidos">
                     <?php echo form_error('apellidos', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">CAMA PACIENTE</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" id="cama_paciente" name="cama_paciente">
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">BRAZALETE PACIENTE</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" id="brazalete_paciente" name="brazalete_paciente">
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">CAMA - CÓDIGO RFID</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="rfid_cama" id="rfid_cama">
                     <?php echo form_error('rfid_cama', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-md-4 control-label">BRAZALETE - CÓDIGO RFID</label>
                  <div class="col-md-8">
                     <input type="text" readonly="readonly" class="form-control" name="rfid_brazalete" id="rfid_brazalete">
                     <?php echo form_error('rfid_brazalete', '<span class="label label-danger">', '</span>'); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

</div>
</div>
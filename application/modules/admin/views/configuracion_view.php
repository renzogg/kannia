  <script>
  $(document).ready(function () {
    $.ajax({                                      
      url: "<?php echo site_url('admin/configuracion/get_valores'); ?>",              
      type: "post",          
      data: "1",
      dataType: 'html',                
      success: function (resultado) {     
      var valores = {};    
        valores = jQuery.parseJSON(resultado);
        //console.log(valores[0]["ID_ESTADO"]);
        $("#en_limite_superior").val(valores[0]["LIMITE_S"]);
        $("#en_limite_inferior").val(valores[0]["LIMITE_I"]);
        $("#en_color").val(valores[0]["COD_COLOR"]);

        $("#ea_limite_superior").val(valores[1]["LIMITE_S"]);
        $("#ea_limite_inferior").val(valores[1]["LIMITE_I"]);
        $("#ea_color").val(valores[1]["COD_COLOR"]);

        $("#ep_limite_superior").val(valores[2]["LIMITE_S"]);
        $("#ep_limite_inferior").val(valores[2]["LIMITE_I"]);
        $("#ep_color").val(valores[2]["COD_COLOR"]);
      },
      error: function (error) {
            alert('ERROR!');  
//                $.unblockUI();
      }
   });

  });
   $(function(){
  $("#form_normal").submit(function(event){
         event.preventDefault();
          var datos = $(this).serialize(),
                url = $(this).attr('action');
                console.log(datos);
 
         $.ajax({
           type: "POST",
           url: url,
           data: datos, 
           dataType: "html",
            success: function (resultado) {
                jAlert(resultado, "Mensaje");                
            },
            error: function (error) {
               alert('ERROR!');  
//                $.unblockUI();
            }           
          });       
         return false;  //stop the actual form post !important! 
   });

  $("#form_atencion").submit(function(event){
         event.preventDefault();
          var datos = $(this).serialize(),
                url = $(this).attr('action');
                console.log(datos);
 
         $.ajax({
           type: "POST",
           url: url,
           data: datos, 
           dataType: "html",
            success: function (resultado) {
                jAlert(resultado, "Mensaje");                
            },
            error: function (error) {
               alert('ERROR!');  
//                $.unblockUI();
            }           
          });       
         return false;  //stop the actual form post !important! 
   });

  $("#form_peligro").submit(function(event){
         event.preventDefault();
          var datos = $(this).serialize(),
                url = $(this).attr('action');
                console.log(datos);
 
         $.ajax({
           type: "POST",
           url: url,
           data: datos, 
           dataType: "html",
            success: function (resultado) {
                jAlert(resultado, "Mensaje");                
            },
            error: function (error) {
               alert('ERROR!');  
//                $.unblockUI();
            }           
          });       
         return false;  //stop the actual form post !important! 
   });
  });
  </script>


<div class="col-md-8 col-sm-6 col-xs-12">
                        <h3 class="page-title">PANEL DE CONFIGURACIÓN</h3>
                     </div>
                     <div class="col-md-4 col-sm-6 col-xs-12">
                        
                       </div>
                     
                        </div>
            </div>


             <div class="main-container">
               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-teal">
                        <div class="panel-heading">
                           <h4>Estado Normal</h4>

                        </div>
                        <div class="panel-body enormal">
                           <form class="form-horizontal" id="form_normal" method="post"  action="<?php echo base_url('admin/configuracion/guardar_enormal') ?>">
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Inferior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="en_limite_inferior"  name="en_limite_inferior" placeholder="Ingrese temperatura mínima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Superior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="en_limite_superior"  name="en_limite_superior" placeholder="Ingrese temperatura máxima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label  class="col-sm-2 control-label">Código de color</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="en_color" name="en_color"  placeholder="Ingrese el código de color"></div>
                                 <button type="submit" class="btn btn-success">Guardar</button>
                              </div>
                 
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-twitter">
                        <div class="panel-heading">
                           <h4>Estado Atención</h4>

                        </div>
                        <div class="panel-body">
                           <form class="form-horizontal" id="form_atencion" method="post"  action="<?php echo base_url('admin/configuracion/guardar_eatencion') ?>">
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Inferior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ea_limite_inferior" name="ea_limite_inferior" placeholder="Ingrese temperatura mínima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Superior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ea_limite_superior" name="ea_limite_superior"  placeholder="Ingrese temperatura máxima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label  class="col-sm-2 control-label">Código de color</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ea_color" name="ea_color" placeholder="Ingrese el código de color"></div>
                                  <button type="submit" class="btn btn-success">Guardar</button>
                              </div>                       
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-linkedin">
                        <div class="panel-heading">
                           <h4>Estado Peligro</h4>

                        </div>
                        <div class="panel-body">
                           <form class="form-horizontal" id="form_peligro" method="post"  action="<?php echo base_url('admin/configuracion/guardar_epeligro') ?>">
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Inferior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ep_limite_inferior" name="ep_limite_inferior" placeholder="Ingrese temperatura mínima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label for="inputEmail3" class="col-sm-2 control-label">Límite Superior</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ep_limite_superior" name="ep_limite_superior" placeholder="Ingrese temperatura máxima para este estado"></div>
                              </div>
                              <div class="form-group row gutter">
                                 <label  class="col-sm-2 control-label">Código de color</label>
                                 <div class="col-sm-7"><input type="text" class="form-control" id="ep_color" name="ep_color" placeholder="Ingrese el código de color"></div>
                                   <button type="submit" class="btn btn-success">Guardar</button>
                              </div>            
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
        
               
            </div>

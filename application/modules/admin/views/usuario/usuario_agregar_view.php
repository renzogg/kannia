<div class="row-fluid">
<br>
<br>
<br>
	<h1 class="titulo_admin">Agregar Usuario</h1>
</div>
<br>
<br>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
		
			<div class="form-group">
			    <label for="inputEmail3" class="col-sm-4 control-label">Usuario</label>
			    <div class="col-sm-8">
			      	<input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingresa nombre del Usuario..."><?php echo form_error('usuario', '<span class="label label-danger	">', '</span>'); ?>
			    </div>
			 </div>

			<div class="form-group">
			    <label for="inputEmail3" class="col-sm-4 control-label">Contraseña</label>
			    <div class="col-sm-8">
			      	<input type="text" class="form-control" name="contrasena" id="contrasena" placeholder="Ingresa Contraseña ..." >	<?php echo form_error('contrasena', '<span class="label label-danger	">', '</span>'); ?>
			    </div>
			</div>
			
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Estado</label>
				<div class="col-sm-8">
					<select name="estado" class="form-control">
						  <option value="1">Activo</option>
						  <option value="0">Inactivo</option>
					</select>
				</div>
				
			</div>
			<br><br>

			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<?php helper_btn_enviar_salir('admin/usuario'); ?>
			    </div>
			</div>
		</form> 
	</div>
		
</div>
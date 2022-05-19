<div class="row-fluid">
<br>
<br>
<br>
	<h1>EDITAR USUARIO</h1>
</div>

<br>
<br>

<a class="btn btn-primary" href="admin/usuario">Atras</a>

<br>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
			<!--<div class="form-group">
			    <label for="inputEmail3" class="col-sm-4 control-label">ID</label>
			     <div class="col-sm-8">
			      	<input type="text" class="form-control" value="<?php echo $usuario->id ?>" disabled>
			    </div>
			</div>-->

			<div class="form-group">
			    <label for="inputEmail3" class="col-sm-4 control-label">Usuario</label>
			    <div class="col-sm-8">
			      	<input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingresa nombre del Usuario..." value="<?php echo $usuario->usuario ?>">
			      	<?php echo form_error('usuario', '<span class="label label-danger	">', '</span>'); ?>
			    </div>
			</div>

			<div class="form-group">
			    <label for="inputEmail3" class="col-sm-4 control-label">Contraseña</label>
			    <div class="col-sm-8">
			      	<input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Ingresa Contraseña ..." value="<?php echo $usuario->contrasena ?>">
			      	<?php echo form_error('contrasena', '<span class="label label-danger	">', '</span>'); ?>
			    </div>
			</div>
			
			<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Estado</label>
				<div class="col-sm-8">
					<select name="estado"  class="form-control">
						  <!--<option value="1">Activo</option>
						  <option value="0">Inactivo</option>-->
						  <option value="<?php echo $usuario->estado ?>">
						  	<?php
							  	if(($usuario->estado)== 1 ){
							  		echo "ACTIVO";
							  	} 
							  	else{
							  		echo "INACTIVO";
							  	};
						  	?>
						</option>
						<?php
							if(($usuario->estado)==1){
								echo "<option value='0'>INACTIVO</option>";
								}
							else{
								echo "<option value='1'>ACTIVO</option>";
							};
						?>
					</select>
				</div>
			</div>
			<!--<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-success">Enviar</button>
			    </div>
			</div>-->
			<br>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<?php helper_btn_enviar_salir('admin/usuario'); ?>
			    </div>
			</div>
		</form> 
	</div>
		
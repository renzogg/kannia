<div class="row-fluid">
	<h1>
		<center>Editar Sujeto Enrolado</center>
	</h1>
</div>
<script>
	$(function() {
		let repetir = function() {
			$.ajax({
				url: "admin/enrolamiento/get_sujetos_enrolados",
				type: "post",
				data: {},
				dataType: "json",
				success: function(response) {
					var respuesta = response.data;
					var tabla = "";
					//console.log(response)
					for (ind in respuesta) {
						var fila = "<tr>";

						fila += "<td>" + respuesta[ind].id + "</td>";
						fila += "<td>" + respuesta[ind].nombres + "</td>";
						fila += "<td>" + respuesta[ind].apellidos + "</td>";
						fila += "<td>" + respuesta[ind].dni + "</td>";
						fila += "<td>" + respuesta[ind].codigo_rfid + "</td>";
						fila += "<td>" + respuesta[ind].cargo + "</td>";
						fila += "<td><img src='static/main/img/" + respuesta[ind].imagen + "' alt='Activo' width='42' height='42' style='vertical-align:bottom'>" + "</td>";
						fila += "<td>" + respuesta[ind].date + "</td>";

						fila += "</tr>";
						tabla += fila;
					}
					$("#cuerpo").html(tabla);

					$("#tbl_inventario").DataTable({
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
				}
			});
		}
		repetir();
	});
	$(document).ready(function() {
		$('input[type="file"]').change(function(e) {
			var fileName = e.target.files[0].name;
			//alert('The file "' + fileName +  '" archivo seleccionado.');
			//console.log(fileName);
			var image = new Image();
			var src = "static/main/img/" + fileName;
			//console.log(src);
			var picture = "<img src=" + src + " alt='Activo' width='150' height='150' style='vertical-align:bottom'>";
			console.log(picture);
			/* image.picture = picture;
			$('#image').append(image); */
			var fotito = document.getElementById("editar_image");
			fotito.innerHTML = picture;
		});
	});
	/* // LLAMO A MODAL DE MENSAJE: NO SE REALIZARON CAMBIOS
	$("body").on("click", ".boton_aviso", function() {
		//$('#miModal').modal('show'); //<-- you should use show in this situation
		$('#miModal').modal();
		var cod_inventario = $(this).attr('cod_inventario');
		$('.aceptar').attr('href','admin/inventario/editar_activos');
	}); */
</script>
<br>
<!--PARA VER ERRORES-->
<!--<pre>
	<?php
	echo print_r($codigo);
	echo print_r($codigo_rfid);
	?>
    </pre>-->
<div class="main-container">
	<div class="row gutter">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-light panel-blue">
				<div class="panel-heading">
					<h4>Formulario de Edición de Sujetos Enrolados</h4>
				</div>
				<div class="panel-body">
					<?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Código RFID</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="rfid" id="rfid" placeholder="Ingresa codigo..." value="<?php echo $codigo_rfid[0]["codigo_rfid"]; ?>">
							<?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">DNI</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="dni" id="dni" placeholder="Ingresa codigo..." value="<?php echo $codigo->dni; ?>">
							<?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Nombres</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingresa nombres..." value="<?php echo $codigo->nombres; ?>">
							<?php echo form_error('nombres', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Apellidos</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingresa apellidos..." value="<?php echo $codigo->apellidos; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Cargo</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="cargo" id="cargo" placeholder="Ingresa cargo..." value="<?php echo $codigo->cargo; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Imagen</label>
						<div class="col-md-4" id="imagen">
							<img src="static/main/img/<?php echo $codigo->imagen; ?>" alt="Activo" width="150" height="200" style="vertical-align:bottom">
						</div>
					</div>

					<div class="form-group">
						<label for="image" class="col-md-4 control-label" id="select_file">Actualizar imagen</label>
						<input type="file" id="name_file" class="form-control-file" name="name_file">
						<div id="editar_image" class="relative"></div>
					</div>


					<div class="form-group">
						<div class="col-md-2 control-label" style="float: left; width: 225px">
							<a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_aviso">Enviar</button></a>
						</div>
						<div style="float: right; width: 225px">
							<a class="btn btn-primary" href="admin/enrolamiento">Atrás</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="row gutter">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-light panel-brown">
				<div class="panel-heading">
					<h4>EDICIÓN DE SUJETOS ENROLADOS</h4>
				</div>
				<div class="panel-body table-responsive">
					<table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
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
<div class="row-fluid">
	<h1>
		<center>Editar Activo Matriculado</center>
	</h1>
</div>
<script>
	$(function() {
		let repetir = function() {
			$.ajax({
				url: "admin/inventario/get_activos_matriculados",
				type: "post",
				data: {},
				dataType: "json",
				success: function(response) {
					var respuesta = response;
					var tabla = "";
					//console.log(response)
					for (ind in respuesta) {
						var fila = "<tr>";

						fila += "<td>" + respuesta[ind].id + "</td>";
						fila += "<td>" + respuesta[ind].cod_producto + "</td>";
						fila += "<td>" + respuesta[ind].cod_rfid + "</td>";
						fila += "<td>" + respuesta[ind].descripcion + "</td>";
						fila += "<td>" + respuesta[ind].cliente + "</td>";
						fila += "<td> S/." + respuesta[ind].valor + ".00</td>";
						fila += "<td>" + respuesta[ind].unidad_medida + "</td>";
						fila += "<td>" + respuesta[ind].cantidad + "</td>";
						fila += "<td>" + respuesta[ind].ubigeo + "</td>";
						fila += "<td>" + respuesta[ind].ubicacion + "</td>";
						fila += "<td>" + respuesta[ind].ancho + " m</td>";
						fila += "<td>" + respuesta[ind].profundidad + " m</td>";
						fila += "<td>" + respuesta[ind].peso + " Kg</td>";
						fila += "<td>" + respuesta[ind].lote + "</td>";
						fila += "<td>" + respuesta[ind].orden_ingreso + "</td>";
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
		//LLENAR SELECT A PARTIR DE OTRO SELECT
		var ubicacion = $('#ubicacion');
		$("#ubigeo").change(function() {
			console.log("fffff")
			var ubigeo = $(this).val(); //obtener el id seleccionado
			if (ubigeo != "") { //verificar haber seleccionado una opcion valida
				/*Inicio de llamada ajax*/
				$.ajax({
					url: '<?php echo site_url('admin/inventario/listar_ubicaciones'); ?>', //url que recibe las variables
					data: {
						ubigeo: $("#ubigeo").val()
					}, //variables o parametros a enviar, formato => nombre_de_variable:contenido
					type: "post", //mandar variables como post o get
					dataType: "JSON", //tipo de datos que esperamos de regreso
					success: function(response) {
						console.log(response);
						$("#ubicacion").html('');
						$("#ubicacion").append(new Option('---SELECCIONAR UBICACION---', 0));
						ubicacion.prop('disabled', false); //habilitar el select
						if (response != '') {
							for (ind in response) {
								$("#ubicacion").append(new Option(response[ind]["ubicacion"]), response[ind]["ubicacion"]);
							}
						}
					}
				});
				/*fin de llamada ajax*/
			} else {
				alert("Eliga el Ubigeo");
				ubicacion.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
				ubicacion.prop('disabled', true); //deshabilitar el select
			}
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
	?>
    </pre>-->
<div class="main-container">
	<div class="row gutter">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-light panel-blue">
				<div class="panel-heading">
					<h4>Formulario de Edición de Activos</h4>
				</div>
				<div class="panel-body">
					<?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Código de Producto</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="producto" id="producto" placeholder="Ingresa codigo..." value="<?php echo $codigo->codigo_producto; ?>">
							<?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Código RFID</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="rfid" id="rfid" placeholder="Ingresa codigo..." value="<?php echo $codigo_rfid[0]["codigo_rfid"]; ?>">
							<?php echo form_error('codigo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Descripción</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa descripcion..." value="<?php echo $codigo->descripcion; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Valor</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="valor" id="valor" placeholder="Ingresa valor..." value="<?php echo $codigo->valor; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Unidad de Medida</label>
						<div class="col-md-4 ">
							<select class="form-control" name="unidad_medida" id="unidad_medida">
								<option value="<?php echo $codigo->unidad_medida; ?>"><?php echo $codigo->unidad_medida; ?></option>
								<option value="Empaque">Empaque</option>
								<option value="Paquete">Paquete</option>
								<option value="Pallet">Pallet</option>
							</select>
							<?php echo form_error('unidad_medida', '<span class="label label-danger	">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-md-4 control-label">Cantidad</label>
						<div class="col-md-4"><input type="text" class="form-control" placeholder="cantidad" value="<?php echo $codigo->cantidad; ?>" id="cantidad" name="cantidad" required></div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Cliente</label>
						<div class="col-md-4 ">
							<select class="form-control" name="cliente" id="cliente">
								<option value="<?php echo $codigo->cliente; ?>"><?php echo $codigo->cliente; ?></option>
								<?php foreach ($clientes as $indice => $cliente)
									foreach ($cliente as $tipo => $valor) : ?>
									<option value="<?php echo $valor; ?>"><?php echo $indice . "." . $valor ?></option>
								<?php endforeach ?>
							</select>
							<?php echo form_error('cliente', '<span class="label label-danger	">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Ubigeo</label>
						<div class="col-md-4 ">
							<select class="form-control" name="ubigeo" id="ubigeo">
								<option value="<?php echo $codigo->ubigeo; ?>"><?php echo $codigo->ubigeo; ?></option>
								<?php foreach ($ubigeo as $indice => $zona)
									foreach ($zona as $indice => $valor) : ?>
									<option value="<?php echo $valor; ?>"><?php echo $valor ?></option>
								<?php endforeach ?>
							</select>
							<?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Ubicación</label>
						<div class="col-md-4">
							<select class="form-control" name="ubicacion" id="ubicacion">
								<option value="<?php echo $codigo->ubicacion; ?>"><?php echo $codigo->ubicacion; ?></option>
							</select>
							<?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Peso</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="peso" id="peso" placeholder="Ingresa peso..." value="<?php echo $codigo->peso; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Ancho</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="ancho" id="ancho" placeholder="Ingresa ancho..." value="<?php echo $codigo->ancho; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Profundidad</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="profundidad" id="profundidad" placeholder="Ingresa profundidad..." value="<?php echo $codigo->profundidad; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Lote</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="lote" id="lote" placeholder="Ingresa lote..." value="<?php echo $codigo->lote; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Orden de Ingreso</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="ingreso" id="ingreso" placeholder="Ingresa Orden ingreso..." value="<?php echo $codigo->orden_ingreso; ?>">
							<?php echo form_error('descripcion', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 control-label" style="float: left; width: 225px">
							<a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_aviso">Enviar</button></a>
						</div>
						<div style="float: right; width: 225px">
							<a class="btn btn-primary" href="admin/inventario/editar_activos">Atrás</a>
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
					<h4>EDICIÓN DE ACTIVOS MATRICULADOS</h4>
				</div>
				<div class="panel-body table-responsive">
					<table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
						<thead>
							<tr>
								<th style="text-align:center">ITEM</th>
								<th style="text-align:center">CÓDIGO DE PRODUCTO</th>
								<th style="text-align:center">CÓDIGO RFID</th>
								<th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
								<th style="text-align:center">CLIENTE</th>
								<th style="text-align:center">VALOR</th>
								<th style="text-align:center">UNIDAD DE MEDIDA</th>
								<th style="text-align:center">CANTIDAD</th>
								<th style="text-align:center">UBIGEO</th>
								<th style="text-align:center">UBICACION</th>
								<th style="text-align:center">ANCHO</th>
								<th style="text-align:center">PROFUNDIDAD</th>
								<th style="text-align:center">PESO</th>
								<th style="text-align:center">LOTE</th>
								<th style="text-align:center">ORDEN DE INGRESO</th>
								<th style="text-align:center">FECHA DE INGRESO</th>
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
</div>
<!--    MODAL AVISO-->
<!-- <div class="modal fade" tabindex="-1" role="dialog" id="miModal">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-body">
               <h4>No  se realizo ningun cambio</h4>
            </div>
            <div class="modal-footer">
               <a type="button" class="btn btn-primary aceptar">Aceptar</a>
            </div>
         </div>
	</div>
</div> -->
<!-- /.modal-content -->
<!-- /.modal-dialog -->
<!-- /.modal -->
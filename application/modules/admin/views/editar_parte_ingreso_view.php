<div class="row-fluid">
	<h1>
		<center>Editar Parte de Ingreso</center>
	</h1>
</div>
<script>
	$(function() {
		let repetir = function() {
			$.ajax({
				url: "admin/inventario/get_parte_ingreso",
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
                        fila += "<td>" + respuesta[ind].correlativo + "</td>";
                        fila += "<td>" + respuesta[ind].cliente + "</td>";
                        fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                        fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                        fila += "<td>" + respuesta[ind].guia_remision + "</td>";
                        fila += "<td>" + respuesta[ind].nro_dua + "</td>";
                        fila += "<td>" + respuesta[ind].jefe_almacen + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_parte + "</td>";
                        fila += "<td>" + respuesta[ind].fecha_ingreso + "</td>";
                        fila += "<td>" + respuesta[ind].total_items + "</td>";
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
					<h4>Formulario de Edición de Parte de Ingresos</h4>
				</div>
				<div class="panel-body">
					<?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Correlativo</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="correlativo" id="correlativo" value="<?php echo $codigo->correlativo; ?>">
							<?php echo form_error('correlativo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Guía de Remisión</label>
						<div class="col-md-4">
							<input type="text" readonly="readonly" class="form-control" name="guia_remision" id="guia_remision" value="<?php echo $codigo->guia_remision; ?>">
							<?php echo form_error('guia_remision', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Nro DUA</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nro_dua" id="nro_dua"  value="<?php echo $codigo->nro_dua; ?>">
							<?php echo form_error('nro_dua', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Jefe de Almacen</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="jefe_almacen" id="jefe_almacen" value="<?php echo $codigo->jefe_almacen; ?>">
							<?php echo form_error('jefe_almacen', '<span class="label label-danger">', '</span>'); ?>
						</div>
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
						<div class="col-md-2 control-label" style="float: left; width: 225px">
							<a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_aviso">Enviar</button></a>
						</div>
						<div style="float: right; width: 225px">
							<a class="btn btn-primary" href="admin/inventario/partes_ingreso">Atrás</a>
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
					<h4>PARTES DE INGRESO</h4>
				</div>
				<div class="panel-body table-responsive">
					<table class="table danger table-striped no-margin text-center" id="tbl_inventario" class="display">
						<thead>
							<tr>
							<th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CORRELATIVO</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACION</th>
                                <th style="text-align:center">GUÍA DE REMISIÓN</th>
                                <th style="text-align:center">NRO DUA</th>
                                <th style="text-align:center">JEFE DE ALMACÉN</th>
                                <th style="text-align:center">FECHA DE PARTE</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">TOTAL ITEMS</th>
                
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
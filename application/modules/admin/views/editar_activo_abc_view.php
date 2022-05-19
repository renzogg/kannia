<div class="row-fluid">
	<h1>
		<center>Editar Activo Matriculado</center>
	</h1>
</div>
<script>
	$(document).ready(function() {
      var table = $('#tbl_inventario').DataTable({
         responsive: true,
         "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
         "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
            title: 'Edición de Activos'
         }],
         "ajax": {
            url: "<?php echo site_url('admin/inventario/get_activos_vinculados_excel'); ?>",
            type: "post"
         },
         "columns": [
            {"data": "id"},
            {"data": "nro_dua"},
            {"data": "guia_remision"},
            {"data": "correlativo"},
            {"data": "item"},
            {"data": "codigo"},
            {"data": "codigo_rfid"},
            {"data": "ubigeo"},
            {"data": "ubicacion"},
            {"data": "cliente"},
            {"data": "familia_producto"},
            {"data": "descripcion"},
            {"data": "cantidad"},
            {"data": "unidad_medida"},
            {"data": "fecha_vinculacion"}
         ],
         "bdestroy": true,
         "rowCallback": function(row, data, index) {
            if (data['familia_producto'] == "ZOCALO") {
               $('td', row).css('background-color', '#fcf75e');
            } else if (data['familia_producto'] == "VERSA") {
               $('td', row).css('background-color', '#0096d2');
            } else if (data['familia_producto'] == "SILENT") {
               $('td', row).css('background-color', 'lightcoral');
            } else if (data['familia_producto'] == "SUBSUELO") {
               $('td', row).css('background-color', 'chocolate');
            } else if (data['familia_producto'] == "TRANSISTOP") {
               $('td', row).css('background-color', 'yellow');
            } else if (data['familia_producto'] == "PERFIL") {
               $('td', row).css('background-color', 'rosybrown');
            } else if (data['familia_producto'] == "PISO") {
               $('td', row).css('background-color', 'Palegreen');
            } else if (data['familia_producto'] == "CINTA") {
               $('td', row).css('background-color', '#3492ae');
            } else if (data['familia_producto'] == "SELLADOR") {
               $('td', row).css('background-color', 'aquamarine');
            } else if (data['familia_producto'] == "ESPUMA") {
               $('td', row).css('background-color', '#db9b88');
            }else if (data['familia_producto'] == "PERGO") {
               $('td', row).css('background-color', '#48DEFA');
            }
         },
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
							<input type="text" readonly="readonly" class="form-control" name="producto" id="producto" placeholder="Ingresa codigo..." value="<?php echo $codigo->codigo; ?>">
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
						<label for="inputEmail3" class="col-md-4 control-label">Nro DUA</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nro_dua" id="nro_dua" placeholder="Ingresa nro_dua..." value="<?php echo $codigo->nro_dua; ?>">
							<?php echo form_error('nro_dua', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Guia de Remisión</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="guia_remision" id="guia_remision" placeholder="Ingresa guia remision..." value="<?php echo $codigo->guia_remision; ?>">
							<?php echo form_error('guia_remision', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Nro Parte de Ingreso</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="correlativo" id="correlativo" placeholder="Ingresa nro parte de ingreso..." value="<?php echo $codigo->correlativo; ?>">
							<?php echo form_error('correlativo', '<span class="label label-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-md-4 control-label">Item</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="item" id="item" placeholder="Ingresa item..." value="<?php echo $codigo->item; ?>">
							<?php echo form_error('item', '<span class="label label-danger">', '</span>'); ?>
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
						<label for="inputEmail3" class="col-md-4 control-label">Familia del producto</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="familia_producto" id="familia_producto" placeholder="Ingresa familia del producto..." value="<?php echo $codigo->familia_producto; ?>">
							<?php echo form_error('familia_producto', '<span class="label label-danger">', '</span>'); ?>
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
							<th style="text-align:center">N° DUA</th>
							<th style="text-align:center">GUIA DE REMISIÓN</th>
							<th style="text-align:center">N° DE PARTE DE INGRESO</th>
							<th style="text-align:center">ITEM</th>
							<th style="text-align:center">CÓDIGO</th>
							<th style="text-align:center">CÓDIGO RFID</th>
							<th style="text-align:center">UBIGEO</th>
							<th style="text-align:center">UBICACIÓN</th>
							<th style="text-align:center">CLIENTE</th>
							<th style="text-align:center">FAMILIA PRODUCTO</th>
							<th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
							<th style="text-align:center">CANTIDAD</th>
							<th style="text-align:center">UNIDAD DE MEDIDA</th>
							<th style="text-align:center">FECHA DE VINCULACIÓN</th>
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
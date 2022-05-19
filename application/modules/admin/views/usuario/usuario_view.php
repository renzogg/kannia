<link rel="stylesheet" type="text/css" href="static/main/js/datatable/css/dataTables.bootstrap.min.css">
 

<script type="text/javascript" charset="utf8" src="static/main/js/datatable/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="static/main/js/datatable/js/dataTables.bootstrap.min.js"></script>


<script>
	$(function () {
	    $('#table_id').DataTable({
	    	language: {
				    "decimal":        "",
				    "emptyTable":     "No hay datos en la tabla",
				    "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
				    "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
				    "infoFiltered":   "(filtrando de _MAX_ total de entradas)",
				    "infoPostFix":    "",
				    "thousands":      ",",
				    "lengthMenu":     "Mostrar _MENU_ entradas",
				    "loadingRecords": "Cargando...",
				    "processing":     "Procesando...",
				    "search":         "Buscar:",
				    "zeroRecords":    "No se encontraron registros coincidentes",
				    "paginate": {
				        "first":      "Primero",
				        "last":       "Ultimo",
				        "next":       "Siguiente",
				        "previous":   "Anterior"
				    },
				    "aria": {
				        "sortAscending":  ": Activar para ordenar la columna ascendente",
				        "sortDescending": ": activar para ordenar la columna Descendente"
				    }
			}
		    
	    });
		    $('.boton_eliminar').click(function () {
		    	$('#miModal').modal();
		    	var pk = $(this).attr('pk');
		    	$('.eliminar').attr('href','admin/usuario/eliminar/'+pk);
		    });
	} );
</script>
<br>
<br>
<br>
<h1>Usuarios</h1>
<br>
<div class="row-fluid">
	<a class="btn btn-info" href="admin/usuario/agregar"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Usuario</a>
	<!--<a class="btn btn-warning boton_excel_export" href="admin/reporte_usuario/exportarExcel"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Exportar Excel</a>-->
</div> 

<br>
<br>

<div class="row-fluid">

	<table class="table table-bordered"  id="table_id" class="display">
			<thead>
				<tr>
					<th style="text-align:center">Item</th>
					<th style="text-align:center">Usuario</th>
					<th style="text-align:center">Estado</th>
					<th style="text-align:center"></th>
					<th style="text-align:center"></th>

				</tr>
			</thead>
		
		<tbody>
		 
         <?php foreach ($usuario_all as $key=>$value): ?>
     		<tr>
					<!--<td style="text-align:center" ><?php echo ($value->id) ; ?></td>-->
					<td style="text-align:center" ><?php echo ($key+1) ; ?></td>
					<td style="text-align:center"><?php echo ($value->usuario) ; ?></td>
					<td style="text-align:center"><?php
					if (($value->estado) == 1){
						echo "ACTIVO";
					} 
					else{
						echo "INACTIVO";
					};

					 ?></td>
					<td style="text-align:center"><a href="admin/usuario/editar/<?php echo $value->id; ?>" class="btn btn-primary">Editar</a></td>

					<!--<td style="text-align:center"><a href="admin/usuario/eliminar/<?php echo $value->id; ?>" class="btn btn-danger" class="btn btn-danger boton_eliminar">Eliminar</a></td>-->

					
		        	<td style="text-align:center" class="botones"><button class="btn btn-danger boton_eliminar" pk="<?php echo $value->id; ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar</button></td>
		      

			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<tr> <td>Cantidad de Usuarios : <?php echo count($usuario_all) ?></td> </tr>

	<div class="modal fade" tabindex="-1" role="dialog" id="miModal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
	        <h4>¿Desea eliminar este Usuario?</h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <a type="button" class="btn btn-primary eliminar">Eliminar</a>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


</div>




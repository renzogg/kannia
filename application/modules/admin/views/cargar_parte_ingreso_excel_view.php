<div class="row-fluid">
    <h1>
        <center>CARGAR PARTE DE INGRESO DESDE EXCEL</center>
    </h1>
</div>


<br>


<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-blue">
                <div class="panel-heading">
                    <h4>Formulario para Cargar Activos desde un archivo excel</h4>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="admin/inventario/cargar_parte_ingreso_excel"
                        method="POST" id="form_cargar">
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubigeo</label>
                            <div class="col-sm-7 ">
                                <select class="form-control js-example-basic-single" name="ubigeo" id="ubigeo">
                                    <option value="">Elegir</option>
                                    <?php foreach ($ubigeo as $indice => $zona)
                                        foreach ($zona as $indice => $valor) : ?>
                                    <option value="<?php echo $valor; ?>"><?php echo $valor ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row gutter">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
                            <div class="col-sm-7 ">
                                <select class="form-control js-example-basic-single2" name="ubicacion" id="ubicacion"
                                    disabled>
                                    <option value="">Elegir</option>
                                </select>
                                <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="form-group row gutter">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <input type="file" class="filestyle" data-buttonText="Seleccione archivo" id="excel"
                                        name="excel">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <button id="upload" type="button">IMPORTAR</button>
                            </div>
                            <input type="hidden" value="upload" name="action" />
                            <input type="hidden" value="usuarios" name="mod">
                            <input type="hidden" value="masiva" name="acc">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-green">
                <div class="panel-heading">
                    <h4>ITEMS DEL PARTE DE INGRESO CARGADO EN EXCEL</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger text-center display" id="tbl_excel">
                        <thead>
                            <tr>
                                <th style="text-align:center">ID</th>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">N° DUA</th>
                                <th style="text-align:center">GUIA DE REMISIÓN</th>
                                <th style="text-align:center">CORRELATIVO</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACIÓN</th>
                                <th style="text-align:center">CÓDIGO</th>
                                <th style="text-align:center">CLIENTE</th>
                                <th style="text-align:center">FAMILIA PRODUCTO</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">CANTIDAD</th>
                                <th style="text-align:center">UNIDAD DE MEDIDA</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">FECHA DE PARTE</th>
                                <th style="text-align:center">JEFE DE ALMACÉN</th>
                                <th style="text-align:center">OBSERVACIONES</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- BOTON LIMPIAR TABLA EXCEL-->
        <div style="float: right; width: 225px">
            <a data-target="#miModal" data-toggle="miModal"><button type="submit"
                    class="btn btn-success btn_reiniciar">Limpiar tabla excel</button></a>
        </div>
        <!--FIN DE BOTON-->
    </div>
    <!--    MODAL CONFIRMAR LIMPIAR TABLA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModal" style="max-width: inherit;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>¿Desea Limpiar los registros de la tabla?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-primary reiniciar">Limpiar</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2()
    $('.js-example-basic-single2').select2()
    var table = $('#tbl_excel').DataTable({
        scrollX: true,
        responsive: true,
        "dom": "<'row'<'col-sm-3'B><'col-sm-3 text-center'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Exportar a Excel',
            title: 'Cargar Parte de Ingreso desde Excel'
        }],
        "ajax": {
            url: "<?php echo site_url('admin/inventario/get_items_parte_ingreso_excel'); ?>",
            type: "get"
        },
        "columns": [{
                "data": "id"
            },
            {
                "data": "item"
            },
            {
                "data": "nro_dua"
            },
            {
                "data": "guia_remision"
            },
            {
                "data": "correlativo"
            },
            {
                "data": "ubigeo"
            },
            {
                "data": "ubicacion"
            },
            {
                "data": "codigo"
            },
            {
                "data": "cliente"
            },
            {
                "data": "familia_producto"
            },
            {
                "data": "descripcion"
            },
            {
                "data": "cantidad"
            },
            {
                "data": "unidad_medida"
            },
            {
                "data": "fecha_ingreso"
            },
            {
                "data": "fecha_parte"
            },
            {
                "data": "jefe_almacen"
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    if (data['observaciones'] == "") {
                        return '<h4><span class="label label-warning">Sin Observaciones</span></h4>';
                    } else {
                        return data['observaciones'];
                    }
                }
            }
        ],
        "bdestroy": true,
        "rowCallback": function(row, data, index) {
            if (data['familia_producto'] == "ZOCALO") {
                $('td', row).css('background-color', '#fcf75e');
            } else if (data['familia_producto'] == "MUESTRA") {
                $('td', row).css('background-color', '#FAEF48');
            } else if (data['familia_producto'] == "PLLSA") {
                $('td', row).css('background-color', '#DA7C46');
                $('td', row).css('color', '#FFFFFF');
            } else if (data['familia_producto'] == "SUBSUELO") {
                $('td', row).css('background-color', 'chocolate');
            } else if (data['familia_producto'] == "PERGO") {
                $('td', row).css('background-color', '#48DEFA');
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
            } else if (data['familia_producto'] == "SILENT") {
                $('td', row).css('background-color', '#06788E');
                $('td', row).css('color', '#FFFFFF');
            } else if (data['familia_producto'] == "TRANSITSTOP") {
                $('td', row).css('background-color', '#369C4B');
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
        console.log("chris")
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
                            $("#ubicacion").append(new Option(response[ind]["ubicacion"]),
                                response[ind]["ubicacion"]);
                        }
                    }
                }
            });
            /*fin de llamada ajax*/
        } else {
            alert("Eliga el Ubigeo");
            ubicacion.val(
                ''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            ubicacion.prop('disabled', true); //deshabilitar el select
        }
    });
});
// MODAL DE LIMPIAR TABLA
$("body").on("click", ".btn_reiniciar", function() {
    //$('#miModal').modal('show'); //<-- you should use show in this situation
    $('#miModal').modal();
    $('.reiniciar').attr('href', 'admin/inventario/limpiar_tabla_items');
});
//ENVIAR DATA PARA CARGAR PARTE DE INGRESO
$(document).ready(function() {
    $('#upload').on('click', function() {
        var file_data = $('#excel').prop('files')[0];
        var form_data = new FormData();
        form_data.append('excel', file_data);
        form_data.append('action', 'upload');
        form_data.append('ubigeo', $('#ubigeo').prop('value'));
        form_data.append('ubicacion', $('#ubicacion').prop('value'));

        console.log(file_data);
        $.ajax({
            url: 'admin/inventario/cargar_parte_ingreso_excel', // <-- point to server-side PHP script 
            dataType: 'text', // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(resultado) {
                console.log(resultado);
                //alert(php_script_response); // <-- display response from the PHP script, if any
                jAlert(resultado, "Mensaje");
                //refreshTable();
                document.getElementById("form_cargar").reset();
                setTimeout(function() {
                    document.location.reload(); //Actualiza la pagina
                }, 2000);
            },
            error: function(error) {
                alert('ERROR!');
                //                $.unblockUI();
            }
        });
    });
});
</script>
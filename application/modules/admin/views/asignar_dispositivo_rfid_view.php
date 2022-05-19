<style>
div.relative {
    position: relative;
    left: 500px;
}
</style>
<script>
$(function() {
    let repetir = function() {
        $.ajax({
            url: "admin/dispositivo_rfid/get_dispositivo_rfid",
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
                    fila += "<td>" + respuesta[ind].mac + "</td>";
                    fila += "<td>" + respuesta[ind].ubigeo + "</td>";
                    fila += "<td>" + respuesta[ind].ubicacion + "</td>";
                    fila += "<td>" + respuesta[ind].actividad + "</td>";
                    fila += "<td>" + respuesta[ind].usuario + "</td>";
                    fila += "<td>" + respuesta[ind].date + "</td>";
                    fila += "</tr>";
                    tabla += fila;
                }
                $("#cuerpo").html(tabla);

                $("#tbl_dispositivos").DataTable({
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
    //BLOQUEAR UBIGEO Y UBICACION
    var actividad = $('#actividad');
    $("#actividad").change(function() {
        console.log("chris")
        console.log($("#ubigeo").val());
        console.log($("#ubicacion").val());
        var actividad = $(this).val(); //obtener el id seleccionado
        if (actividad != "" && actividad ==
            "RECIBO DE DEPOSITO") { //verificar haber seleccionado una opcion valida
            $("#ubigeo").prop('disabled', true); //habilitar el select
            $("#ubicacion").prop('disabled', true); //habilitar el select
        } else {
            $("#ubigeo").prop('disabled', false); //habilitar el select
            $("#ubicacion").prop('disabled', false); //habilitar el select
        }
    });
});
//LLAMAR MAC
$(function() {

    let llamar_chip = function() {

        $.ajax({
            url: "admin/dispositivo_rfid/get_ultimo_mac",
            type: "post",
            data: {},
            dataType: "json",
            error: function(ee) {
                console.log(ee);
            },
            success: function(response) {
                console.log(response.respuesta)
                var mac = response.respuesta;
                document.getElementById("mac").value = mac;
                // console.log(response)
                //console.log("Depurar");
            }
        });
    }
    setInterval(function() {
        if ($('#Manual').is(':checked')) {
            document.getElementById("mac").value = "00:00:00:00:00:00"
        } else {
            llamar_chip();
        }

    }, 1000);

});

//ENVIAR DATA
$(function() {
    $("#form_dispositivos").submit(function(event) {
        event.preventDefault();
        var datos = $(this).serialize(),
            url = $(this).attr('action');
        console.log(datos);

        $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "html",
            success: function(resultado) {
                jAlert(resultado, "Mensaje");
                //console.log(data);
                //refreshTable();
                document.getElementById("form_dispositivos").reset();
                setTimeout(function() {
                    document.location.reload(); //Actualiza la pagina
                }, 20000);
            },
            error: function(error) {
                alert('ERROR!');
                //                $.unblockUI();
            }
        });
        return false; //stop the actual form post !important!
    });
});
</script>



<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-blue">
                <div class="panel-heading">
                    <h4>Formulario de Asignación de Dispositivos RFID</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_dispositivos" method="post"
                        action="<?php echo base_url('admin/dispositivo_rfid/add_dispositivo_rfid') ?>"
                        enctype="multipart/form-data">
                        <div class="form-group row gutter">
                            <label for="inputPassword3" class="col-sm-2 control-label">MAC</label>
                            <div class="col-sm-7"><input type="text" class="form-control" placeholder="MAC" id="mac"
                                    name="mac" required></div>
                            <input name="Manual" id="Manual" type="checkbox">

                            <label for="Manual">Manual</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Actividad</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="actividad" id="actividad" required>
                                    <option value="">Elegir</option>
                                    <option value="MATRICULA DE ACTIVOS">Matrícula</option>
                                    <option value="PRE - INVENTARIADO">Pre - Inventario</option>
                                    <option value="RECIBO DE DEPOSITO">Recibo de Depósito</option>
                                    <option value="INVENTARIADO">Inventariado</option>
                                    <option value="PROGRAMACION DE SALIDA">Programación de Salida</option>
                                    <option value="SALIDA DE ACTIVOS">Salidas de Activos</option>
                                </select>
                                <?php echo form_error('actividad', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubigeo</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubigeo" id="ubigeo" required>
                                    <option value="">Elegir</option>
                                    <?php foreach ($ubigeo as $indice => $zona)
                              foreach ($zona as $indice => $valor) : ?>
                                    <option value="<?php echo $valor; ?>"><?php echo $valor ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php echo form_error('ubigeo', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ubicación</label>
                            <div class="col-sm-7 ">
                                <select class="form-control" name="ubicacion" id="ubicacion" disabled>
                                    <option value="">Elegir</option>
                                </select>
                                <?php echo form_error('ubicacion', '<span class="label label-danger	">', '</span>'); ?>
                            </div>
                            <button type="submit" class="btn btn-success" id="guardar">Asignar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-light panel-brown">
                <div class="panel-heading">
                    <h4>LISTA DE DISPOSITIVOS RFID ASIGNADOS</h4>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table danger table-striped no-margin text-center" id="tbl_dispositivos"
                        class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">MAC</th>
                                <th style="text-align:center">UBIGEO</th>
                                <th style="text-align:center">UBICACION</th>
                                <th style="text-align:center">ACTIVIDAD</th>
                                <th style="text-align:center">USUARIO</th>
                                <th style="text-align:center">FECHA DE ASIGNACION</th>
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
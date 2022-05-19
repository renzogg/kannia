<link rel="stylesheet" href="./dist/styles.css">
<link rel="stylesheet" href="./dist/all.css">
<div class="row-fluid">
</div>
<br>

<style>
    .filaPresente{background-color: PaleGreen !important;}
</style>
<script>
    $(function() {
        let repetir = function() {
            $.ajax({
                url: "admin/inventario_tiempo_real/get_inventario_tiempo_real",
                type: "post",
                data: {},
                dataType: "json",
                success: function(response) {
                    var respuesta = response.data;
                    var tabla = "";

                    for (ind in respuesta) {
                        var fila = "<tr>";
                        if (respuesta[ind].estado == "1") {
                            fila += "<td class='filaPresente'>" + respuesta[ind].id + "</td>";
                            fila += "<td class='filaPresente'>" + respuesta[ind].cod_producto + "</td>";
                            fila += "<td class='filaPresente'>" + respuesta[ind].cod_rfid + "</td>";
                            fila += "<td class='filaPresente'>" + respuesta[ind].descripcion + "</td>";
                            fila += "<td class='filaPresente'>" + respuesta[ind].orden_ingreso + "</td>";
                            fila += "<td class='filaPresente'>" + respuesta[ind].date + "</td>";
                            fila += "<td class='filaPresente'><span class = 'label label-success'>PRESENTE</span></td>";
                            document.getElementById("caja_encontrados").textContent = respuesta[ind].encontrados;
                            document.getElementById("caja_no_encontrados").textContent =  parseInt(respuesta[ind].total_activos) - parseInt(respuesta[ind].encontrados);
                        } else {
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].id + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].cod_producto + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].cod_rfid + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].descripcion + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].orden_ingreso + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'>" + respuesta[ind].date + "</td>";
                            fila += "<td style = 'background-color: rgb(255,161,155);'><span class = 'label label-danger'>FALTANTE</span></td>";
                        }
                        fila += "</tr>";
                        tabla += fila;
                        //console.log(parseInt(respuesta[ind].total_activos) - parseInt(respuesta[ind].encontrados));    
                    }
                    $("body").on("click", ".btn_reiniciar", function() {
                        //$('#miModal').modal('show'); //<-- you should use show in this situation
                        $('#miModal').modal();
                        $('.reiniciar').attr('href', 'admin/inventario_tiempo_real/reiniciar_inventariado');
                    });
                    $("#cuerpo").html(tabla);
                }
            });
        }
        setInterval(function() {
            repetir();
        }, 1000);
    });
</script>

<div class="main-container">
    <div class="row gutter">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--INICIO PANEL AZUL QUE ENGLOBA TODO (TABLA, PANELES, BOTONES)-->
            <div class="panel panel-light panel-facebook">
                <!-- Stats Row Starts Here -->
                <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                    <div class="shadow-lg bg-red-vibrant border-l-8 hover:bg-red-vibrant-dark border-red-vibrant-dark mb-2 p-2 md:w-1/4 mx-2" >
                        <div class="p-4 flex flex-col" name="caja_no_encontrados" >
                            <a id="caja_no_encontrados" href="#" class="no-underline text-white text-2xl">
                                
                            </a>
                            <a href="#" class="no-underline text-white text-lg">
                                NO ENCONTRADOS
                            </a>
                        </div>
                    </div>

                    <div class="shadow bg-info border-l-8 hover:bg-info-dark border-info-dark mb-2 p-2 md:w-1/4 mx-2">
                        <div class="p-4 flex flex-col">
                            <a href="#" class="no-underline text-white text-2xl">
                                <?php echo $num_vinculados; ?>
                            </a>
                            <a href="#" class="no-underline text-white text-lg">
                                TOTAL DE ACTIVOS
                            </a>
                        </div>
                    </div>

                    <div class="shadow bg-warning border-l-8 hover:bg-warning-dark border-warning-dark mb-2 p-2 md:w-1/4 mx-2">
                        <div class="p-4 flex flex-col">
                            <a href="#" class="no-underline text-white text-2xl">
                                
                            </a>
                            <a href="#" class="no-underline text-white text-lg">
                                INVENTARIO TIEMPO REAL
                            </a>
                        </div>
                    </div>

                    <div class="shadow bg-success border-l-8 hover:bg-success-dark border-success-dark mb-2 p-2 md:w-1/4 mx-2">
                        <div class="p-4 flex flex-col">
                            <a id="caja_encontrados" href="#" class="no-underline text-white text-2xl">
                            
                            </a>
                            <a href="#" class="no-underline text-white text-lg">
                                ACTIVOS LEIDOS
                            </a>
                        </div>
                    </div>
                </div>

                <!-- /Stats Row Ends Here -->
                <!--INICIO PANEL AZUL DONDE VA TITULO DE TABLA-->
                <div class="panel-heading">
                    <h4>Tabla INVENTARIO DE ACTIVOS MATRICULADOS - REAL TIME</h4>
                    <!-- BOTON REINICIAR INVENTARIO-->
                    <div style="float: right; width: 225px">
                        <a data-target="#miModal" data-toggle="miModal"><button type="submit" class="btn btn-success btn_reiniciar">Reiniciar Inventariado</button></a>
                    </div>
                    <!--FIN DE BOTON-->
                </div>
                <!--FIN DE PANEL AZUL-->

                <!--INICIO PANEL DONDE VA TABLA-->
                <div class="panel-body">
                    <!--INICIO TABLA-->
                    <table class="table danger table-striped no-margin text-center" id="tbl_vinculacion" class="display">
                        <thead>
                            <tr>
                                <th style="text-align:center">ITEM</th>
                                <th style="text-align:center">CÓDIGO DE PRODUCTO</th>
                                <th style="text-align:center">CÓDIGO RFID</th>
                                <th style="text-align:center">DESCRIPCIÓN DE ACTIVO</th>
                                <th style="text-align:center">ORDEN DE INGRESO</th>
                                <th style="text-align:center">FECHA DE INGRESO</th>
                                <th style="text-align:center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">
                        </tbody>
                    </table>
                    <!--FIN DE TABLA-->
                </div>
                <!--FIN DE PANEL AZUL-->
            </div>
            <!--FIN DE PANEL-->
        </div>
    </div>
    <!--    MODAL CONFIRMAR REINICIO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="miModal" style="max-width: inherit;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4>¿Desea reiniciar el inventariado?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a type="button" class="btn btn-primary reiniciar">Reiniciar</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
</div>

    
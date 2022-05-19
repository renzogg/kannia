<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="tailwind,tailwindcss,tailwind css,css,starter template,free template,admin templates, admin template, admin dashboard, free tailwind templates, tailwind example">
    <!-- Css -->
    <link rel="stylesheet" href="./dist/styles.css">
    <link rel="stylesheet" href="./dist/all.css">
<!--     <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i,700,700i" rel="stylesheet">
 -->    <title>Dashboard | Inventario RFID</title>
</head>

<body>
<!--Container -->
<div class="mx-auto bg-grey-400">
    <!--Screen-->
    <div class="min-h-screen flex flex-col">
        <div class="flex flex-1">
            <main class="bg-white-300 flex-1 p-3 overflow-hidden">

                <div class="flex flex-col">
                    <!-- Stats Row Starts Here -->
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                        <div class="shadow-lg bg-red-vibrant border-l-8 hover:bg-red-vibrant-dark border-red-vibrant-dark mb-2 p-2 md:w-1/4 mx-2">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">
                                <?php echo $num_salidas; ?>
                                </a>
                                <a href="#" class="no-underline text-white text-lg">
                                    Total Salidas
                                </a>
                            </div>
                        </div>

                        <div class="shadow bg-info border-l-8 hover:bg-info-dark border-info-dark mb-2 p-2 md:w-1/4 mx-2">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">
                                <?php echo $num_programados; ?>
                                </a>
                                <a href="#" class="no-underline text-white text-lg">
                                    Salidas Programadas
                                </a>
                            </div>
                        </div>

                        <div class="shadow bg-warning border-l-8 hover:bg-warning-dark border-warning-dark mb-2 p-2 md:w-1/4 mx-2">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">
                                <?php echo $num_no_programados; ?>
                                </a>
                                <a href="#" class="no-underline text-white text-lg">
                                    Sin Programar
                                </a>
                            </div>
                        </div>

                        <div class="shadow bg-success border-l-8 hover:bg-success-dark border-success-dark mb-2 p-2 md:w-1/4 mx-2">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">
                                <?php echo $num_no_programados+$num_salidas; ?>
                                </a>
                                <a href="#" class="no-underline text-white text-lg">
                                    Total de Ingresos
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- /Stats Row Ends Here -->

                    <!-- Card Sextion Starts Here -->
                    <!--TABLA DE RESUMEN DE MOVIMIENTOS-->
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">MOVIMIENTO DE ACTIVOS</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-grey-darkest">
                                    <thead class="bg-grey-dark text-white text-normal">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Evento</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Porcentaje</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cuerpo">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <button class="bg-red-500 hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Salidas
                                            </button>
                                        </td>
                                        <td><?php echo $num_salidas; ?></td>
                                        <td>
                                            <span class="text-red-500"><i class="fas fa-arrow-down"></i><?php echo ($num_salidas*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <button class="bg-success hover:bg-primary-dark text-white font-light py-1 px-2 rounded-full">
                                                Ingresos
                                            </button>
                                        </td>
                                        <td><?php echo $num_vinculados; ?></td>
                                        <td>
                                            <span class="text-green-500"><i class="fas fa-arrow-up"></i><?php echo ($num_vinculados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <button class="bg-blue-500 hover:bg-success-dark text-white font-light py-1 px-2 rounded-full">
                                                Programados
                                            </button>
                                        </td>
                                        <td><?php echo $num_programados; ?></td>
                                        <td>
                                            <span class="text-blue-500"><?php echo ($num_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <button class="bg-warning hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Sin Programar
                                            </button>
                                        </td>
                                        <td><?php echo $num_no_programados; ?></td>
                                        <td>
                                            <span class="text-warning"><?php echo ($num_no_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!--2 TABLAS EN UNA FILA - ALMACENES-->
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">

                        <!-- card -->

                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">ALMACEN CALLAO</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-grey-darkest">
                                    <thead class="bg-info text-white text-normal">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Evento</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Porcentaje</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cuerpo">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <button class="bg-red-500 hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Salidas
                                            </button>
                                        </td>
                                        <td><?php echo $num_salidas; ?></td>
                                        <td>
                                            <span class="text-red-500"><i class="fas fa-arrow-down"></i><?php echo ($num_salidas*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <button class="bg-success hover:bg-primary-dark text-white font-light py-1 px-2 rounded-full">
                                                Ingresos
                                            </button>
                                        </td>
                                        <td><?php echo $num_vinculados; ?></td>
                                        <td>
                                            <span class="text-green-500"><i class="fas fa-arrow-up"></i><?php echo ($num_vinculados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <button class="bg-blue-500 hover:bg-success-dark text-white font-light py-1 px-2 rounded-full">
                                                Programados
                                            </button>
                                        </td>
                                        <td><?php echo $num_programados; ?></td>
                                        <td>
                                            <span class="text-blue-500"><?php echo ($num_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <button class="bg-warning hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Sin Programar
                                            </button>
                                        </td>
                                        <td><?php echo $num_no_programados; ?></td>
                                        <td>
                                            <span class="text-warning"><?php echo ($num_no_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">ALMACEN CHORRILLOS</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-grey-darkest">
                                    <thead class="bg-green-light text-white text-normal">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Evento</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Porcentaje</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cuerpo">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <button class="bg-red-500 hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Salidas
                                            </button>
                                        </td>
                                        <td><?php echo $num_salidas; ?></td>
                                        <td>
                                            <span class="text-red-500"><i class="fas fa-arrow-down"></i><?php echo ($num_salidas*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <button class="bg-success hover:bg-primary-dark text-white font-light py-1 px-2 rounded-full">
                                                Ingresos
                                            </button>
                                        </td>
                                        <td><?php echo $num_vinculados; ?></td>
                                        <td>
                                            <span class="text-green-500"><i class="fas fa-arrow-up"></i><?php echo ($num_vinculados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <button class="bg-blue-500 hover:bg-success-dark text-white font-light py-1 px-2 rounded-full">
                                                Programados
                                            </button>
                                        </td>
                                        <td><?php echo $num_programados; ?></td>
                                        <td>
                                            <span class="text-blue-500"><?php echo ($num_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <button class="bg-warning hover:bg-blue-800 text-white font-light py-1 px-2 rounded-full">
                                                Sin Programar
                                            </button>
                                        </td>
                                        <td><?php echo $num_no_programados; ?></td>
                                        <td>
                                            <span class="text-warning"><?php echo ($num_no_programados*100)/$num_vinculados; ?>%</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /card -->

                    </div>
                    <!-- /Cards Section Ends Here -->

                    <!-- Progress Bar -->
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2 mt-2">
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full pt-2">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">Barra de Progreso de Eventos</div>
                            </div>
                            <div class="">
                                <div class="w-full">
                                    <div class="shadow w-full bg-grey-light">
                                        <div class="bg-blue-500 text-xs leading-none py-1 text-center text-white"
                                             style="width: <?php echo ($num_programados*100)/$num_vinculados; ?>%"><?php echo ($num_programados*100)/$num_vinculados; ?>%
                                        </div>
                                    </div>


                                    <div class="shadow w-full bg-grey-light mt-2">
                                        <div class="bg-success text-xs leading-none py-1 text-center text-white"
                                             style="width: <?php echo ($num_vinculados*100)/$num_vinculados; ?>%"><?php echo ($num_vinculados*100)/$num_vinculados; ?>%
                                        </div>
                                    </div>


                                    <div class="shadow w-full bg-grey-light mt-2">
                                        <div class="bg-warning text-xs leading-none py-1 text-center text-white"
                                             style="width: <?php echo ($num_no_programados*100)/$num_vinculados; ?>%"><?php echo ($num_no_programados*100)/$num_vinculados; ?>%
                                        </div>
                                    </div>


                                    <div class="shadow w-full bg-grey-300 mt-2">
                                        <div class="bg-red-500 text-xs leading-none py-1 text-center text-white"
                                             style="width: <?php echo ($num_salidas*100)/$num_vinculados; ?>%"><?php echo ($num_salidas*100)/$num_vinculados; ?>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </main>
            <!--/Main-->
        </div>
        <!--Footer-->
        <footer class="bg-grey-darkest text-white p-2">
            <div class="flex flex-1 mx-auto">&copy; CC</div>
            <div class="flex flex-1 mx-auto">Distributed by:  <a href="https://www.kanniasolutions.com/" target=" _blank">Kannia Trace Solutions</a></div>
        </footer>
        <!--/footer-->

    </div>

</div>
<script src="./main.js"></script>
</body>

</html>
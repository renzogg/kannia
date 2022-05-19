<script>
    var chart; // global
    var time_set = 3000;
    var chartC1T;
    var chartC1T, chartC1H, chartC2T, chartC2H, chartC3T, chartC3H;
    //// RODILLO 1 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPointC1T() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_temp_chart'); ?>",
            data: {
                rodillo: 7
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC1T.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC1T.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC1T.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC1T.redraw();
                  // add the point
                  chartC1T.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC1T, time_set);
            },
            cache: false
        });
    }

    function addPointC1H() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_hm_chart'); ?>",
            data: {
                rodillo: 7
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC1H.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC1H.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC1H.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC1H.redraw();
                  // add the point
                  chartC1H.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC1H, time_set);
            },
            cache: false
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////
    //// RODILLO 2 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPointC2T() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_temp_chart'); ?>",
            data: {
                rodillo: 8
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC2T.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC2T.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC2T.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC2T.redraw();
                  // add the point
                  chartC2T.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC2T, time_set);
            },
            cache: false
        });
    }

    function addPointC2H() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_hm_chart'); ?>",
            data: {
                rodillo: 8
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC2H.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC2H.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC2H.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC2H.redraw();
                  // add the point
                  chartC2H.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC2H, time_set);
            },
            cache: false
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////

     //// RODILLO 3 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPointC3T() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_temp_chart'); ?>",
            data: {
                rodillo: 9
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC3T.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC3T.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC3T.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC3T.redraw();
                  // add the point
                  chartC3T.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC3T, time_set);
            },
            cache: false
        });
    }

    function addPointC3H() {
        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_last_value_hm_chart'); ?>",
            data: {
                rodillo: 9
            },
            type: 'post',
            dataType: "json",
            success: function(point2) {              
                //console.log(point2[0]);
                var series = chartC3H.series[0];
                var shift = series.data.length; // shift if the series is longer than 20
                 categories = chartC3H.xAxis[0].categories;  
                var last_date = categories[categories.length-1];
                
                if(last_date != point2[0] ){                             
                  categories.push(point2[0]);
                  chartC3H.xAxis[0].setCategories(categories, false); //redraw is false, again, so that everything will get redrawn together
                  chartC3H.redraw();
                  // add the point
                  chartC3H.series[0].addPoint(eval(point2[1]), true, shift);
                }
                // call it again after two seconds
                setTimeout(addPointC3H, time_set);
            },
            cache: false
        });
    }

    /////////////////////////////////////////////////////////////////////////////////////


    $(document).ready(function() {  
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!

      var yyyy = today.getFullYear();
      if(dd<10){
          dd='0'+dd;
      } 
      if(mm<10){
          mm='0'+mm;
      } 
      var today = dd+'/'+mm+'/'+yyyy;
        var today2 = yyyy+'-'+mm+'-'+dd;
        /////CHARTS    A1   ///////////////////////////////////////////////////////////////////////
        var optionsC1T = {
            chart: {
                renderTo: 'containerC1T',
                events: {
                    load: addPointC1T
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de temperatura - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Temperatura (°C)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " °C";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_temperature_chart'); ?>",
            data: {
                rodillo: 7,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC1T.xAxis.categories = data.categories;
                optionsC1T.series[0].name = 'Temperatura';
                optionsC1T.series[0].data = data.temperature;
                chartC1T = new Highcharts.Chart(optionsC1T);
            }
        });

        var optionsC1H = {
            chart: {
                renderTo: 'containerC1H',
                events: {
                    load: addPointC1H
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de humedad - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Humedad (%)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " %";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_humedad_chart'); ?>",
            data: {
                rodillo: 7,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC1H.xAxis.categories = data.categories;
                optionsC1H.series[0].name = 'Humedad';
                optionsC1H.series[0].data = data.humedad;

                chartC1H = new Highcharts.Chart(optionsC1H);
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
         /////CHARTS  A2     ///////////////////////////////////////////////////////////////////////
        var optionsC2T = {
            chart: {
                renderTo: 'containerC2T',
                events: {
                    load: addPointC2T
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de temperatura - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Temperatura (°C)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " °C";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_temperature_chart'); ?>",
            data: {
                rodillo: 8,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC2T.xAxis.categories = data.categories;
                optionsC2T.series[0].name = 'Temperatura';
                optionsC2T.series[0].data = data.temperature;
                chartC2T = new Highcharts.Chart(optionsC2T);
            }
        });

        var optionsC2H = {
            chart: {
                renderTo: 'containerC2H',
                events: {
                    load: addPointC2H
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de humedad - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Humedad (%)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " %";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_humedad_chart'); ?>",
            data: {
                rodillo: 8,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC2H.xAxis.categories = data.categories;
                optionsC2H.series[0].name = 'Humedad';
                optionsC2H.series[0].data = data.humedad;

                chartC2H = new Highcharts.Chart(optionsC2H);
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
         /////CHARTS  A3     ///////////////////////////////////////////////////////////////////////
        var optionsC3T = {
            chart: {
                renderTo: 'containerC3T',
                events: {
                    load: addPointC3T
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de temperatura - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Temperatura (°C)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " °C";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_temperature_chart'); ?>",
            data: {
                rodillo: 9,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC3T.xAxis.categories = data.categories;
                optionsC3T.series[0].name = 'Temperatura';
                optionsC3T.series[0].data = data.temperature;
                chartC3T = new Highcharts.Chart(optionsC3T);
            }
        });

        var optionsC3H = {
            chart: {
                renderTo: 'containerC3H',
                events: {
                    load: addPointC3H
                }

            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Monitoreo en tiempo real de humedad - ' + today,
              
            },
            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                categories: [{}]
            },
            yAxis: {
                title: {
                    text: 'Humedad (%)'
                },
                categories: [{}]
            },
            tooltip: {
                formatter: function() {
                    var s = '<b>Hora ' + this.x + '</b>';

                    $.each(this.points, function(i, point) {
                        s += '<br/>' + point.series.name + ': ' + point.y + " %";
                    });

                    return s;
                },
                shared: true
            },
            series: [{}]
        };

        $.ajax({
            url: "<?php echo site_url('admin/estadisticas/get_list_humedad_chart'); ?>",
            data: {
                rodillo: 9,
                fecha: today2
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                console.log(data);
                optionsC3H.xAxis.categories = data.categories;
                optionsC3H.series[0].name = 'Humedad';
                optionsC3H.series[0].data = data.humedad;

                chartC3H = new Highcharts.Chart(optionsC3H);
            }
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });

</script>
<div class="col-md-8 col-sm-6 col-xs-12">
                        <h3 class="page-title">ESTADISTICAS FILA DE RODILLOS C</h3>
                     </div>
                     <div class="col-md-4 col-sm-6 col-xs-12">
                   
                       </div>
                        </ul>
                        </div>
            </div>


              <div class="main-container">
               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-facebook">
                        <div class="panel-heading">
                           <h4 >RODILLO C1</h4>
                        </div>
                        <div class="panel-body">
                            <div id="containerC1T" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                             <div id="containerC1H" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                        </div>
                     </div>
                  </div>         
               </div>

               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-facebook">
                        <div class="panel-heading">
                           <h4>RODILLO C2</h4>
                        </div>
                        <div class="panel-body">
                            <div id="containerC2T" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                             <div id="containerC2H" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                        </div>
                     </div>
                  </div>         
               </div>

               <div class="row gutter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="panel panel-light panel-facebook">
                        <div class="panel-heading">
                           <h4>RODILLO C3</h4>
                        </div>
                        <div class="panel-body">
                            <div id="containerC3T" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                             <div id="containerC3H" class="col-md-6" style="width: 800px; height: 400px; margin: 0 auto"></div>
                        </div>
                     </div>
                  </div>         
               </div>

          
               
            </div>

<?php
    $ci = &get_instance();
    $ci->load->model("registro");
    date_default_timezone_set('America/Caracas');

    $datos_dep = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$this->session->departamento.'"');

    $solicitudes = $ci->registro->solicitudes_ver_listado($datos_dep[0]['id_departamento'],'1');
    $solicitudes_totales = $ci->registro->solicitudes_ver_total($datos_dep[0]['id_departamento']);
    
    $sol_declinadas = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'estado="SDE" AND');
    $sol_cotizadas = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'(estado = "COC" OR estado = "COA" OR estado = "COE" OR estado = "OCR" ) AND');
    $sol_nuevas = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'estado = "SCR" AND');
    $sol_totales = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'');
    $sol_en_proceso = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'estado = "SEP" AND');
    $sol_respondidas = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'(estado = "COE" OR estado = "OCR") AND');
    $sol_no_respuesta = $ci->registro->solicitud_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"),'(estado = "SEP" OR estado = "SCR" OR estado = "SAA") AND');

    $ord_nuevas = $ci->registro->orden_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"), 'estado="SCR" AND');
    $ord_proceso = $ci->registro->orden_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"), 'estado="SEP" AND');
    $ord_facturadas = $ci->registro->orden_ver_periodo(0000-00-00, date("Y/m/d h:i:s a"), 'estado="FAC" AND');

    if($solicitudes_totales != 0)
        $sol_departamento = ($sol_totales*100)/$solicitudes_totales;
    else
        $sol_departamento = 0;

    $satisfacion = $ci->registro->ordenes_ver('WHERE estado = "FAC"');



?>

<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Inicio</h2>
            </div>
</header>

<body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          

<!-- Dashboard Seccion de Cuentas-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="icon-user"></i></div>
                    <div class="title"><span>Nuevas</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?php echo $sol_nuevas; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-padnote"></i></div>
                    <div class="title"><span>Proceso</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 70%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?php echo $sol_en_proceso; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title"><span>Cotizada</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 40%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?php echo $sol_cotizadas; ?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>Enviada</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" aria-valuenow="{#val.value}" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?php echo $sol_respondidas; ?></strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Dashboard Cuerpo   -->
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row">
                <!-- Estadisticas -->
                <div class="statistics col-lg-3 col-12">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                    <div class="text"><strong><?php echo $ord_nuevas; ?></strong><br><small>Ordenes Nuevas</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                    <div class="text"><strong><?php echo $ord_proceso; ?></strong><br><small>Ordenes Proceso</small></div>
                  </div>
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                    <div class="text"><strong><?php echo $ord_facturadas; ?></strong><br><small>Ordenes Facturadas</small></div>
                  </div>
                </div>
                <!-- Grafica de ordenes de la empresa  -->
                <div class="chart col-lg-6 col-12">
                  <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                    <canvas id="graf_ordenes"></canvas>
                  </div>
                </div>
                <div class="chart col-lg-3 col-12">
                  <!-- Requisiciones Mensuales  -->
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-blue"><i class="fa fa-building"></i></div>
                    <div class="text"><strong><?php echo number_format($sol_departamento,2,',','.');?>%</strong><br><small>Solicitudes para el Departamento</small></div>
                  </div>
                  <!-- Satisfaccion Clientes-->
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                    <div class="text"><strong><?php echo number_format($satisfacion[0]['total'],2,',','.'); ?>%</strong><br><small>Satisfacción Clientes</small></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    
<input type="hidden" id="ord_nuevas" value="<?php echo $ord_nuevas; ?>">
<input type="hidden" id="ord_facturadas" value="<?php echo $ord_facturadas; ?>">
<input type="hidden" id="ord_proceso" value="<?php echo $ord_proceso; ?>">
    
<script>
var ctx = $("#graf_ordenes");
var ord_nuevas = $("#ord_nuevas").val();
var ord_facturadas = $("#ord_facturadas").val();
var ord_proceso = $("#ord_proceso").val();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Nuevas", "En proceso", "Facturadas",],
        datasets: [{
            data: [ord_nuevas, ord_proceso, ord_facturadas],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',         
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
         },
         tooltips: {
            enabled: false
         },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
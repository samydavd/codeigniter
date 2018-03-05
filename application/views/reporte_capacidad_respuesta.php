<?php
    $ci = &get_instance();
    $ci->load->model("registro");
    $orden = $this->_ci_cached_vars;

    $datos_dep = $ci->registro->departamentos_ver('WHERE nombre_departamento = "'.$departamento.'"');

    $solicitudes = $ci->registro->solicitudes_ver_listado($datos_dep[0]['id_departamento'],'1');
    
    $sol_declinadas = $ci->registro->solicitud_ver_periodo($desde, $hasta,'estado="SDE" AND');
    $sol_cotizadas = $ci->registro->solicitud_ver_periodo($desde, $hasta,'(estado = "COC" OR estado = "COA" OR estado = "COE" OR estado = "OCR" ) AND');
    $sol_totales = $ci->registro->solicitud_ver_periodo($desde, $hasta,'');
    $sol_en_proceso = $ci->registro->solicitud_ver_periodo($desde, $hasta,'estado = "SEP" AND');
    $sol_respondidas = $ci->registro->solicitud_ver_periodo($desde, $hasta,'(estado = "COC" OR estado = "COA" OR estado = "COE" OR estado = "OCR" OR estado = "SDE") AND');
    $sol_no_respuesta = $ci->registro->solicitud_ver_periodo($desde, $hasta,'(estado = "SEP" OR estado = "SCR" OR estado = "SAA") AND');

    $promedio_respondidas = ($sol_respondidas*100)/$sol_totales;


    /*$cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$solicitud[0]['cliente'].'"');
    //$departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'."$solicitud[0]['departamento']".'"');
    $gerente = $ci->registro->usuarios_ver('WHERE departamento = "'.$solicitud[0]['departamento'].'" AND nivel = "1" ');
    $factura = $ci->registro->factura_ver($orden[0]['id_orden']);*/

    $date1 = new DateTime("2015-02-14");
    $date2 = new DateTime("2015-02-16");
    $diff = $date1->diff($date2);

    date_default_timezone_set('America/Caracas');

    $resp_rapida = $resp_lenta = 0;
    foreach($solicitudes as $sol){
        $cotizacion = $ci->registro->cotizacion_ver($sol['id_solicitud']);
        if($cotizacion){
            $fecha1 = new DateTime($sol['fsolicitud']);
            $fecha2 = new DateTime($cotizacion[0]['fcotizacion']);
            $interval = $fecha1->diff($fecha2);
            if($interval->format('%d') < 2) $resp_rapida++;
            else $resp_lenta++;
        }
        elseif ($sol['estado'] == 'SDE')
            $resp_rapida++;
}

    
            
    
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Capacidad de Respuesta</title>
	<link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/css/fontastic.css">
    <link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/css/font_google.css">
    <link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/css/style.default.css" id="theme-stylesheet">
    <link rel="stylesheet" href="http://localhost:5050/codeIgniter/assets/css/custom.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
    <script src="http://localhost:5050/codeIgniter/js/Chart.min.js"></script>
	<style type="text/css">

	body
	{
		background: white;
		margin: 10px;
	}
	
	h2, h3
	{
		text-align: center;
	}
	

	table 
	{
    	border-collapse: collapse;
	}

	table, th, td {
	    border: 1px solid black;	    
	    text-align: center;
	    padding: 5px;	    
	}
	tr
	{
		height: 30px;
		vertical-align: middle;
	}
	.iguales tr td
	{
		width: 12.5%;
	}

	.iguales2 tr td
	{
		width: 11.1%;
	}
	</style>
</head>
<body>

<table style="margin:0 auto; width:900px">
	<tr>
		<td rowspan="3"><img src="<?php echo base_url(); ?>/logo.png" height="60"></td>
		<td><STRONG>CALIDAD Y GESTION</STRONG></td>
		<td colspan="2">Generado por</td>		
	</tr>
	<tr>		
		<td rowspan="2"><STRONG>REPORTE RESULTADOS DE INDICADORES DE PROCESO</STRONG></td>
		<td>Usuario:</td>
		<td><?php echo $this->session->nombre;?></td>
	</tr>
	<tr>		
		<td>Fecha</td>
		<td><?php echo date("d/m/Y h:i:s a");?></td>		
	</tr>
</table>

<table style="margin:30px auto; width:900px;">
	<tr>
		<td style="width:30%;text-align:left"><strong>NOMBRE DEL INDICADOR</strong></td>
		<td style="text-align:left">Capacidad de Respuesta</td>		
	</tr>
	<tr>				
		<td style="text-align:left"><strong>DEPARTAMENTO</strong></td>
		<td style="text-align:left"><?php echo $departamento?></td>
	</tr>	
	<tr>				
		<td style="text-align:left"><strong>PERIODO CONSULTADO</strong></td>
		<td style="text-align:left"><?php echo date("d/m/Y", strtotime($desde)).' a '.date("d/m/Y", strtotime($hasta));?></td>
	</tr>	
</table>
<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td colspan="6"><strong>RESULTADO DEL PERIODO</strong></td>		
	</tr>
	<tr>
		<td value="<?php echo $sol_totales; ?>"><strong>SOLICITUDES</strong></td>
		<td colspan="2"><?php echo $sol_totales; ?></td>
		<td><strong>PROMEDIO DÍAS</strong></td>
		<td colspan="2"><?php echo $diff->days .' días ';; ?></td>		
	</tr>
	<tr>
		<td><strong>DECLINADAS</strong></td>
		<td colspan="2"><?php echo $sol_declinadas; ?></td>
		<td><strong>SIN RESPUESTA</strong></td>
		<td colspan="2"><?php echo $sol_en_proceso; ?></td>		
	</tr>
	<tr>
		<td><strong>COTIZADOS</strong></td>
		<td colspan="2"><?php echo $sol_cotizadas; ?></td>
		<td><strong>NO COTIZADOS</strong></td>
		<td colspan="2"><?php echo $sol_no_respuesta;?></td>			
	</tr>
	<tr>
		<td><strong>RESP. <= A 2 DÍAS</strong></td>
		<td colspan="2"><?php echo $resp_rapida; ?></td>
		<td><strong>RESP. > A 2 DÍAS</strong></td>
		<td colspan="2"><?php echo $resp_lenta;?></td>			
	</tr>	
	<tr>
		<td colspan="6"></td>		
	</tr>
	<tr>
		<td><strong>TOTAL RESPUESTAS</strong></td>
		<td><?php echo $sol_respondidas;?></td>
		<td><strong>RESULTADO</strong></td>
		<td ><?php echo number_format($promedio_respondidas,2,',','.');?>%</td>
		<td><strong>META</strong></td>
		<td><?php echo "62%" ?></td>		
	</tr>
	
</table>
    
<input type="hidden" id="sol_totales" value="<?php echo $sol_totales; ?>">
<input type="hidden" id="sol_cotizadas" value="<?php echo $sol_cotizadas; ?>">
<input type="hidden" id="sol_declinadas" value="<?php echo $sol_declinadas; ?>">
<input type="hidden" id="sol_no_respuesta" value="<?php echo $sol_no_respuesta; ?>">
<input type="hidden" id="prom_respondidas" value="<?php echo $promedio_respondidas; ?>">
<input type="hidden" id="prom_minimo" value="62">

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>SOLICITUDES</strong></td>		
	</tr>
	<tr>
		<td>
			<canvas id="graf_solicitudes" width="400" height="200"></canvas>
		</td>		
	</tr>
</table>

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>RENDIMIENTO (%)</strong></td>		
	</tr>
	<tr>
		<td>
			<canvas id="graf_rendimiento" width="400" height="200"></canvas>
		</td>		
	</tr>
</table>
    
<center>
    <button id="imprimir" class="btn btn-success">Imprimir Reporte</button>
</center>

<script>
var ctx = $("#graf_solicitudes");
var sol_totales = $("#sol_totales").val();
var sol_cotizadas = $("#sol_cotizadas").val();
var sol_declinadas = $("#sol_declinadas").val();
var sol_no_respuesta = $("#sol_no_respuesta").val();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Totales", "Cotizadas","Declinadas", "Sin respuesta",],
        datasets: [{
            data: [sol_totales, sol_cotizadas, sol_declinadas, sol_no_respuesta],
            backgroundColor: [
                'rgba(11, 224, 27, 0.2)',         
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(11, 224, 27, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255,99,132,1)',
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
    
var ctx = $("#graf_rendimiento");
var prom_respondidas = $("#prom_respondidas").val();
var prom_minimo = $("#prom_minimo").val();
var verde = 'rgba(11, 224, 27  , 0.2)';
var rojo ='rgba(255, 99, 132, 0.2)';
var bverde = 'rgba(11, 224, 27, 1)';
var brojo = 'rgba(255,99,132,1)';
if (prom_minimo > prom_respondidas){
    var color1 = rojo;
    var bcolor1 = brojo;
}
else {
    var color1 = verde;
    var bcolor1 = bverde;
}

    
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Resultado", "Meta"],
            datasets: [{
                labels: [],
                data: [prom_respondidas, prom_minimo],
                backgroundColor: [
                    color1,
                    'rgba(54, 162, 235, 0.2)',

                ],
                borderColor: [
                    bcolor1,
                    'rgba(54, 162, 235, 1)',

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



$( document ).ready(function() {
    $("#imprimir").click(function(){
    window.print();
                     });
});
    
</script>
    
</body>
</html>


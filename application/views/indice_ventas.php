<?php
    $ci = &get_instance();
    $ci->load->model("registro");
    $orden = $this->_ci_cached_vars;

    $datos_dep = $ci->registro->departamentos_ver('WHERE nombre_departamento = "'.$departamento.'"');
    
    $ord_nuevas = $ci->registro->orden_ver_periodo($desde, $hasta, 'estado="SCR" AND');
    $ord_proceso = $ci->registro->orden_ver_periodo($desde, $hasta, 'estado="SEP" AND');
    $ord_facturadas = $ci->registro->orden_ver_periodo($desde, $hasta, 'estado="FAC" AND');
    $ord_no_facturadas = $ci->registro->orden_ver_periodo($desde, $hasta, '(estado="SCR" OR estado="SEP") AND');
    $ord_declinadas = $ci->registro->orden_ver_periodo($desde, $hasta, 'estado="SDE" AND');
    $ord_totales = $ci->registro->orden_ver_periodo($desde, $hasta, '');
    $ordenes = $ci->registro->ordenes_ver_listado($departamento);

    $promedio_respondidas = ($ord_facturadas*100)/$ord_totales;


    /*$cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$ordicitud[0]['cliente'].'"');
    //$departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'."$ordicitud[0]['departamento']".'"');
    $gerente = $ci->registro->usuarios_ver('WHERE departamento = "'.$ordicitud[0]['departamento'].'" AND nivel = "1" ');
    $factura = $ci->registro->factura_ver($orden[0]['id_orden']);*/

    $date1 = new DateTime("2015-02-14");
    $date2 = new DateTime("2015-02-16");
    $diff = $date1->diff($date2);

    date_default_timezone_set('America/Caracas');

    $resp_rapida = $resp_lenta = 0;
    foreach($ordenes as $ord){
        $factura = $ci->registro->factura_ver($ord['id_ordicitud']);
        if($factura){
            $fecha1 = new DateTime($ord['forden']);
            $fecha2 = new DateTime($factura[0]['ffactura']);
            $interval = $fecha1->diff($fecha2);
            if($interval->format('%d') < 2) $resp_rapida++;
            else $resp_lenta++;
        }
        elseif ($ord['estado'] == 'SDE')
            $resp_rapida++;
}

    
            
    
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Indice de Ventas</title>
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
		<td rowspan="2"><STRONG>REPORTE RESULTADOS DE INDICE DE VENTAS</STRONG></td>
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
		<td style="text-align:left">Indice de Ventas</td>		
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
		<td value="<?php echo $ord_totales; ?>"><strong>ORDENES</strong></td>
		<td colspan="2"><?php echo $ord_totales; ?></td>
		<td><strong>PROMEDIO DÍAS</strong></td>
		<td colspan="2"><?php echo $diff->days .' días ';; ?></td>		
	</tr>
	<tr>
		<td><strong>DECLINADAS</strong></td>
		<td colspan="2"><?php echo $ord_declinadas; ?></td>
		<td><strong>SIN RESPUESTA</strong></td>
		<td colspan="2"><?php echo $ord_no_facturadas; ?></td>		
	</tr>
	<tr>
		<td><strong>FATURADAS</strong></td>
		<td colspan="2"><?php echo $ord_facturadas; ?></td>
		<td><strong>NO FACTURADAS</strong></td>
		<td colspan="2"><?php echo $ord_no_facturadas;?></td>			
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
		<td><?php echo $ord_facturadas;?></td>
		<td><strong>RESULTADO</strong></td>
		<td ><?php echo number_format($promedio_respondidas,2,',','.');?>%</td>
		<td><strong>META</strong></td>
		<td><?php echo "50%" ?></td>		
	</tr>
	
</table>
    
<input type="hidden" id="ord_totales" value="<?php echo $ord_totales; ?>">
<input type="hidden" id="ord_facturadas" value="<?php echo $ord_facturadas; ?>">
<input type="hidden" id="ord_declinadas" value="<?php echo $ord_declinadas; ?>">
<input type="hidden" id="ord_no_facturadas" value="<?php echo $ord_no_facturadas; ?>">
<input type="hidden" id="prom_respondidas" value="<?php echo $promedio_respondidas; ?>">
<input type="hidden" id="prom_minimo" value="50">

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>ORDENES</strong></td>		
	</tr>
	<tr>
		<td>
			<canvas id="graf_ordicitudes" width="400" height="200"></canvas>
		</td>		
	</tr>
</table>

<table style="margin:10px auto; width:900px;" class="iguales2">
	<tr style="font-weight:bold; background: #ccc;">
		<td><strong>CAPACIDAD DE PAGO (%)</strong></td>		
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
var ctx = $("#graf_ordicitudes");
var ord_totales = $("#ord_totales").val();
var ord_cotizadas = $("#ord_facturadas").val();
var ord_declinadas = $("#ord_declinadas").val();
var ord_no_respuesta = $("#ord_no_facturadas").val();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Totales", "Facturadas","Declinadas", "Sin facturar",],
        datasets: [{
            data: [ord_totales, ord_cotizadas, ord_declinadas, ord_no_respuesta],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',         
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)',
                'rgba(255, 206, 86, 1)'
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
var verde = 'rgba(75, 192, 192, 0.2)';
var rojo ='rgba(255, 99, 132, 0.2)';
var bverde = 'rgba(75, 192, 192, 1)';
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


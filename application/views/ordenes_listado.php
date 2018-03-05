<?php
    $ci = &get_instance();
    $ci->load->model("registro");
?>


<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Listado de Ordenes</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
             
          <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#ORD</th>
                            <th>#SOL</th>
                            <th>Cliente</th>
                            <th>Clave</th>
                            <th>Cotización</th>
                            <th>I.R.</th>
                            <th>I.A.</th>
                            <th>PO</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            
                            if($this->session->departamento != '99') {
                                $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$this->session->departamento.'"');
                            
                                if($departamento[0]['tipo'] != '3' && $departamento[0]['tipo'] != '4' && $departamento[0]['tipo'] != '5')
                                    $ordenes = $ci->registro->ordenes_ver_listado($this->session->departamento);
                                else
                                    $ordenes = $ci->registro->ordenes_ver_listado_completo();
                            }
                            else 
                                $ordenes = $ci->registro->ordenes_ver_listado_completo();
                            
                            if(!$ordenes) echo '<tr> <th colspan="10"> Sin ordenes registradas </th></tr>';
                            else{
                                
                                foreach($ordenes as $o){
                                    
                                    $orden = $ci->registro->orden_ver_detalle($o['id_solicitud']);
                                    
                                    $cotizacion = $ci->registro->cotizacion_ver($o['id_solicitud']);
                                    
                                    $cliente = $ci->registro->clientes_ver('WHERE id_cliente ="'.$o['cliente'].'"');
                                    
                                    
                                    if($orden[0]['estado'] == 'SCR')
                                       $estado = "Nueva";
                                    elseif($orden[0]['estado'] == 'SEP')
                                       $estado = "En Proceso";
                                    elseif($orden[0]['estado'] == 'FAC')
                                       $estado = "Facturada";
                                    elseif($orden[0]['estado'] == 'SDE')
                                       $estado = "Declinada";
                                
                                   echo '<tr> <td>'.$orden[0]['id_orden'].'</td>';
                                   echo '<td>'.$orden[0]['solicitud'].'</td>';
                                   echo '<td>'.$cliente[0]['nombre'].'</td>';
                                   echo '<td>'.$o['pclave'].'</td>';
                                   echo '<td>' ?> 
                            
                                    <a href="javascript:abrir_archivo('<?php echo $cotizacion[0]['archivo']; ?>')"> cotizacion<?php echo $cotizacion[0]['id_cotizacion'] ?></a></td>
                                   <?php
                                       
                                       
                                   echo '<td>'.$o['isolicitados'].'</td>';
                                   echo '<td>'.$orden[0]['item_aprob'].'</td>';
                                   echo '<td>'; ?>
                                   <a href="javascript:abrir_archivo2('<?php echo $orden[0]['po']; ?>')"> PO<?php echo $orden[0]['id_orden'] ?></a></td>        
                                   <?php
                                   echo '<td>'.$estado.'</td>';
                                   echo '<td>
                                   
                                            <form id="orden_ver" action="'.site_url().'Welcome/orden_ver_detalle" method="post">
                                            
                                            <button name="orden_detalle" value ="'.$o['id_solicitud'].'" style="border:0; background: none"><i style="color:blue; font-size:20px" class="fa fa-search"></i></button>
                                            
                                            <a href="#ventana'. $o['id_solicitud'] .'" id="declinar" data="'.$o['id_solicitud'].'" data-toggle="modal"><i style="color:red; font-size:20px" class="fa fa-times-circle"></i></a>
                                            
                                            </form>
                                            
                                            
                                            
                                            </td></tr>';
                                        
                                            echo
                                            '<div class="modal fade" id="ventana'.$o['id_solicitud'].'">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar orden de compra de la solicitud #'. $o['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Esta seguro que desea declinar la orden de compra?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:orden_cambiar_estado(<?php echo $o['id_solicitud'] ?>,'SDE')" class="btn btn-success">Aceptar</a> 
                                                    <?php
                                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                                
                                
                                
                                
                                
                                
                                }
                                
                                
                            } ?>
                          
                            
                            
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             
<script>
             
$("#orden_detalle").click(function(){
        $("#orden_ver").submit();                             
    });
    
function abrir_archivo(documento){
        cadena = '<?php echo base_url(); ?>archivos/cotizaciones/' + documento;
        window.open(cadena);
    }
    
function abrir_archivo2(documento){
        cadena = '<?php echo base_url(); ?>archivos/ordenes/' + documento;
        window.open(cadena);
    }

function orden_cambiar_estado(id,estado){
        //alert(estado);
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>" + "Welcome/orden_cambiar_estado/",
            data: {'id_solicitud': id, 'estado': estado},
            success:function(data){
                alert("Estado de la Orden de Compra de la solicitud #" + id + " cambiado exitosamente");
                $("#cerrar_modal").click();
                location.reload(true);
            },
        });
        
    }
    
</script>
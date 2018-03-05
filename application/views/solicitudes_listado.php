<?php
    $ci = &get_instance();
    $ci->load->model("registro");
?>

<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Listado de Solicitudes</h2>
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
                            <th>#SOL</th>
                            <th>Cliente</th>
                            <th>Clave</th>
                            <th>Encargado</th>
                            <th>Fecha Solicitud</th>
                            <th>Contratación</th>
                            <th>I.R.</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            
                            if($this->session->departamento != '99') {
                                $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$this->session->departamento.'"');
                            
                                if($departamento[0]['tipo'] != '3' && $this->session->nivel != '5')
                                    $solicitudes = $ci->registro->solicitudes_ver_listado($this->session->departamento, $this->session->nivel);
                                else
                                    $solicitudes = $ci->registro->solicitudes_ver_listado_completo();
                            }
                             else
                                    $solicitudes = $ci->registro->solicitudes_ver_listado_completo();
                            
                            if(!$solicitudes) echo '<tr> <th colspan="10"> Sin solicitudes asignadas </th></tr>';
                                
                                else{
                                    
                                    foreach ($solicitudes as $row){
                                        
                                            if ($row['analista1'] == '-1')
                                                $analista = "Por asignar";
                                            else 
                                                $analista = $this->session->nombre;
                                        
                                            if($row['tcontratacion'] == 1)
                                                $contratacion = "Tradicional";
                                            else
                                                $contratacion = "Pública";
                                        
                                            if($row['estado'] == 'SCR')
                                                $estado = "Nueva";
                                            if($row['estado'] == 'SAA')
                                                $estado = "Asignada";
                                            if($row['estado'] == 'SEP')
                                                $estado = "En Proceso";
                                            if($row['estado'] == 'COC')
                                                $estado = "Cotización Cargada";
                                            if($row['estado'] == 'COA')
                                                $estado = "Cotización Aprobada";
                                            if($row['estado'] == 'COE')
                                                $estado = "Cotización Enviada";
                                            if($row['estado'] == 'SDE')
                                                $estado = "Declinada";
                                        
                                            $cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$row['cliente'].'"');
                                        
                                            echo '<tr> <td>'.$row['id_solicitud'].'</td>';
                                            echo '<td>'.$cliente[0]['nombre'].'</td>';
                                            echo '<td>'.$row['pclave'].'</td>';
                                            echo '<td>'.$analista.'</td>';
                                            echo '<td>'.$row['fsolicitud'].'</td>';
                                            echo '<td>'.$contratacion.'</td>';
                                            echo '<td>'.$row['isolicitados'].'</td>';
                                            echo '<td>'.$estado.'</td>';
                                            echo '<td>
                                            
                                            <form id="solicitud_ver" action="'.site_url().'Welcome/solicitud_ver" method="post">
                                            
                                            <button name="solicitud_detalle" value ="'.$row['id_solicitud'].'" style="border:0; background: none"><i style="color:blue; font-size:20px" class="fa fa-search"></i></button>
                                            
                                            <a href="#ventana'. $row['id_solicitud'] .'" id="declinar" data="'.$row['id_solicitud'].'" data-toggle="modal"><i style="color:red; font-size:20px" class="fa fa-times-circle"></i></a>
                                            
                                            </form>
                                            
                                            
                                            
                                            </td></tr>';
                                        
                                            echo
                                            '<div class="modal fade" id="ventana'.$row['id_solicitud'].'">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar solicitud #'. $row['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Esta seguro que desea declinar la solicitud?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:solicitud_cambiar_estado(<?php echo $row['id_solicitud'] ?>,'SDE')" class="btn btn-success">Aceptar</a>        
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                    <?php
                                            
                                        }
                    
                                }
                            
                        ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </section>
             
<script>
    
     $("#solicitud_detalle").click(function(){
        $("#solicitud_ver").submit();                             
    });
    
    function solicitud_cambiar_estado(id,estado){
        //alert(estado);
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>" + "Welcome/solicitud_cambiar_estado/",
            data: {'id_solicitud': id, 'estado': estado},
            success:function(data){
                alert("Estado de solicitud #" + id + " cambiado exitosamente");
                $("#cerrar_modal").click();
                location.reload(true);
            },
        });
        
    }
    
        
</script>
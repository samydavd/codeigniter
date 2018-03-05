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
                            <th>#SOL</th>
                            <th>Cliente</th>
                            <th>Clave</th>
                            <th>Departamento</th>
                            <th>F. Solicitud</th>
                            <th>RFQ</th>
                            <th>I.R.</th>
                            <th>Cotización</th>
                            <th>Contratación</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            
                            
                            $solicitudes = $ci->registro->ordenes_nuevas_listado();
                            
                            if(!$solicitudes) echo '<tr> <th colspan="10"> Sin solicitudes asignadas </th></tr>';
                                
                                else{
                                    
                                    foreach ($solicitudes as $row){
                                        
                                            if($row['tcontratacion'] == 1)
                                                $contratacion = "Tradicional";
                                            else
                                                $contratacion = "Pública";
                                        
                                            $cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$row['cliente'].'"');
                                            
                                            $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$row['departamento'].'"');
                                        
                                            $cotizacion = $ci->registro->cotizacion_ver($row['id_solicitud']);
                                        
                                            echo '<tr> <td>'.$row['id_solicitud'].'</td>';
                                            echo '<td>'.$cliente[0]['nombre'].'</td>';
                                            echo '<td>'.$row['pclave'].'</td>';
                                            echo '<td>'.$departamento[0]['nombre_departamento'].'</td>';
                                            echo '<td>'.$row['fsolicitud'].'</td>';
                                            echo '<td>'.$row['rfq'].'</td>';
                                            echo '<td>'.$row['isolicitados'].'</td>';
                                            echo '<td>'; ?> <a href="javascript:abrir_archivo('<?php echo $cotizacion[0]['archivo']; ?>');"> cotizacion<?php echo $cotizacion[0]['id_cotizacion']; ?> </a> <?php echo '</td>';
                                            
                                            echo '<td>'.$contratacion.'</td>';
                                            echo '<td>
                                            
                                            <form id="orden_ver" action="'.site_url().'Welcome/orden_ver" method="post">
                                            
                                            <button name="orden_detalle" value ="'.$row['id_solicitud'].'" style="border:0; background: none"><i style="color:green; font-size:20px" class="fa fa-check-circle"></i></button>
                                            
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
                                                        ¿Esta seguro que desea eliminar esta orden?    
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
    
     $("#orden_detalle").click(function(){
        $("#orden_ver").submit();                             
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
    
    function abrir_archivo(documento){
        cadena = '<?php echo base_url(); ?>archivos/adjuntos/' + documento;
        window.open(cadena);
    }
    
        
</script>
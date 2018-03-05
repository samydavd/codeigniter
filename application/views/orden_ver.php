<?php
    $ci = &get_instance();
    $ci->load->model("registro");
    $orden = $this->_ci_cached_vars;
    $solicitud = $ci->registro->solicitud_ver_detalle($orden[0]['solicitud']);
    $cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$solicitud[0]['cliente'].'"');
    $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$solicitud[0]['departamento'].'"');
    $dep_usuario = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$this->session->departamento.'"');
    $gerente = $ci->registro->usuarios_ver('WHERE departamento = "'.$solicitud[0]['departamento'].'" AND nivel = "1" ');
    $factura = $ci->registro->factura_ver($orden[0]['id_orden']);
    
    if($solicitud[0]['dias'] == 0)
        $dias = 'Hoy';
    elseif($solicitud[0]['dias'] == 1)
        $dias = 'Ayer';
    else
        $dias = 'Hace '.$solicitud[0]['dias'].' días';
?>


          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Orden de Compra</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Detalles OC</li>
            </ul>
          </div>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Horizontal Form-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <h3 style="text-align:center">Detalle de la Orden de Compra #<?php echo $orden[0]['id_orden']; ?></h3>
                        <hr>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Cliente</label>
                            
                                <?php echo $cliente[0]['nombre']; ?></p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Departamento</label>
                            
                                <?php echo $departamento[0]['nombre_departamento']; 
                                
                               if($gerente) ?> &nbsp;&nbsp; > &nbsp;&nbsp; <?php echo $gerente[0]['nombre'];
                                
                                ?></p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Asunto</label>
                            
                                <?php echo $solicitud[0]['asunto']; ?></p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Palabras Clave</label>
                            
                                <?php echo $solicitud[0]['pclave']; ?></p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Detalle</label>
                            
                                <?php echo $solicitud[0]['detalle']; ?></p>
                        
                        </div>
                        
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">PO</label>
                            
                                <a href="javascript:abrir_archivo2('<?php echo $orden[0]['po']; ?>');"> <?php echo $orden[0]['po']; ?> </a> &nbsp;&nbsp; > &nbsp;&nbsp; <?php echo number_format($orden[0]['monto'], 2); ?> Bolivares
                        
                            </p></div>
                        
                         <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Detalle PO</label>
                            
                                <?php echo $orden[0]['detalle_po']; ?></p>
                        
                        </div>
                        
                        <?php if($orden[0]['link_po'] != '') { ?>
    
                        <div class="form-group">
                            
                                <p><label class="form-control-label col-lg-2">Link PO</label>
                            
                                    <a target="_blank" href="<?php echo $orden[0]['link_po'] ?>"> <?php echo $orden[0]['link_po'] ?> </a>
                                </p>
                        </div>
                        
                        <?php } ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Fecha solicitud</label>
                            
                                <?php echo $solicitud[0]['fsolicitud']; ?> <strong> (<?php echo $dias; ?>)</strong></p>
                        
                        </div>
                        
                        
                        <?php if($orden[0]['archivo'] != '') { ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Adjunto</label>
                                
                                
                            
                                <a href="javascript:abrir_archivo('<?php echo $orden[0]['archivo']; ?>');"> <?php echo $orden[0]['archivo']; ?> </a></p>
                        
                        
                        </div>
                        
                        <?php } ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Monto</label>
                            
                                <?php echo $orden[0]['monto']; ?> Bolivares
                            
                            &nbsp;&nbsp; > &nbsp;&nbsp;
                            
                                <?php echo $orden[0]['item_aprob']; ?> Items Aprobados</p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Modo de Pago</label>
                            
                                <?php echo $orden[0]['t_pago']; ?>
                        
                        </div>
                        
                        <?php 
                        
                        if($factura){ ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Factura</label>
                            
                                <a href="javascript:abrir_archivo3('<?php echo $factura[0]['archivo']; ?>');"> <?php echo $factura[0]['archivo']; ?> </a></p>
                        
                        </div>
                        
                        <?php }
                        
                        if($orden[0]['estado'] == 'SDE') { ?>
                        
                        <div style="text-align:center">
                            <p style="color:red">ORDEN DECLINADA</p>
                        </div>
                        
                        <?php }
                            
                        if ($orden[0]['estado'] == 'FAC') { ?>
                            <div style="text-align:center">
                            <p style="color:blue">ORDEN PAGADA</p>
                        </div>
                        
                        <?php } ?>
                        
                        <center>    
                            <?php
                            if($orden[0]['estado'] == 'SCR' && $this->session->nivel == '1' && $dep_usuario[0]['tipo'] != '3' && $dep_usuario[0]['tipo'] != '4') { ?>
                                <a href="#ventana" id="declinar" data-toggle="modal" class="btn btn-success">Procesar</a>
                            <?php }
                            
                            if($orden[0]['estado'] == 'SEP' && $dep_usuario[0]['tipo'] == '4') { ?>
                                <a href="#ventana2" id="declinar" data-toggle="modal" class="btn btn-warning">Facturar</a>
                            <?php }
                            
                            
                            if($orden[0]['estado'] != 'SDE' && $orden[0]['estado'] != 'FAC') { ?>
                                <a href="#ventana3" id="declinar" data-toggle="modal" class="btn btn-danger">Declinar</a>
                            <?php } ?>
                            
                        </center>
                        <?php
                        echo
                                            '<div class="modal fade" id="ventana">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Procesar la Orden de Compra #'. $orden[0]['id_orden'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Desea procesar la Orden de Compra en cuestión?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:orden_cambiar_estado(<?php echo $orden[0]['solicitud'] ?>, 'SEP')" class="btn btn-success">Aceptar</a>
                                                    <?php
                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                       echo
                                            '<div class="modal fade" id="ventana2">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Cargar factura de la Orden de Compra #'. $orden[0]['id_orden'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                  
                                                        <form id="factura_cargar" action="'.site_url().'Welcome/factura_cargar" class="form-horizontal" method="post" enctype="multipart/form-data">
                                                        
                                                         <input type="text" id="satisfacion" name="satisfacion" placeholder="Ingrese el grado de satisfracion del cliente (%)" class="form-control form-control-success " required/> 
                                                        
                                                        <input type="file" id="archivo" name="archivo" size="30" class="form-control form-control-success " value=-1 required/>  
                                                        
                                                        <input type="hidden" id="id_orden" name="id_orden" value="'. $orden[0]['id_orden'].'" />
                                                        
                                                        <input type="hidden" id="id_solicitud" name="id_solicitud" value="'. $orden[0]['solicitud'].'" />
                                                        
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>
                                                    <input type=submit value="Cargar Factura" class="btn btn-success"/>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>';
                                                       
                         echo
                                            '<div class="modal fade" id="ventana3">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar orden de compra de la solicitud #'. $orden[0]['solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Esta seguro que desea declinar la orden de compra?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:orden_cambiar_estado(<?php echo $orden[0]['id_orden'] ?>,'SDE')" class="btn btn-success">Aceptar</a> 
                                                    <?php
                                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                        ?>
                        
                    </div>
                  </div>
                </div>
                  
                
              </div>
            </div>
          </section>
             
<script type="text/javascript">
    
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
    
    function abrir_archivo(documento){
        cadena = '<?php echo base_url(); ?>archivos/adjuntos/' + documento;
        window.open(cadena);
    }
    
    function abrir_archivo2(documento){
        cadena = '<?php echo base_url(); ?>archivos/ordenes/' + documento;
        window.open(cadena);
    }
    
    function abrir_archivo3(documento){
        cadena = '<?php echo base_url(); ?>archivos/facturas/' + documento;
        window.open(cadena);
    }
</script>

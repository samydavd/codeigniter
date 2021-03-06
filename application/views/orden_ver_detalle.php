<?php
    $ci = &get_instance();
    $ci->load->model("registro");
    $solicitud = $this->_ci_cached_vars;
    $cliente = $ci->registro->clientes_ver('WHERE id_cliente = "'.$solicitud[0]['cliente'].'"');
    $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$solicitud[0]['departamento'].'"');
    $gerente = $ci->registro->usuarios_ver('WHERE departamento = "'.$solicitud[0]['departamento'].'" AND nivel = "1" ');
    $cotizacion = $ci->registro->cotizacion_ver($solicitud[0]['id_solicitud']);
    $analistas_dep = $ci->registro->usuarios_ver('WHERE departamento = "'.$solicitud[0]['departamento'].'"');
    
    if($solicitud[0]['dias'] == 0)
        $dias = 'Hoy';
    elseif($solicitud[0]['dias'] == 1)
        $dias = 'Ayer';
    else
        $dias = 'Hace '.$solicitud[0]['dias'].' días';

    if($solicitud[0]['tcontratacion'] == 1)
        $tcontratacion = 'Contratacion Tradicional';
    else
        $tcontratacion = 'Contratacion Pública';
?>


          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Nuevo Departamento</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Nueva orden</li>
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
                      <h3 style="text-align:center">Agregar nueva Orden de Compra</h3>
                        <hr>
                        
                        <form id="solicitud_cargar" action="<?php echo site_url()."Welcome/orden_nueva_bd"; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                        
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
                        
                         <?php if($cotizacion) { ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Cotización</label>
                            
                                <a href="javascript:abrir_archivo('<?php echo $cotizacion[0]['archivo']; ?>');"> <?php echo $cotizacion[0]['archivo']; ?> </a> &nbsp;&nbsp; > &nbsp;&nbsp; <?php echo number_format($cotizacion[0]['monto'], 2); ?> Bolivares  
                        </p></div>
                        
                        <?php } ?>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Fecha solicitud</label>
                            
                                <?php echo $solicitud[0]['fsolicitud']; ?> <strong> (<?php echo $dias; ?>)</strong></p>
                        
                        </div>
                        
                        <div class="form-group">
                            <p><label class="form-control-label col-lg-2">Contratación</label>
                            
                                <?php echo $tcontratacion ?></p>
                        
                        </div>
                            
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Cargar PO</label>
                                
                                <input type="file" id="archivo_po" name="archivo_po" size="20" class="form-control form-control-success col-lg-7" value=-1 />
                        
                        
                        </div>
                            
                         <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Detalle de PO</label>
                            
                                <textarea id="detalle" name="detalle" type="text" placeholder="Indique una descripción de la orden de compra" class="form-control form-control-success col-lg-4"></textarea>
                             
                             
                        
                        
                        </div>
                            
                    
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Link PO</label>
                            
                                <input type="text" id="link" name="link" placeholder="www.ejemplo.com" class="form-control form-control-success col-lg-4" />
                        </div>
                            
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Adjuntar</label>
                                
                                <input type="file" id="archivo_adjunto" name="archivo_adjunto" size="20" class="form-control form-control-success col-lg-7" value=-1 />
                            
                        
                        </div>
                            
                        <div class="form-group form-inline">
                           
                            <label class="form-control-label col-lg-2">Tipo de pago</label>
                            
                                <Select id="tpago" name="tpago" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Credito">Crédito</option> 
                                    <option value="Contado">Contado</option> 
                                </Select>
                            
                                
                        </div>
                            
                        <div class="form-group form-inline">
                                
                            <label class="form-control-label col-lg-2">Monto</label>
                            
                                <input type="number" id="monto" name="monto" class="form-control form-control-success col-lg-4" />
                                
                            <label class="form-control-label col-lg-2">IA</label>
                            
                                <input type="number" id="ia" name="ia" class="form-control form-control-success col-lg-2" />
                        </div>
                            
                        <input type="hidden" name="id_solicitud" value="<?php echo $solicitud[0]['id_solicitud']; ?>" />
                        
                        
                        <center>
                            <input type="submit" class="btn btn-success" id="agregar_orden" value="Agregar" />    
                        </center>
                          
                        
                        </form>
                        <div class="modal fade" id="ventana1">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div style="padding: 0.2em">
                                                      <h4 class="modal-title" id="myModalLabel" style="text-align:center">Asignar solicitud #<?php echo $solicitud[0]['id_solicitud']; ?></h4>
                                                    
                                                    <hr>    
                                                  </div>
                                                
                                                    
                                                    
                                                    <div class="form-group" style="text-align:center">
                                                    <?php 
                                                    
                                                    
                                                    foreach($analistas_dep as $a) {
                                                    
	                                                   echo '<input type="radio" name="analista" id="edad1" value="'.$a['id_usuario'].'"> '.$a['nombre'].'<br>';
                                                    }

                                                    ?>
                                                        
                                                    </div>
                                                    
                                                    
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>
                                                    <a href="javascript:solicitud_asignar_analista('<?php echo $solicitud[0]['id_solicitud']; ?>')" class="btn btn-success">Asignar</a>        
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                        <?php
                        echo
                                            '<div class="modal fade" id="ventana2">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar solicitud #'. $solicitud[0]['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Esta seguro que desea declinar la solicitud?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:solicitud_cambiar_estado(<?php echo $solicitud[0]['id_solicitud'] ?>, 'SDE')" class="btn btn-success">Aceptar</a>
                                                    <?php
                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                       echo
                                            '<div class="modal fade" id="ventana3">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Cambiar estado solicitud #'. $solicitud[0]['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        ¿Desea procesar la solicitud en cuestión?    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:solicitud_cambiar_estado(<?php echo $solicitud[0]['id_solicitud'] ?>, 'SEP')" class="btn btn-success">Aceptar</a>
                                                    <?php
                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                                                       
                         echo
                                            '<div class="modal fade" id="ventana4">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Cargar cotización solicitud #'. $solicitud[0]['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                  
                                                        <form id="solicitud_cargar" action="'.site_url().'Welcome/cotizacion_cargar" class="form-horizontal" method="post" enctype="multipart/form-data">
                                                        
                                                        <input type="number" min="1" step="any" id="monto" name="monto" placeholder="Ingrese monto cotizado" class="form-control form-control-success " placeholder="Ingrese el monto cotizado en Bolivares" />
                                                        
                                                        <input type="file" id="archivo" name="archivo" size="30" class="form-control form-control-success " value=-1 />  
                                                        
                                                        <input type="hidden" id="id_solicitud" name="id_solicitud" value="'. $solicitud[0]['id_solicitud'].'" />
                                                        
                                                        
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>
                                                    <input type=submit value="Cargar Cotización" class="btn btn-success"/>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>';
                        
                        echo
                                            '<div class="modal fade" id="ventana5">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar solicitud #'. $solicitud[0]['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                        Indique que acción desea realizar respecto a la oferta presentada    
                                                 </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>';
                                                    ?>
                                                    <a href="javascript:cotizacion_cambiar_estado(<?php echo $solicitud[0]['id_solicitud'] ?>, '-1')" class="btn btn-danger">Rechazar</a>
                        
                                                    <a href="javascript:cotizacion_cambiar_estado(<?php echo $solicitud[0]['id_solicitud'] ?>, '1')" class="btn btn-success">Aceptar</a>
                                                    <?php
                            echo
                                                  '</div>
                                                </div>
                                              </div>
                                            </div>';
                                            
                            echo
                                            '<div class="modal fade" id="ventana6">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">Declinar solicitud #'. $solicitud[0]['id_solicitud'].'</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cerrar</span></button>

                                                  </div>
                                                  <div class="modal-body">
                                                  
                                                    <form id="enviar_correo" action="'.site_url().'Welcome/sendMailGmail" class="form-horizontal" method="post">
                                                        
                                                        <input type="text" id="destinatario"" name="destinatario" class="form-control form-control-success " placeholder="Ingrese el correo del cliente" required/>
                                                        
                                                        <input type="hidden" id="archivo_cotizacion" name="archivo_cotizacion" value="'. $cotizacion[0]['archivo'].'" />
                                                        
                                                        <input type="hidden" id="id_solicitud" name="id_solicitud" value="'. $solicitud[0]['id_solicitud'].'" />
                                                        
                                                        <input type="hidden" id="asunto" name="asunto" value="'. $solicitud[0]['asunto'].'" />          
                                                        
                                                 </div>
                                                  <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrar_modal">Cerrar</button>
                                                        
                                                        <input type="submit" class="btn btn-success" name="enviar" value="Enviar" />
                                                    </form>
                                                  </div>
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
	
    function solicitud_asignar_analista(id){
        var analista = $('input:radio[name=analista]:checked').val();
        if(analista != null) {
            $.ajax({
                type:"POST",
                url:"<?php echo base_url(); ?>" + "Welcome/solicitud_asignar_analista/",
                data: {'id_solicitud': id, 'analista': analista},
                success:function(data){
                    alert("Solicitud #" + id + " asignada exitosamente");
                    $("#cerrar_modal").click();
                    location.reload(true);
                },
            });
        }
        else alert("No ha seleccionado ningun analista");
        
    }
    
    
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
    
    function cotizacion_cambiar_estado(id,estado){
        $.ajax({
            type:"POST",
            url:"<?php echo base_url(); ?>" + "Welcome/cotizacion_cambiar_estado/",
            data: {'id_solicitud': id, 'estado': estado},
            success:function(data){
                if(estado == '1') alert("Cotización de la solicitud #" + id + " aprobada exitosamente");
                else alert("La cotización de la solicitud #" + id + " ha sido rechazada");
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

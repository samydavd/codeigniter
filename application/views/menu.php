<?php
    $ci = &get_instance();
    $ci->load->model("registro");

    $departamento = $ci->registro->departamentos_ver('WHERE id_departamento = "'.$this->session->departamento.'"');
    $total = $ci->registro->cantidad_notificaciones($this->session->nivel, $departamento[0]['nombre_departamento'], $this->session->departamento);

    $dep = $departamento[0]['nombre_departamento'];
    if(!$dep) $dep = "Sistema";

    if($this->session->nivel == '1')
        $nivel = "Gerente";
    elseif($this->session->nivel == '2')
        $nivel = "Coordinador";
    elseif($this->session->nivel == '3')
        $nivel = "Analista";
    elseif($this->session->nivel == '4')
        $nivel = "Administrador";
    elseif($this->session->nivel == '5')
        $nivel = "";

    if($nivel != "")
        $tipo_usuario = $nivel. ' de ' . $dep;
    else
        $tipo_usuario = "Gerente General";
?>  

<div> <!--class="page home-page"-->
      <!-- Main Navbar-->
<header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.html" class="navbar-brand">
                  <div class="brand-text brand-big"><span>SIGROF</span><strong> PLUS</strong></div>
                  <div class="brand-text brand-small"><strong>SP</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Search-->
                <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
                <!-- Notifications-->
                <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span class="badge bg-red"><?php echo $total; ?> </span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <?php 
                      
                      if ($departamento[0]['nombre_departamento'] == 'Mercadeo'){
                          
                          $sol_enviar = $ci->registro->solicitudes_notificaciones('estado = "COA"');
                          foreach($sol_enviar as $sol){ 
                        
                         $date1 = new DateTime($sol['fsolicitud']);
                         $date2 = new DateTime(date_default_timezone_get());
                         $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-book bg-green"></i>Solicitud pendiente por envio</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
                    }
                      
                      elseif ($departamento[0]['nombre_departamento'] == 'Administracion'){
    
                      $ord_facturar = $ci->registro->ordenes_notificaciones('ordenes.estado = "SEP"');
                      
                      foreach($ord_facturar as $ord){ 
                      
                        $date1 = new DateTime($ord['forden']);
                        $date2 = new DateTime(date_default_timezone_get());
                        $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $ord['solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/orden_ver" method="post"> 
                                <input type="hidden" id="orden_detalle" name="orden_detalle" value="<?php echo $ord['solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $ord['solicitud']; ?>')" class="dropdown-item">  
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-pencil bg-blue"></i>Orden de Compra para Facturar</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
                          
                      }
                      
                      
                      
                      
                      
                      elseif ($this->session->nivel == '1' || $this->session->nivel == '2') {
                      
                      $sol_nuevas = $ci->registro->solicitudes_notificaciones('estado = "SCR"');
                      foreach($sol_nuevas as $sol){ 
                        
                         $date1 = new DateTime($sol['fsolicitud']);
                         $date2 = new DateTime(date_default_timezone_get());
                         $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-book bg-green"></i>Nueva Solicitud</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
    
                      $sol_cotizada = $ci->registro->solicitudes_notificaciones('estado = "COC"');
                      
                      foreach($sol_cotizada as $sol){ 
                      
                        $cot = $ci->registro->cotizacion_ver($sol['id_solicitud']);
                        $date1 = new DateTime($cot[0]['fcotizacion']);
                        $date2 = new DateTime(date_default_timezone_get());
                        $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Solicitud Cotizada</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
                        
                      $ord_nueva = $ci->registro->ordenes_notificaciones('solicitudes.estado = "OCR" AND ordenes.estado = "SCR"');
                      
                      foreach($ord_nueva as $ord){ 
                      
                        $date1 = new DateTime($ord['forden']);
                        $date2 = new DateTime(date_default_timezone_get());
                        $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $ord['solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/orden_ver_detalle" method="post"> 
                                <input type="hidden" id="orden_detalle" name="orden_detalle" value="<?php echo $ord['solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $ord['solicitud']; ?>')" class="dropdown-item">  
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-pencil bg-blue"></i>Nueva Orden de Compra</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
                
                      }
                      
                      elseif ($this->session->nivel == '3') {
                          
                          $sol_nuevas = $ci->registro->solicitudes_notificaciones('estado = "SAA" AND analista1 = "'.$this->session->id.'"');
                          foreach($sol_nuevas as $sol){ 
                        
                         $date1 = new DateTime($sol['fsolicitud']);
                         $date2 = new DateTime(date_default_timezone_get());
                         $intervalo = date_diff($date1,$date2);
                        
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-book bg-green"></i>Nueva Solicitud</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
    
                      $sol_cotizada = $ci->registro->solicitudes_notificaciones('estado = "COA"');
                      
                      foreach($sol_cotizada as $sol){ 
                      
                        $cot = $ci->registro->cotizacion_ver($sol['id_solicitud']);
                        $date1 = new DateTime($cot[0]['fcotizacion']);
                        $date2 = new DateTime(date_default_timezone_get());
                        $intervalo = date_diff($date1,$date2);
                        ?>
                          
                        <li>
                            <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                            </form>
                            <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                            <div class="notification">
                            <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Cotización Aprobada</div>
                            <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                        </div></a></li>
                      <?php
                      }
                          
                      }
                      
                      elseif ($this->session->nivel == '5') {
                          
                      $sol_cotizada = $ci->registro->solicitudes_notificaciones('estado = "COC"');
                      
                      foreach($sol_cotizada as $sol){ 
                      
                        $cot = $ci->registro->cotizacion_ver_limite($sol['id_solicitud']);
                        if($cot){
                            $date1 = new DateTime($cot[0]['fcotizacion']);
                            $date2 = new DateTime(date_default_timezone_get());
                            $intervalo = date_diff($date1,$date2);
                            ?>

                            <li>
                                <form id="formulario<?php echo $sol['id_solicitud']; ?>" action="<?php echo site_url(); ?>Welcome/solicitud_ver" method="post"> 
                                    <input type="hidden" id="solicitud_detalle" name="solicitud_detalle" value="<?php echo $sol['id_solicitud'] ?>" />
                                </form>
                                <a href="javascript:enviar_formulario('<?php echo $sol['id_solicitud']; ?>')" class="dropdown-item"> 
                                <div class="notification">
                                <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Cotización Aprobada</div>
                                <div class="notification-time"><small> hace <?php  echo $intervalo->format('%i'); ?> minutos</small></div>
                            </div></a></li>
                      <?php
                        }
                      }
                      }
                      ?>
                  </ul>
                </li>
                <!-- Logout    -->
                <li class="nav-item"><a href="<?php echo site_url()."Welcome/destruir_sesion"; ?>" class="nav-link logout">Cerrar Sesión<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar" style="min-height: 847px;">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="http://localhost:5050/codeIgniter/avatar.png" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4"><?php echo $this->session->nombre; ?></h1>
              <p><?php echo $tipo_usuario;?></p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
          <ul class="list-unstyled">
              
            <li class="active"> <a href="index"><i class="icon-home"></i>Inicio</a></li>
              
            <li><a href="#solicitudes" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Solicitudes </a>
              <ul id="solicitudes" class="collapse list-unstyled">
                <?php if($departamento[0]['nombre_departamento'] == 'Mercadeo' || $nivel == "Administrador" || $nivel == "") { ?>
                    <li><a href= "<?php echo site_url()."Welcome/solicitud_nueva"; ?>">+ Nuevas</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url()."Welcome/solicitud_listado"; ?>">Mis Solicitudes</a></li>
              </ul>
            </li>
              
            <li><a href="#ordenes" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-pencil fa-fw"></i>Ordenes </a>
              <ul id="ordenes" class="collapse list-unstyled">
                <?php if($departamento[0]['nombre_departamento'] == 'Mercadeo' || $nivel == "Administrador" || $nivel == "") { ?>
                <li><a href= "<?php echo site_url()."Welcome/orden_nueva"; ?>">+ Nueva</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url()."Welcome/ordenes_listado"; ?>">Mis Ordenes</a></li>
              </ul>
            </li>
              
            <li><a href="#clientes" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-address-card-o"></i>Clientes </a>
              <ul id="clientes" class="collapse list-unstyled">
                <?php if($departamento[0]['nombre_departamento'] == 'Mercadeo' || $departamento[0]['nombre_departamento'] == 'Administracion' || $nivel == "Administrador" || $nivel == "") { ?>
                <li><a href= "<?php echo site_url()."Welcome/cliente_nuevo"; ?>">+ Nuevo</a></li>
                <?php } ?>
                <li><a href="<?php echo site_url()."Welcome/clientes_listado"; ?>">Administrar</a></li>
              </ul>
            </li>
              
            <li><a href="#reportes" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i>Reportes </a>
              <ul id="reportes" class="collapse list-unstyled">
                <li><a href= "<?php echo site_url()."Welcome/reportes_indicadores"; ?>">Indicadores</a></li>
              </ul>
            </li>
              
            <li><a href="#configuracion" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-wrench"></i>Configuración </a>
              <ul id="configuracion" class="collapse list-unstyled"> 
                <li><a href= "<?php echo site_url()."Welcome/usuarios_listado"; ?>">Usuarios</a></li>
                <li><a href= "<?php echo site_url()."Welcome/departamentos_listado"; ?>">Departamentos</a></li>
              </ul>
            </li>
              
          </ul>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
<script>
            
function enviar_formulario(sol){
    $("#formulario"+sol).submit();
}

</script>
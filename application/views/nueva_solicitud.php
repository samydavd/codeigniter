<?php
    $ci = &get_instance();
    $ci->load->model("registro");
?>

          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Nueva Solicitud</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Nueva Solicitud</li>
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
                      <p>Ingrese los datos a registrar</p>
                    <form id="solicitud_cargar" action="<?php echo site_url()."Welcome/solicitud_nueva_bd"; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Cliente</label>
                            
                                <Select id="cliente" name="cliente" placeholder="Seleccionar cliente" class="form-control col-lg-4" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php
                                        foreach ($this->_ci_cached_vars as $row){
                                            echo '<option value="'.$row['id_cliente'].'">'.$row['nombre'].'</option>';
                                        }
                                    ?>
                                </Select>
                            
                           <!--&nbsp; > &nbsp;
                                <Select id="scliente" name="scliente" placeholder="Seleccionar cliente" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar subcliente</option>   
                                </Select-->
                        </div>
                        
                        <div class="form-group form-inline">
                            <!--div class= "col-lg-offset-2 col-lg-10"-->
                            <label class="form-control-label col-lg-2">Contratación</label>
                            
                                <Select id="tcontratacion" name="tcontratacion" placeholder="Seleccionar cliente" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Contratación Tradicional</option> 
                                    <option value="2">Contratación Publica</option> 
                                </Select>
                            <!--/div-->
                        </div>
                        
                        <div class="form-group form-inline">
                            <!--div class= "col-lg-offset-2 col-lg-10"-->
                            <label for="departamento" class="form-control-label col-lg-2">Departamento</label>
                            
                                <Select id="departamento" name="departamento" placeholder="Seleccionar cliente" class="form-control col-lg-4">
                                    <option value="">Seleccionar</option>
                                    <?php
                                        $departamentos = $ci->registro->departamentos_ver('WHERE tipo = "1" OR tipo = "2"');
                                    
                                        foreach ($departamentos as $row){
                                            echo '<option value="'.$row['id_departamento'].'">' .$row['nombre_departamento'].'</option>';
                                        }
                                    ?>
                                </Select>
                            <!--/div-->
                        </div>
                                                                                                                        
                        <div class="form-group form-inline">
                            <label for="rfq" class="form-control-label col-lg-2">RFQ</label>
                            
                                <input id="rfq" name="rfq" type="text" placeholder="Request For Quotation" class="form-control form-control-success col-lg-4" required>
                            
                            <label class="form-control-label col-lg-2">Fecha de Solicitud</label>
                            
                                <input id="fsolicitud" name="fsolicitud" type="date" class="form-control form-control-success col-lg-3">
                        </div>  
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Asunto</label>
                            
                                <input id="asunto" name="asunto" type="text" placeholder="Ej: Equipo de Protección Personal" class="form-control form-control-success col-lg-4" required>
                            
                            <label class="form-control-label col-lg-2">Palabras Clave</label>
                            
                                <input id="pclave" name="pclave" type="text" placeholder="Ej: Equipo Protección" class="form-control form-control-success col-lg-3" maxlength="30" required>
                        </div>  
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Detalle</label>
                            
                            <textarea id="detalle" name="detalle" name="detalle" type="text" placeholder="Indique una descripción de la solicitud" class="form-control form-control-success col-lg-4"></textarea>
                        </div>  
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Archivo</label>
                            <input type="file" id="archivo" name="archivo" size="20" class="form-control form-control-success col-lg-6" value=-1 />
                            
                            <!--form action="cargar_archivo" method="post" enctype="multipart/form-data">
<input type="file" name="mi_archivo">
</form>
<input type="submit" value="Submit"-->
                        </div>  
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Items Solicitados</label>
                            
                            <input id="isolicitados" name="isolicitados" type="number" class="form-control form-control-success col-lg-1" required>
                        </div>  
                        
                          <center>
                            <input type="submit" value="Registrar"  class="btn btn-success">
                          </center>
                        
                      </form>
                    </div>
                  </div>
                </div>
                  
                
              </div>
            </div>
          </section>
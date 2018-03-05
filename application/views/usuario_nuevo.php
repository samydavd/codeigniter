
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Nuevo Usuario</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Nuevo Usuario</li>
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
                    <form id="usuario_nuevo" action="<?php echo site_url()."Welcome/insertar"; ?>" class="form-horizontal" method="post">
                        
                        <div class="form-group form-inline">
                            <label for="nombre" class="form-control-label col-lg-2">Nombre</label>
                            
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese su nombre" class="form-control form-control-success col-lg-4" required>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            <label for="correo" class="form-control-label col-lg-2">Usuario</label>
                            
                                <input id="correo" name="correo" type="text" placeholder="Ingrese nombre de usuario" class="form-control form-control-success col-lg-4" required>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            
                            <label for="clave" class="form-control-label col-lg-2">Contraseña</label>
                                
                            <input class="form-control" id="clave" name="clave" type="password" minlength=7 placeholder="*******"
                                required data-validation-required-message="Por favor ingrese una contraseña">
                                <p class="help-block text-danger"></p>
                            
                        </div>
                        
                        
                        <div class="form-group form-inline">
                            <label for="departamento" class="form-control-label col-lg-2">Departamento</label>
                            
                                <Select id="departamento" name="departamento" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                        foreach ($this->_ci_cached_vars as $row){

                                                echo '<option value="'.$row['id_departamento'].'">' .$row['nombre_departamento'].'</option>';
                                            }
                                    ?>
                                </Select>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            
                            <label for="nivel" class="form-control-label col-lg-2">Nivel</label>
                                <select class="form-control" id="nivel" name="nivel" value="Seleccionar nivel" required>
                                    <option value="" selected>Seleccionar nivel</option>
                                    <option value=1>Gerente</option>
                                    <option value=2>Coordinador</option>
                                    <option value=3>Analista</option>
                                </select>
                    
                        </div>
                        
                        
                        <center>
                            <input type="submit" value="Registrar" class="btn btn-success">
                        </center>
                        
                      </form>
                    </div>
                  </div>
                </div>
                  
                
              </div>
            </div>
          </section>

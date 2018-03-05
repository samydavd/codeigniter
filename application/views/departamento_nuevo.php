
          <!-- Page Header-->
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
              <li class="breadcrumb-item active">Nuevo Departamento</li>
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
                    <form id="departamento_nuevo" action="<?php echo site_url()."Welcome/departamento_nuevo_bd"; ?>" class="form-horizontal" method="post">
                        
                        <div class="form-group form-inline">
                            <label for="nombre" class="form-control-label col-lg-2">Nombre</label>
                            
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre departamento" class="form-control form-control-success col-lg-4" required>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            <label for="tipo" class="form-control-label col-lg-2">Tipo</label>
                            
                                <Select id="tipo" name="tipo" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Servicio</option> 
                                    <option value="2">Suministro</option>
                                    <option value="3">Mercado</option> 
                                    <option value="4">Administración</option>
                                </Select>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            <label for="limite" class="form-control-label col-lg-2">Limite Permitido</label>
                            
                                <input id="limite" name="limite" type="number" placeholder="Ingrese nombre departamento" class="form-control form-control-success col-lg-4" required>
                        
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

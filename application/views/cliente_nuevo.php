
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
              <li class="breadcrumb-item active">Nueva Cliente</li>
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
                    <form id="solicitud_cargar" action="<?php echo site_url()."Welcome/cliente_nuevo_bd"; ?>" class="form-horizontal" method="post">
                        
                        <div class="form-group form-inline">
                            <label for="nombre" class="form-control-label col-lg-2">Nombre</label>
                            
                                <input id="nombre" name="nombre" type="text" placeholder="Ingrese nombre el cliente" class="form-control form-control-success col-lg-4" required>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <label for="rif" class="form-control-label col-sm-1">RIF</label>
                                
                                <input id="rif" name="rif" type="text" placeholder="Ingrese RIF del cliente" class="form-control form-control-success col-lg-4" required>
                        </div>
                        
                        
                        <div class="form-group form-inline">
                            
                            <label for="pais" class="form-control-label col-lg-2">País</label>
                            
                            <input id="pais" name="pais" type="text" placeholder="Ingrese país de origen del cliente" class="form-control form-control-success col-lg-4" required>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <label for="contacto" class="form-control-label col-lg-1">Contacto</label>
                            
                            <input id="contacto" name="contacto" type="text" placeholder="Nombre completo" class="form-control form-control-success col-lg-4" required>
                            
                        </div>
                        
                                                                                                                        
                        <div class="form-group form-inline">
                            
                            <label for="telefono" class="form-control-label col-lg-2">Teléfono</label>
                            
                            <input id="telefono" name="telefono" type="text" placeholder="Teléfono del cliente" class="form-control form-control-success col-lg-4" required>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <label for="medio" class="form-control-label col-lg-1">Medio</label>
                            
                                <Select id="medio" name="medio" placeholder="Seleccionar cliente" class="form-control col-lg-4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Publicidad">Publicidad</option>
                                    <option value="Referencia de cliente">Referencia de cliente</option> 
                                    <option value="Pagina web">Pagina web</option> 
                                    <option value="Redes sociales">Redes sociales</option> 
                                    <option value="Personal">Personal</option> 
                                </Select>
                            
                        </div>  
                        
                        <div class="form-group form-inline">
                        
                            <label for="direccion" class="form-control-label col-lg-2">Dirección</label>
                            
                                <textarea id="direccion" name="direccion" type="text" placeholder="Ingrese dirección del cliente" class="form-control form-control-success col-lg-4" required></textarea>
                        
                        </div>
                            
                        <div class="form-group form-inline">
                            
                            <label for="observaciones" class="form-control-label col-lg-2">Observaciones</label>
                            
                            <textarea id="observaciones" name="observaciones" type="text" placeholder="Observaciones al cliente" class="form-control form-control-success col-lg-4" required></textarea>
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


<script>
    
    $( "#cliente" ).change(function() {
		alert("Holas");
        
        //ver_subclientes();
		//ver_compradores();
	  });
    
</script>
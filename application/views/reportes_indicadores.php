<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Reportes</h2>
            </div>
          </header>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Indicadores</li>
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
                      <h3 style="text-align:center">Reportes de Indicadores de la Empresa</h3>
                        <hr>
                        
                        <form id="reportes_cargar" action="<?php echo site_url()."Welcome/reporte_cargar"; ?>" class="form-horizontal" method="post">
                            
                       <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Periodo</label>
                            
                                <Select id="periodo" name="periodo" class="form-control col-lg-3">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Primer trimestre</option> 
                                    <option value="2">Segundo trimestre</option>
                                    <option value="3">Tercer trimestre</option>
                                    <option value="4">Cuarto trimestre</option>
                                </Select>
                           &nbsp;&nbsp; &nbsp;&nbsp;
                                <Select id="anio" name="anio" class="form-control col-lg-2">
                                    <option value="">Seleccionar</option>
                                    <option value="2017">2017</option> 
                                </Select>
                        </div>
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Desde</label>
                            
                                <input type="date" id="desde" name="desde" class="form-control col-lg-3" required/>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Hasta</label>
                            
                                <input type="date" id="hasta" name="hasta" size="30" class="form-control col-lg-3" required/>
                        
                        </div>
                            
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Departamento</label>
                            
                                <Select id="departamento" name="departamento" class="form-control col-lg-3" required>
                                    <option value="">Seleccionar</option>
                                    <?php foreach($departamentos as $dep) {
                                        echo '<option value="'.$dep['nombre_departamento'].'">'.$dep['nombre_departamento'].'</option> ';
                                    } ?>
                                </Select>
                        
                        </div>
                        
                        <div class="form-group form-inline">
                            <label class="form-control-label col-lg-2">Tipo</label>
                            
                                <Select id="tipo" name="tipo" class="form-control col-lg-3" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">Capacidad de Respuesta</option> 
                                    <option value="2">Indice de Ventas</option> 
                                </Select>
                        
                        </div>
                        <center>
                            <input type="submit" name="generar_reporte" value="Generar Reporte" class="btn btn-success" />
                        </center>
                        </form>
                        
                    </div>
                  </div>
                </div>
                  
                
              </div>
            </div>
          </section>
             
<script type="text/javascript">
    
    $("#periodo, #anio").change(function(){
        var periodo = $("#periodo").val();

        if(periodo == 1)
        {
            $("#desde").val($("#anio").val() + "-01-01");
            $("#hasta").val($("#anio").val() + "-03-01");            
        }        
        else if(periodo == 2)
        {
            $("#desde").val($("#anio").val() + "-04-01");
            $("#hasta").val($("#anio").val() + "-06-30");            
        }        
        else if(periodo == 3)
        {
            $("#desde").val($("#anio").val() + "-07-01");
            $("#hasta").val($("#anio").val() + "-09-30");            
        }        
        else if(periodo == 4)
        {
            $("#desde").val($("#anio").val() + "-10-01");
            $("#hasta").val($("#anio").val() + "-12-31");            
        }     
    });
</script>

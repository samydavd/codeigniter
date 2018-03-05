<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Listado de Departamentos</h2>
            </div>
          </header>

        <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Departamentos</li>
            </ul>
          </div>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
             
          <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo de Servicio</th>
                            <th>Limite de Asignación</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                             <?php
                                if(!$this->_ci_cached_vars) echo '<tr> <th colspan="4"> Sin departamentos registrados </th></tr>';
                                
                                else{
                                    
                                    foreach ($this->_ci_cached_vars as $row){
                                        
                                            if ($row['tipo'] == "1")
                                                $tipo_departamento = "Servicio";
                                            elseif ($row['tipo'] == "2")
                                                $tipo_departamento = "Suministro";
                                            elseif ($row['tipo'] == "3")
                                                $tipo_departamento = "Mercado";
                                            elseif ($row['tipo'] == "4")
                                                $tipo_departamento = "Administración";
                                            elseif ($row['tipo'] == "5")
                                                $tipo_departamento = "N/A";
                                        
                                            if ($row['limitebs'] < '900000000' && $row['limitebs'] != '0') $limite = $row['limitebs'];
                                            elseif ($row['limitebs'] < '2147483646') $limite = 'N/A';
                                            else $limite = 'Indefinido';
                                        
                                            echo '<tr> <td>'.$row['id_departamento'].'</td>';
                                            echo '<td>'.$row['nombre_departamento'].'</td>';
                                            echo '<td>'.$tipo_departamento.'</td>';
                                            echo '<td>'.$limite.'</td></tr>';
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
             
             <center>
                 <a href="<?php echo site_url()."Welcome/departamento_nuevo"; ?>" class="btn btn-success">Registrar Departamento</a>
            </center>
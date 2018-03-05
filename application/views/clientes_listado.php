<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Listado de Clientes</h2>
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
                            <th>Nombre</th>
                            <th>RIF</th>
                            <th>Pais</th>
                            <th>Contacto</th>
                            <th>Telefono</th>
                            <th>Medio</th>
                            <th>Direccion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                                if(!$this->_ci_cached_vars) echo '<tr> <th colspan="7"> Sin clientes registrados </th></tr>';
                                
                                else{
                                    
                                    foreach ($this->_ci_cached_vars as $row){
                                        
                                            echo '<tr> <td>'.$row['nombre'].'</td>';
                                            echo '<td>'.$row['rif'].'</td>';
                                            echo '<td>'.$row['pais'].'</td>';
                                            echo '<td>'.$row['contacto'].'</td>';
                                            echo '<td>'.$row['telefono'].'</td>';
                                            echo '<td>'.$row['medio'].'</td>';
                                            echo '<td>'.$row['direccion'].'</td></tr>';
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
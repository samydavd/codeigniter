<?php
    $ci = &get_instance();
    $ci->load->model("registro");
?>

<header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Listado de Usuarios</h2>
            </div>
          </header>

        <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="index">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ul>
          </div>

         <body background="http://localhost:5050/codeIgniter/imagen1.jpg">
             
          
                       <section class="tables">   
                                            <div class="container-fluid">
                                              <div class="row">
                                                <div class="col-lg-12">
                                                  <div class="card">     
                             <?php
                                if(!$this->_ci_cached_vars) echo '<tr> <th colspan="4"> Sin departamentos registrados </th></tr>';
                                
                                else{
                                    
                                    $departamentos = $ci->registro->departamentos_ver('');
                                    
                                        foreach ($departamentos as $row){
                                            echo '<center style="padding:0.5em"><caption>'.$row['nombre_departamento'].'</h3></caption></center>'; ?>
                                            
                                            
                                                      <table class="table table-hover">
                                                        <thead>
                                                          <tr>
                                                            <th>Nombre</th>
                                                            <th>Tipo</th>
                                                            <th>Cuenta</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                        
                                                        <?php
                                                        $encontrado=0;
                                                        foreach ($this->_ci_cached_vars as $row2){
                                                            
                                                        
                                        
                                                        if($row['id_departamento'] == $row2['departamento']){
                                                            
                                                            if ($row2['nivel'] == "1")
                                                                $tipo = "Gerente";
                                                            elseif ($row2['nivel'] == "3")
                                                                $tipo = "Coordinador";
                                                            elseif ($row2['nivel'] == "2")
                                                                $tipo = "Analista";

                                                            echo '<tr> <td style="width:30%">'.$row2['nombre'].'</td>';
                                                            echo '<td style="width:30%">'.$tipo.'</td>';
                                                            echo '<td style="width:30%">'.$row2['correo'].'</td>';
                                                            echo '</tr>';
                                                            $encontrado=1;
                                                        }
                                                        
                                                    }
                                                    if(!$encontrado) echo '<tr> <th style="text-align:center" colspan="4"> Sin usuarios registrados </th></tr>';
                                            ?>
                                                    </tbody>
                                                  </table>
                                                
                                    <?php
                                    }
                    
                                }
                                ?>  
                            </div>
                                              </div>
                                            </div>
                                          </div>
                                      </section>
             
             <center>
                 <a href="<?php echo site_url()."Welcome/usuario_nuevo"; ?>" class="btn btn-success">Registrar Usuario</a>
            </center>
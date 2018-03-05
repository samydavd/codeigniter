<body class="index" id="page-top">

  <!-- Formulary Section -->
  <section id="formulary">
      <div class="container">
          <h2 class="text-center">Agregar nuevo usuario</h2>
          <div class="page-header">
                      </div>
          <div class="row">
              
                  <form action="insertar" name="newUser" id="userForm" method="post">
                    
                      <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label for="Nombre">Nombre</label>
                                <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Ingrese nombre"
                                required data-validation-required-message="Por favor ingrese su correo">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>  
                      <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label for="correo">Correo Electrónico</label>
                                <input class="form-control" id="correo" name="correo" type="email" placeholder="Correo@ejemplo.com"
                                required data-validation-required-message="Por favor ingrese su correo">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label for="clave">Contraseña</label>
                                <input class="form-control" id="clave" name="clave" type="password" minlength=7 placeholder="*******"
                                required data-validation-required-message="Por favor ingrese una contraseña">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label for="departamento">Departamento</label>
                                <select class="form-control" id="departamento" name="departamento" required>
                                    <option value="" selected>Seleccionar Departamento</option>
                                    <option value=1>Comercialización</option>
                                    <option value=2>Servicios Industriales</option>
                                    <option value=3>Laboratorio</option>
                                </select>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label for="nivel">Nivel</label>
                                <select class="form-control" id="nivel" name="nivel" value="Seleccionar nivel" required>
                                    <option value="" selected>Seleccionar nivel</option>
                                    <option value=1>Gerente</option>
                                    <option value=2>Coordinador</option>
                                    <option value=3>Analista</option>
                                </select>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                      <br>
                      <div id="success"></div>
                      <center>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success btn-lg" value="Registrarse" id="btnSubmit" name="submit"/>
                        </div>
                      </center>
                  </form>
              
          </div>
      </div>
  </section>

</body>

<script type="text/javascript">
    /*$("#btnSubmit").click(function() {
        if($("#departamento").val() != 0)        
            
            if($("#nivel").val() != 0)  
                document.newUser.submit();
            else
                alert("Debe seleccionar un nivel para proceder");
        
        else 
            alert("Debe seleccionar un departamento para proceder");
    });*/
    
</script>

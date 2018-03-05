<body background="original.jpg">
    
<div class="container" style=" padding-top: 100px">
    
        <div class="card card-container">
            
            <img id="profile-img" style="padding-left:18%; width:300px" src="avatar.png" />
            
            <p id="profile-name" class="profile-name-card"></p>
            <form action="<?php echo site_url()."/Welcome/nueva_sesion"; ?>" name="newUser" id="userForm" method="get">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="correo" name="correo" class="form-control" style="width: 100%" placeholder="Correo Electrónico" required autofocus>
                <input type="password" id="clave" name="clave" class="form-control" placeholder="Contraseña" required>
                <div class="form-group" style="padding-top:20px">
                            <input type="submit" class="btn btn-lg btn-primary btn-block btn-signin" value="Iniciar sesión" id="btnSubmit" name="submit"/>
                </div>
            </form><!-- /form finalizado -->
        </div><!-- /card-container -->
    </div>
</body>
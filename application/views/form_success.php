<!DOCTYPE html>
<html lang="es">
 <head>
  <meta charset="utf-8">
  <title>Upload éxitoso</title> 
 </head>
<body>

 <h3> Tu archivo fue subido correctamente </h3>

 <ul>

  <!-- Recorremos la variable $upload que es un array que contiene 
  los valores relacionados al upload del archivo -->
  <?php foreach ($upload_data as $item => $value):?>
   <li><?php echo $item;?>: <?php echo $value;?></li>
  <?php endforeach; ?>
 
 </ul>

 <p>
  <!-- Esto es un helper , equivale a una etiqueta <a href></a>
   Te redirecciona a que vuelas a subir otro archivo.
   -->
  <?php echo anchor('upload', 'Upload de otro archivo'); ?>
 </p>

</body>
</html>
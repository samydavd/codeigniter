<?php 

function ea($url) {
$url = strtolower($url);
$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
$repl = array('a', 'e', 'i', 'o', 'u', 'n');
$url = str_replace ($find, $repl, $url);
$find = array(' ', '&', '\r\n', '\n', '+'); 
$url = str_replace ($find, '-', $url);
$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
$repl = array('', '-', '');
$url = preg_replace ($find, $repl, $url);
return $url;
}

 
 $extension = explode(".",$_FILES['larequisicion']['name']);
 $final = count($extension)-1;
 	
$nombre = ea($_FILES['larequisicion']['name']);
$nombre_archivo = $nombre.".".$extension[$final];	 

//$nombre_archivo = ea($_FILES['larequisicion']['name']).".".$extension[$final]; 

if(file_exists("archivos/solicitudes/".$nombre_archivo))
{
	$sig = 1;
	$nombrenuevo = $nombre."-".$sig.".".$extension[$final];	
	while(file_exists("archivos/solicitudes/".$nombrenuevo))
	{
		$nombrenuevo = $nombre."-".$sig.".".$extension[$final];
		$sig++;
	}
	$nombre_archivo = $nombrenuevo;
}

if (move_uploaded_file($_FILES['larequisicion']['tmp_name'],"archivos/solicitudes/".$nombre_archivo))
{
	
?>
<script language="javascript">
	window.opener.archivo_guardado('<?php echo $nombre_archivo;?>');		
	window.close();
</script>
<?php
}
else
{
?>
<script language="javascript">
	alert("Ocurrio un error al guardar el archivo, vuelva a intentarlo");
	window.close();
</script>
<?php	
}
?>
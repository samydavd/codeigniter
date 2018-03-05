<?php
$directorio_escaneado = scandir('http://localhost:5050/codeIgniter/archivos/adjuntos_solicitudes_nuevas');
$archivos = array();
foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        $archivos[] = $item;
    }
}
echo json_encode($archivos);
?>

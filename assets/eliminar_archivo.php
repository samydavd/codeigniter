<?php
if (isset($_POST['archivo'])) {
    $archivo = $_POST['archivo'];
    if (file_exists("http://localhost:5050/codeIgniter/archivos/adjuntos_solicitudes_nuevas/$archivo")) {
        unlink("http://localhost:5050/codeIgniter/archivos/adjuntos_solicitudes_nuevas/$archivo");
        echo 1;
    } else {
        echo 0;
    }
}
?>

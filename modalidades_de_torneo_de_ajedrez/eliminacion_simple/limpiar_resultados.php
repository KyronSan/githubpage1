<?php
session_start();

// Define las rutas a los archivos JSON
$resultados_ronda_1 = 'resultados_ronda_1.json';
$resultados_ronda_2 = 'resultados_ronda_2.json';

// Borra los archivos si existen
if (file_exists($resultados_ronda_1)) {
    unlink($resultados_ronda_1);
}

if (file_exists($resultados_ronda_2)) {
    unlink($resultados_ronda_2);
}

// Definir mensaje de éxito
$mensaje = "Resultados anteriores borrados con éxito";

// Redirige de vuelta a inicio_eliminacion_simple.php con un mensaje de éxito
header('Location: inicio_eliminacion_simple.php?mensaje=' . urlencode($mensaje));
exit();
?>

<?php
$file = 'alumnos.json';
$json_data = file_get_contents($file);
$alumnos = json_decode($json_data, true);

$id = $_GET['id'];

unset($alumnos[$id]);
file_put_contents($file, json_encode(array_values($alumnos))); // Reindexar el array después de eliminar

header("Location: leer_alumnos.php");
exit();
?>

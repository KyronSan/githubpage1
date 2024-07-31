<?php
// Definir la ruta del archivo JSON específica para cada modalidad
$path_parts = pathinfo(__FILE__);
$directory = $path_parts['dirname'];
$json_file = $directory . '/alumnos.json';

// Leer los datos desde el archivo JSON
if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $alumnos = json_decode($json_data, true);
} else {
    $alumnos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alumnos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Lista de Alumnos - <?php echo basename($directory); ?></h1>
    <?php if (count($alumnos) > 0): ?>
        <ul>
            <?php foreach ($alumnos as $alumno): ?>
                <li><?php echo htmlspecialchars($alumno, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay alumnos registrados.</p>
    <?php endif; ?>
</body>
</html>

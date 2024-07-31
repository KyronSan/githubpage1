<?php
// Definir la ruta del archivo JSON específica para cada modalidad
$path_parts = pathinfo(__FILE__);
$directory = $path_parts['dirname'];
$json_file = $directory . '/alumnos.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    
    // Leer los datos existentes
    if (file_exists($json_file)) {
        $json_data = file_get_contents($json_file);
        $alumnos = json_decode($json_data, true);
    } else {
        $alumnos = [];
    }
    
    // Añadir el nuevo nombre
    $alumnos[] = $nombre;
    
    // Guardar de nuevo en el archivo JSON
    file_put_contents($json_file, json_encode($alumnos, JSON_PRETTY_PRINT));
    
    echo "Alumno guardado con éxito!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar Alumnos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Guardar Alumnos - <?php echo basename($directory); ?></h1>
    <form method="post">
        <label for="nombre">Nombre del Alumno:</label>
        <input type="text" name="nombre" id="nombre" required>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>

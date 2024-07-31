<?php
$file = 'alumnos.json';
$json_data = file_get_contents($file);
$alumnos = json_decode($json_data, true);

$id = $_GET['id'];

if (isset($_POST['nuevo_nombre'])) {
    $nuevo_nombre = htmlspecialchars($_POST['nuevo_nombre']);

    if (!empty($nuevo_nombre)) {
        $alumnos[$id]['nombre'] = $nuevo_nombre;
        file_put_contents($file, json_encode($alumnos));
        header("Location: leer_alumnos.php");
        exit();
    } else {
        echo "Por favor ingresa un nombre válido.";
    }
}

$alumno = $alumnos[$id]['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Alumno - Eliminación Simple</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Editar Alumno - Eliminación Simple</h1>
    <form method="post">
        <label for="nuevo_nombre">Nuevo Nombre del Alumno:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" value="<?php echo htmlspecialchars($alumno); ?>" required>
        <input type="submit" value="Guardar Cambios">
    </form>
    <a href="leer_alumnos.php" class="button">Cancelar</a>
</body>
</html>

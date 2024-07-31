<?php
// Leer resultados de la primera ronda desde el archivo JSON
$resultados_ronda_1 = [];
if (file_exists('resultados_ronda_1.json')) {
    $resultados_ronda_1 = json_decode(file_get_contents('resultados_ronda_1.json'), true);
}

// Leer resultados de la segunda ronda desde el archivo JSON
$resultados_ronda_2 = [];
if (file_exists('resultados_ronda_2.json')) {
    $resultados_ronda_2 = json_decode(file_get_contents('resultados_ronda_2.json'), true);
}

// Función para obtener los enfrentamientos de una ronda específica
function obtenerEnfrentamientos($resultados) {
    $enfrentamientos = [];
    foreach ($resultados as $indice => $emparejamiento) {
        $jugadorBlanco = $emparejamiento[0];
        $jugadorNegro = $emparejamiento[1];
        $resultado = isset($emparejamiento['resultado']) ? $emparejamiento['resultado'] : 'Pendiente';
        $enfrentamientos[] = [
            'jugadorBlanco' => $jugadorBlanco,
            'jugadorNegro' => $jugadorNegro,
            'resultado' => $resultado
        ];
    }
    return $enfrentamientos;
}

// Obtener los enfrentamientos de cada ronda
$enfrentamientos_ronda_1 = obtenerEnfrentamientos($resultados_ronda_1);
$enfrentamientos_ronda_2 = obtenerEnfrentamientos($resultados_ronda_2);

// Función para descargar los resultados como un archivo de texto
function descargarDiagramaComoTexto($enfrentamientos1, $enfrentamientos2) {
    $contenido = "Diagrama del Torneo\n\n";
    
    if (!empty($enfrentamientos1)) {
        $contenido .= "Primera Ronda\n";
        $contenido .= "Blancas\tNegras\tResultado\n";
        foreach ($enfrentamientos1 as $enfrentamiento) {
            $contenido .= "{$enfrentamiento['jugadorBlanco']}\t{$enfrentamiento['jugadorNegro']}\t{$enfrentamiento['resultado']}\n";
        }
        $contenido .= "\n";
    }
    
    if (!empty($enfrentamientos2)) {
        $contenido .= "Segunda Ronda\n";
        $contenido .= "Blancas\tNegras\tResultado\n";
        foreach ($enfrentamientos2 as $enfrentamiento) {
            $contenido .= "{$enfrentamiento['jugadorBlanco']}\t{$enfrentamiento['jugadorNegro']}\t{$enfrentamiento['resultado']}\n";
        }
    }

    // Encabezados para forzar la descarga de un archivo de texto
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="diagrama_torneo.txt"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($contenido));
    echo $contenido;
    exit;
}

// Verificar si se solicitó descargar el diagrama
if (isset($_POST['descargar_diagrama'])) {
    descargarDiagramaComoTexto($enfrentamientos_ronda_1, $enfrentamientos_ronda_2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagrama del Torneo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #395094;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #2C4283;
            color: white;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #395094;
        }
        .round-label {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Diagrama del Torneo</h1>

        <?php if (!empty($enfrentamientos_ronda_1)): ?>
            <h2 class="round-label">Primera Ronda</h2>
            <table>
                <thead>
                    <tr>
                        <th>Blancas</th>
                        <th>Negras</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enfrentamientos_ronda_1 as $enfrentamiento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enfrentamiento['jugadorBlanco']); ?></td>
                            <td><?php echo htmlspecialchars($enfrentamiento['jugadorNegro']); ?></td>
                            <td><?php echo htmlspecialchars($enfrentamiento['resultado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (!empty($enfrentamientos_ronda_2)): ?>
            <h2 class="round-label">Segunda Ronda</h2>
            <table>
                <thead>
                    <tr>
                        <th>Blancas</th>
                        <th>Negras</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enfrentamientos_ronda_2 as $enfrentamiento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enfrentamiento['jugadorBlanco']); ?></td>
                            <td><?php echo htmlspecialchars($enfrentamiento['jugadorNegro']); ?></td>
                            <td><?php echo htmlspecialchars($enfrentamiento['resultado']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="button-container">
            <form method="post">
                <button type="submit" name="descargar_diagrama" class="button">Descargar Diagrama</button>
            </form>
            <a href="inicio_eliminacion_simple.php" class="button">Volver a Inicio</a>
        </div>
    </div>
</body>
</html>

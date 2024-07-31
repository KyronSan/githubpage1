<?php
session_start();

// Verificar si existen emparejamientos en la sesión
if (isset($_SESSION['emparejamientos'])) {
    $emparejamientos = $_SESSION['emparejamientos'];
} else {
    $emparejamientos = [];
}

$mensaje = '';

// Procesar los resultados enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se enviaron resultados para la ronda actual
    if (isset($_POST['resultados'])) {
        $todosRellenos = true;
        foreach ($_POST['resultados'] as $index => $resultado) {
            if ($resultado === '') {
                $todosRellenos = false;
                break;
            }
        }

        if ($todosRellenos) {
            foreach ($_POST['resultados'] as $index => $resultado) {
                $_SESSION['emparejamientos'][$index]['resultado'] = $resultado;
            }
            $emparejamientos = $_SESSION['emparejamientos']; // Actualizar emparejamientos con resultados
            // Guardar los resultados en un archivo JSON
            file_put_contents('resultados_ronda_1.json', json_encode($emparejamientos));

            if (count($emparejamientos) === 1) {
                // Si solo queda un emparejamiento, declarar el ganador
                $ganador = $_SESSION['emparejamientos'][0]['resultado'];
                $mensaje = "Todos los resultados han sido registrados. El ganador del torneo es $ganador.";
            } else {
                // Generar emparejamientos para la siguiente ronda si es posible
                $siguienteEmparejamientos = generarSiguienteRonda($emparejamientos);
                // Guardar los emparejamientos de la siguiente ronda en sesión
                $_SESSION['siguiente_emparejamientos'] = $siguienteEmparejamientos;

                // Construir mensaje de éxito
                if (!empty($siguienteEmparejamientos)) {
                    $mensaje = 'Resultados de la ronda actual guardados correctamente. Se han generado los emparejamientos para la siguiente ronda.';
                } else {
                    $mensaje = 'Todos los resultados han sido registrados. Ronda final del torneo.';
                }
            }
        } else {
            $mensaje = 'Por favor, selecciona el resultado de todos los emparejamientos.';
        }
    }

    // Procesar la siguiente ronda si se envían resultados para ella
    if (isset($_POST['resultados_siguiente'])) {
        $resultadosSiguiente = $_POST['resultados_siguiente'];
        $siguienteEmparejamientos = $_SESSION['siguiente_emparejamientos'];

        foreach ($resultadosSiguiente as $index => $resultado) {
            $siguienteEmparejamientos[$index]['resultado'] = $resultado;
        }

        // Guardar los resultados de la siguiente ronda en un archivo JSON
        file_put_contents('resultados_ronda_2.json', json_encode($siguienteEmparejamientos));

        // Verificar si se debe declarar un ganador final
        if (count($siguienteEmparejamientos) === 1) {
            $ganadorFinal = $siguienteEmparejamientos[0]['resultado'];
            $mensaje = "Todos los resultados han sido registrados. El ganador final del torneo es $ganadorFinal.";
            unset($_SESSION['emparejamientos']); // Limpiar sesión de emparejamientos anteriores
        } else {
            $mensaje = 'Resultados de la siguiente ronda guardados correctamente.';
            $_SESSION['siguiente_emparejamientos'] = $siguienteEmparejamientos; // Actualizar sesión con resultados de la siguiente ronda
        }
    }
}

// Función para generar los emparejamientos de la siguiente ronda
function generarSiguienteRonda($emparejamientos) {
    $ganadores = [];
    foreach ($emparejamientos as $pareja) {
        if ($pareja['resultado'] !== 'descanso') {
            $ganadores[] = $pareja['resultado'];
        }
    }

    $numGanadores = count($ganadores);
    $siguienteEmparejamientos = [];

    if ($numGanadores > 1) {
        shuffle($ganadores); // Mezclar los ganadores para variabilidad
        for ($i = 0; $i < $numGanadores; $i += 2) {
            $jugador1 = $ganadores[$i];
            $jugador2 = ($i + 1 < $numGanadores) ? $ganadores[$i + 1] : 'Descanso'; // Si hay un número impar de ganadores, uno descansa
            $siguienteEmparejamientos[] = [$jugador1, $jugador2];
        }
    }

    return $siguienteEmparejamientos;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Emparejamientos - Eliminación Simple</title>
    <style>
        
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #2C4283;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #395094;
        }

        form {
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container"> 
        <h1>Emparejamientos del Torneo - Eliminación Simple</h1>

        <?php if ($mensaje): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <?php if (empty($emparejamientos)): ?>
            <p>No se han generado emparejamientos aún.</p>
        <?php else: ?>
            <form method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Blancas</th>
                            <th>Negras</th>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emparejamientos as $index => $pareja): ?>
                            <?php
                            $jugador1 = htmlspecialchars($pareja[0]);
                            $jugador2 = htmlspecialchars($pareja[1]);
                            $blancas = $index % 2 === 0 ? $jugador1 : $jugador2;
                            $negras = $index % 2 === 0 ? $jugador2 : $jugador1;
                            $resultado = isset($pareja['resultado']) ? $pareja['resultado'] : '';
                            ?>
                            <tr>
                                <td><?php echo $blancas; ?></td>
                                <td><?php echo $negras; ?></td>
                                <td>
                                    <select name="resultados[<?php echo $index; ?>]">
                                        <option value="" <?php echo $resultado === '' ? 'selected' : ''; ?>>Selecciona el resultado</option>
                                        <option value="<?php echo $blancas; ?>" <?php echo $resultado === $blancas ? 'selected' : ''; ?>>Ganó <?php echo $blancas; ?></option>
                                        <option value="<?php echo $negras; ?>" <?php echo $resultado === $negras ? 'selected' : ''; ?>>Ganó <?php echo $negras; ?></option>
                                        <option value="empate" <?php echo $resultado === 'empate' ? 'selected' : ''; ?>>Empate</option>
                                        <?php if ($resultado === 'descanso'): ?>
                                            <option value="descanso" selected>Ganó <?php echo $blancas === $jugador1 ? $jugador1 : $jugador2; ?> por descanso</option>
                                        <?php else: ?>
                                            <option value="descanso">Ganó <?php echo $blancas === $jugador1 ? $jugador1 : $jugador2; ?> por descanso</option>
                                        <?php endif; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" value="<?php echo count($emparejamientos) > 1 ? 'Guardar Resultados y Generar Siguiente Ronda' : 'Finalizar Torneo'; ?>">
            </form>

            <?php if (!empty($siguienteEmparejamientos) && count($emparejamientos) > 1): ?>
                <h2><?php echo count($emparejamientos) > 2 ? 'Siguiente Ronda' : 'Ronda Final'; ?></h2>
                <form method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Jugador Blanco</th>
                                <th>Jugador Negro</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siguienteEmparejamientos as $index => $pareja): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pareja[0]); ?></td>
                                    <td><?php echo htmlspecialchars($pareja[1]); ?></td>
                                    <td>
                                        <select name="resultados_siguiente[<?php echo $index; ?>]">
                                            <option value="" selected>Selecciona el resultado</option>
                                            <option value="<?php echo htmlspecialchars($pareja[0]); ?>">Ganó <?php echo htmlspecialchars($pareja[0]); ?></option>
                                            <option value="<?php echo htmlspecialchars($pareja[1]); ?>">Ganó <?php echo htmlspecialchars($pareja[1]); ?></option>
                                            <option value="empate">Empate</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <input type="submit" value="Guardar Resultados de la Siguiente Ronda">
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Botón para crear diagrama -->
        <a href="diagrama_del_torneo.php" class="button">Crear Diagrama</a>

        <a href="inicio_eliminacion_simple.php" class="button">Volver a Inicio</a>

    </div>
</body>
</html>

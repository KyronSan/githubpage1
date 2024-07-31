<?php
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno = htmlspecialchars($_POST['alumno']);
    
    if (empty($alumno)) {
        $mensaje = "Por favor, ingrese el nombre del alumno";
    } else {
        $data = ['nombre' => $alumno];

        $file = 'alumnos.json';
        $json_data = file_get_contents($file);
        $alumnos = json_decode($json_data, true);

        $alumnos[] = $data;
        file_put_contents($file, json_encode($alumnos));

        $mensaje = "Alumno registrado exitosamente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Alumno - Eliminación Simple</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .mensaje {
            display: none;
            background-color: #0074D9; /* Azul */
            color: white;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            animation: aparecer 0.5s ease-in-out forwards, desaparecer 0.5s ease-in-out 2.5s forwards;
            margin-bottom: 20px;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes desaparecer {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Registrar Alumno - Eliminación Simple</h1>
        
        <form method="post">
            <label for="alumno">Nombre del Alumno:</label>
            <input type="text" id="alumno" name="alumno" required oninvalid="this.setCustomValidity('Por favor, ingrese el nombre del alumno')" oninput="this.setCustomValidity('')">
            <input type="submit" value="Registrar">
        </form>
        
        <div class="mensaje" id="mensajeAnimado"><?php echo htmlspecialchars($mensaje); ?></div>
        
        <a href="inicio_eliminacion_simple.php" class="button">Volver al Inicio de Eliminación Simple</a>
    </div>

    <script>
        // Mostrar mensaje animado
        document.addEventListener('DOMContentLoaded', function() {
            var mensajeAnimado = document.getElementById('mensajeAnimado');
            if (mensajeAnimado.innerHTML.trim() !== '') {
                mensajeAnimado.style.display = 'block';
            }
        });

        // Desaparecer mensaje después de 3 segundos
        setTimeout(function() {
            var mensajeAnimado = document.getElementById('mensajeAnimado');
            mensajeAnimado.style.display = 'none';
        }, 3000);
    </script>
</body>
</html>

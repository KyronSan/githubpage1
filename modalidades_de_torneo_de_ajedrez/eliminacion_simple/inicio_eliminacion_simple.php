<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Eliminación Simple</title>
    <style>
        h1 {
            color: #333;
        }
        .button {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        p {
            color: #FFFFFF;
        }
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
    <script>
        function confirmarLimpieza() {
            return confirm('¿Está seguro de que desea borrar los resultados anteriores?');
        }
    </script>

</head>
<body>
    <div class="container">
        <?php include 'navbar.php'; ?>
        <h1>Inicio Eliminación Simple</h1>

        <?php if (isset($_GET['mensaje'])): ?>
            <div class="mensaje" id="mensajeAnimado"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
        <?php endif; ?>

        <a href="guardar_alumnos.php" class="button">Registrar Alumnos</a>
        <a href="leer_alumnos.php" class="button">Gestionar Alumnos</a>
        <a href="generar_emparejamientos.php" class="button">Generar Emparejamientos</a>
        <a href="diagrama_del_torneo.php" class="button">Ver Diagrama del Torneo</a>
        <a href="limpiar_resultados.php" class="button" onclick="return confirmarLimpieza();">Limpiar Resultados Anteriores</a>
    </div>

    <script>
        // Mostrar mensaje animado
        document.addEventListener('DOMContentLoaded', function() {
            var mensajeAnimado = document.getElementById('mensajeAnimado');
            if (mensajeAnimado) {
                mensajeAnimado.style.display = 'block';
                setTimeout(function() {
                    mensajeAnimado.style.display = 'none';
                }, 3000); // Desaparecer después de 3 segundos
            }
        });
    </script>
</body>
</html>

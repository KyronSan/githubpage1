<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes - Eliminación Simple</title>
    <style> 
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #2C4283;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .header div {
            flex: 1;
            text-align: center;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Lista de Estudiantes - Eliminación Simple</h1>

        <div class="header">
            <div>Nombres:</div>
            <div>Acciones</div>
        </div>

        <?php
        $file = 'alumnos.json';
        if (file_exists($file)) {
            $json_data = file_get_contents($file);
            $alumnos = json_decode($json_data, true);

            if (!empty($alumnos)) {
                echo "<ul>";
                foreach ($alumnos as $key => $alumno) {
                    echo "<li>" . ($key + 1) . ". " . htmlspecialchars($alumno['nombre']) . " ";
                    echo "<a href='editar_alumno.php?id=" . $key . "' class='button'>Editar</a> ";
                    echo "<a href='eliminar_alumno.php?id=" . $key . "' class='button' onclick='return confirm(\"¿Está seguro de que desea eliminar a este estudiante?\")'>Eliminar</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay estudiantes registrados en esta modalidad.</p>";
            }
        } else {
            echo "<p>No se encontró el archivo de estudiantes.</p>";
        }
        ?>

        <a href="inicio_eliminacion_simple.php" class="button">Volver al Inicio de Eliminación Simple</a>
    </div>

</body>
</html>

<?php
session_start(); // Iniciar la sesión para almacenar los emparejamientos (puedes usar otra forma de persistencia si lo prefieres)

$file = 'alumnos.json'; // Archivo donde se guardan los alumnos
$json_data = file_get_contents($file);
$alumnos = json_decode($json_data, true);

$num_alumnos = count($alumnos);

if ($num_alumnos < 2) {
    echo "No hay suficientes alumnos registrados para generar emparejamientos.";
    exit();
}

// Reordenar aleatoriamente los participantes (opcional pero recomendado para variedad)
shuffle($alumnos);

// Generar los emparejamientos
$emparejamientos = [];

for ($i = 0; $i < $num_alumnos; $i += 2) {
    $jugador1 = $alumnos[$i]['nombre'];
    $jugador2 = ($i + 1 < $num_alumnos) ? $alumnos[$i + 1]['nombre'] : 'Descanso'; // Si hay un número impar de jugadores, uno descansa
    $emparejamientos[] = [$jugador1, $jugador2];
}

// Guardar los emparejamientos en la sesión (puedes adaptar esto a una base de datos si lo necesitas)
$_SESSION['emparejamientos'] = $emparejamientos;

// Redireccionar a la página de inicio con un mensaje
header("Location: ver_emparejamientos.php?emparejamientos_generados=true");
exit();
?>

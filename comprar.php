<?php
$bicicletas = [
    'montana' => [
        'nombre' => 'Bicicleta de Montaña',
        'descripcion' => 'Esta bicicleta robusta es perfecta para los caminos más difíciles. Con un diseño inspirado en el estilo clásico, ofrece una experiencia de juego realista y desafiante.'
    ],
    'carrera' => [
        'nombre' => 'Bicicleta de Carrera',
        'descripcion' => 'Con un diseño aerodinámico y ligero, esta bicicleta es ideal para carreras rápidas en el juego. Personalízala con colores vibrantes y haz que destaque en cada competencia.'
    ],
    'urbana' => [
        'nombre' => 'Bicicleta Urbana',
        'descripcion' => 'Perfecta para recorrer la ciudad virtual de "Bicis y Dibujos", esta bicicleta combina estilo y comodidad. ¡Ideal para paseos relajantes por el entorno urbano!'
    ]
];

$bikeKey = isset($_GET['bike']) ? $_GET['bike'] : 'montana';
$bike = $bicicletas[$bikeKey];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Compra - <?php echo $bike['nombre']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Detalle de Compra</h1>
        <p>Estás a punto de adquirir una <?php echo $bike['nombre']; ?> para el juego "Bicis y Dibujos".</p>
    </header>

    <section class="bikes">
        <div class="bike">
            <pre class="ascii-art">
                <?php
                if ($bikeKey == 'montana') {
                    echo "  __o\n -\\<,\n(_)/(_)";
                } elseif ($bikeKey == 'carrera') {
                    echo "     _o\n   _\\<_\n  (_)/(_)";
                } elseif ($bikeKey == 'urbana') {
                    echo "  __o\n _\\<_\n(_)/(_)";
                }
                ?>
            </pre>
            <h2><?php echo $bike['nombre']; ?></h2>
            <p><?php echo $bike['descripcion']; ?></p>
            <button>Confirmar Compra</button>
        </div>
    </section>

    <footer>
        <p>© 2024 Bicis y Dibujos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

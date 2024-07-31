<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['dni'])) {
    echo json_encode(['success' => false]);
    exit;
}

$file = 'dni_guardados.json';

if (file_exists($file)) {
    $json = file_get_contents($file);
    $dataArray = json_decode($json, true);
} else {
    $dataArray = [];
}

$dataArray[] = ['dni' => $data['dni']];

file_put_contents($file, json_encode($dataArray));

echo json_encode(['success' => true]);
?>

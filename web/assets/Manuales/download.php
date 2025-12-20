<?php
ini_set('display_errors', 0);
error_reporting(0);

if (!isset($_GET['file'])) {
    exit('Archivo no especificado');
}

$archivo = basename($_GET['file']);
$extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

$baseDir = dirname(__FILE__);

$rutaPdf   = $baseDir . '/pdf/' . $archivo;
$rutaVideo = $baseDir . '/videos/' . $archivo;

if ($extension === 'pdf' && file_exists($rutaPdf)) {
    $rutaFinal = $rutaPdf;
    $mime = 'application/pdf';
} elseif ($extension === 'mp4' && file_exists($rutaVideo)) {
    $rutaFinal = $rutaVideo;
    $mime = 'video/mp4';
} else {
    exit('Archivo no encontrado');
}

header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $archivo . '"');
header('Content-Length: ' . filesize($rutaFinal));

readfile($rutaFinal);
exit;

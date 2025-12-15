<?php
if (!isset($_GET['file'])) exit('Archivo no válido');

    $file = $_GET['file'];
    $base = realpath(__DIR__ . '/assets/manuals');
    $path = realpath(__DIR__ . '/' . $file);

    if ($path === false || strpos($path, $base) !== 0) {
        exit('Acceso denegado');
    }


    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
?>
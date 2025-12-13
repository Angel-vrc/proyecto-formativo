<?php

    include_once '../lib/helpers.php';
    include_once '../lib/helpersLogin.php';
    
    // Verificar que sea una exportación de seguimientos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteSeguimiento' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        include_once '../controller/Reportes/ReporteSeguimientoController.php';
        $controller = new ReporteSeguimientoController();
        $controller->exportarExcel();
        exit();
    }
    
    // Si no es una exportación válida, redirigir
    header("Location: index.php");
    exit();

?>


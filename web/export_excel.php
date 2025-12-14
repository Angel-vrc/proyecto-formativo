<?php

    
    // Verificar que sea una exportación de seguimientos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteSeguimiento' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        include_once '../controller/Reportes/ReporteSeguimientoController.php';
        $controller = new ReporteSeguimientoController();
        $controller->exportarExcel();
        exit();
    }

    // Verificar que sea una exportación de zoocriaderos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteZoocriadero' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        include_once '../controller/Reportes/ReporteZoocriaderoController.php';
        $controller = new ReporteZoocriaderoController();
        $controller->exportarExcel();
        exit();
    }

    // Verificar que sea una exportación de nacidos y muertos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteNacidosYMuertos' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        include_once '../controller/Reportes/ReporteNacidosYMuertosController.php';
        $controller = new ReporteNacidosYMuertosController();
        $controller->exportarExcel();
        exit();
    }
    

    header("Location: index.php");
    exit();

?>





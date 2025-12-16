<?php

    include_once '../lib/helpers.php';
    
    // Verificar que la sesión esté iniciada
    if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 'ok') {
        $_SESSION['error'] = "Debe iniciar sesión para acceder al sistema";
        redirect('login.php');
        exit();
    }
    
    // Limpiar cualquier output anterior
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // seguimientos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteSeguimiento' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        // Validar permisos antes de exportar
        if (!validarAccesoModulo('Reportes')) {
            $_SESSION['error'] = "No tiene permisos para acceder a este módulo";
            redirect('index.php');
            exit();
        }
        
        include_once '../controller/Reportes/ReporteSeguimientoController.php';
        $controller = new ReporteSeguimientoController();
        $controller->exportarExcel();
        exit();
    }

    // Zoocriadero
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteZoocriadero' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        // Validar permisos antes de exportar
        if (!validarAccesoModulo('Reportes')) {
            $_SESSION['error'] = "No tiene permisos para acceder a este módulo";
            redirect('index.php');
            exit();
        }
        
        include_once '../controller/Reportes/ReporteZoocriaderoController.php';
        $controller = new ReporteZoocriaderoController();
        $controller->exportarExcel();
        exit();
    }

    // nacidos y muertos
    if(isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes' && 
       isset($_GET['controlador']) && $_GET['controlador'] == 'ReporteNacidosYMuertos' && 
       isset($_GET['funcion']) && $_GET['funcion'] == 'exportarExcel'){
        
        // Validar permisos antes de exportar
        if (!validarAccesoModulo('Reportes')) {
            $_SESSION['error'] = "No tiene permisos para acceder a este módulo";
            redirect('index.php');
            exit();
        }
        
        include_once '../controller/Reportes/ReporteNacidosYMuertosController.php';
        $controller = new ReporteNacidosYMuertosController();
        $controller->exportarExcel();
        exit();
    }
    

    redirect('index.php');
    exit();


<?php

    session_start();
    function redirect($url){
        echo "<script>".
                "window.location.href = '$url';".
            "</script>";

    } 
    
    function dd($var){
        echo "<pre>";
        die(print_r($var));
    }
    
    function getUrl($modulo,$controlador,$funcion,$parametros=false,$pagina=false){

        if($pagina==false){
            $pagina = "index";
        }

        $url = "$pagina.php?modulo=$modulo&controlador=$controlador&funcion=$funcion";

        if($parametros!=false){
            foreach($parametros as $key => $valor){
                $url.="&$key=$valor";
            }
        }
        return $url;
    }


    function resolve(){
        
        $modulo = ucwords($_GET['modulo']); // modulo-> carpeta dentro del controlador
        $controlador = ucwords($_GET['controlador']); // controlador -> archivo controller dentro del modulo
        $funcion = $_GET['funcion']; // funcion -> metodo dentro de la clase del controlador

        if(is_dir("../controller/".$modulo)){
            if(is_file("../controller/".$modulo."/".$controlador."Controller.php")){

                require_once("../controller/".$modulo."/".$controlador."Controller.php");

                $controlador = $controlador."Controller";
                

                $objClase = new $controlador();

                if(method_exists($objClase,$funcion)){
                    $objClase->$funcion();
                }else{
                    echo "La funcion especificada no existe";
                }
            }else{
                echo "El controlador especificado no existe";
            }
        }else{
            echo "El modulo especificado no existe";
        }


    }

    function isActiveModule($moduleName) {
        $currentModulo = isset($_GET['modulo']) ? $_GET['modulo'] : '';
        $currentControlador = isset($_GET['controlador']) ? $_GET['controlador'] : '';
        
        // Para módulos que coinciden exactamente
        if ($currentModulo == $moduleName) {
            return 'active';
        }
        
        // Casos especiales o alias si los tienes

        $moduleAliases = array('Dashboard' => array('', 'Dashboard', 'Inicio'),
                                'Mapa' => array('Mapa', 'Visualizacion'),
                                'Seguridad' => array('Usuarios', 'Roles')

        );
        
        if (isset($moduleAliases[$moduleName])) {
            if (in_array($currentModulo, $moduleAliases[$moduleName])) {
                return 'active';
            }
        }
        
        return '';
    }

    function isActiveController($controllerName) {
        $currentControlador = isset($_GET['controlador']) ? $_GET['controlador'] : '';
        return ($currentControlador == $controllerName) ? 'active' : '';
    }

    function validacionPermisos($slugModulo) {
        include_once '../lib/conf/connection.php';

        $obj = new Connection();

        $idRol = $_SESSION['id_rol'];

        $sql = "SELECT 1 FROM permisos p, modulos m WHERE (p.id_modulos = m.id OR p.id_modulos = m.id_modulo_padre) AND m.slug = '$slugModulo' AND p.id_roles = $idRol";


        $res = pg_query($obj->getConnect(), $sql);
        return pg_num_rows($res) > 0;
    }


    function calcularPaginacion($registrosPorPagina = 10) {
        $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
        
        // Validar que la página sea mayor a 0
        if ($pagina < 1) {
            $pagina = 1;
        }
        
        $limite = intval($registrosPorPagina);
        $offset = ($pagina - 1) * $limite;
        
        return array(
            'pagina' => $pagina,
            'limite' => $limite,
            'offset' => $offset,
            'registrosPorPagina' => $registrosPorPagina
        );
    }


    function aplicarPaginacionSQL($sql, $limite, $offset) {
        $sql = trim($sql);
        $sql .= " LIMIT $limite OFFSET $offset";
        return $sql;
    }


    function obtenerTotalRegistros($connection, $sql) {
        // Remover LIMIT y OFFSET si existen
        $sqlLimpia = preg_replace('/\s+LIMIT\s+\d+/i', '', $sql);
        $sqlLimpia = preg_replace('/\s+OFFSET\s+\d+/i', '', $sqlLimpia);
        
        // Crear una consulta COUNT basada en la consulta original
        $sqlCount = "SELECT COUNT(*) as total FROM (" . trim($sqlLimpia) . ") as subquery";
        $result = pg_query($connection, $sqlCount);
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            return intval($row['total']);
        }
        
        return 0;
    }


    function generarPaginacion($totalRegistros, $paginaActual, $registrosPorPagina, $parametrosAdicionales = array()) {
        if ($totalRegistros <= 0) {
            return '<ul class="pagination"><li class="page-item disabled"><span class="page-link">No hay registros</span></li></ul>';
        }
        
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
        
        if ($totalPaginas <= 1) {
            return '';
        }
        
        // Obtener parámetros base (módulo, controlador, función)
        $modulo = isset($parametrosAdicionales['modulo']) ? $parametrosAdicionales['modulo'] : (isset($_GET['modulo']) ? $_GET['modulo'] : '');
        $controlador = isset($parametrosAdicionales['controlador']) ? $parametrosAdicionales['controlador'] : (isset($_GET['controlador']) ? $_GET['controlador'] : '');
        $funcion = isset($parametrosAdicionales['funcion']) ? $parametrosAdicionales['funcion'] : (isset($_GET['funcion']) ? $_GET['funcion'] : 'lista');
        
        // Construir parámetros para getUrl (mantener parámetros adicionales excepto los base)
        $parametrosUrl = array();
        foreach ($parametrosAdicionales as $key => $value) {
            if (!in_array($key, array('modulo', 'controlador', 'funcion'))) {
                $parametrosUrl[$key] = $value;
            }
        }
        
        // Mantener otros parámetros GET (excepto 'pagina')
        foreach ($_GET as $key => $value) {
            if ($key != 'pagina' && !in_array($key, array('modulo', 'controlador', 'funcion'))) {
                $parametrosUrl[$key] = $value;
            }
        }
        
        $html = '<ul class="pagination justify-content-end">';
        
        // Botón "Anterior"
        if ($paginaActual > 1) {
            $paginaAnterior = $paginaActual - 1;
            $parametrosAnterior = $parametrosUrl;
            $parametrosAnterior['pagina'] = $paginaAnterior;
            $urlAnterior = getUrl($modulo, $controlador, $funcion, $parametrosAnterior);
            $html .= '<li class="page-item"><a class="page-link" href="' . $urlAnterior . '">Anterior</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
        }
        
        // Calcular rango de páginas a mostrar
        $rango = 2; // Número de páginas a mostrar a cada lado de la página actual
        $inicio = max(1, $paginaActual - $rango);
        $fin = min($totalPaginas, $paginaActual + $rango);
        
        // Mostrar primera página si no está en el rango
        if ($inicio > 1) {
            $parametrosPrimera = $parametrosUrl;
            $parametrosPrimera['pagina'] = 1;
            $urlPrimera = getUrl($modulo, $controlador, $funcion, $parametrosPrimera);
            $html .= '<li class="page-item"><a class="page-link" href="' . $urlPrimera . '">1</a></li>';
            if ($inicio > 2) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }
        
        // Mostrar páginas en el rango
        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i == $paginaActual) {
                $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                $parametrosPagina = $parametrosUrl;
                $parametrosPagina['pagina'] = $i;
                $urlPagina = getUrl($modulo, $controlador, $funcion, $parametrosPagina);
                $html .= '<li class="page-item"><a class="page-link" href="' . $urlPagina . '">' . $i . '</a></li>';
            }
        }
        
        // Mostrar última página si no está en el rango
        if ($fin < $totalPaginas) {
            if ($fin < $totalPaginas - 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $parametrosUltima = $parametrosUrl;
            $parametrosUltima['pagina'] = $totalPaginas;
            $urlUltima = getUrl($modulo, $controlador, $funcion, $parametrosUltima);
            $html .= '<li class="page-item"><a class="page-link" href="' . $urlUltima . '">' . $totalPaginas . '</a></li>';
        }
        
        // Botón "Siguiente"
        if ($paginaActual < $totalPaginas) {
            $paginaSiguiente = $paginaActual + 1;
            $parametrosSiguiente = $parametrosUrl;
            $parametrosSiguiente['pagina'] = $paginaSiguiente;
            $urlSiguiente = getUrl($modulo, $controlador, $funcion, $parametrosSiguiente);
            $html .= '<li class="page-item"><a class="page-link" href="' . $urlSiguiente . '">Siguiente</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }


    function generarInfoPaginacion($totalRegistros, $paginaActual, $registrosPorPagina) {
        if ($totalRegistros <= 0) {
            return 'Mostrando 0 registros';
        }
        
        $inicio = (($paginaActual - 1) * $registrosPorPagina) + 1;
        $fin = min($paginaActual * $registrosPorPagina, $totalRegistros);
        
        return "Mostrando $inicio-$fin de $totalRegistros registros";
    }


?>
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
        
        // Verificar que la sesión esté iniciada
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 'ok') {
            $_SESSION['error_helpers'] = "Debe iniciar sesión para acceder al sistema";
            redirect('login.php');
            exit();
        }

        $modulo = isset($_GET['modulo']) ? $_GET['modulo'] : '';
        $controlador = isset($_GET['controlador']) ? $_GET['controlador'] : '';
        $funcion = isset($_GET['funcion']) ? $_GET['funcion'] : '';

        // Validar que los parámetros requeridos estén presentes
        if (empty($modulo) || empty($controlador) || empty($funcion)) {
            $_SESSION['error_helpers'] = "Parámetros de acceso inválidos";
            redirect('index.php');
            exit();
        }

        // Normalizar nombres (capitalizar primera letra de cada palabra)
        $modulo = ucwords($modulo);
        $controlador = ucwords($controlador);

        // Validar permisos antes de acceder al módulo
        if (!validarAccesoModulo($modulo)) {
            $_SESSION['error_helpers'] = "No tiene permisos para acceder a ese módulo";
            redirect('index.php');
            exit();
        }

        // Obtener el slug del módulo para validación de acciones
        $slugModulo = obtenerSlugModulo($modulo);
        
        // Obtener la acción correspondiente a la función
        $accion = obtenerAccionPorFuncion($funcion);
        
        // Si se puede determinar la acción, validar el permiso específico
        if ($accion !== null && !empty($slugModulo)) {
            if (!validarAccionModulo($slugModulo, $accion)) {
                $_SESSION['error_helpers'] = "No tiene permisos para realizar la acción '$accion' en este módulo";
                redirect('index.php');
                exit();
            }
        }

        if(is_dir("../controller/".$modulo)){
            if(is_file("../controller/".$modulo."/".$controlador."Controller.php")){

                require_once("../controller/".$modulo."/".$controlador."Controller.php");

                $controlador = $controlador."Controller";
                

                $objClase = new $controlador();

                if(method_exists($objClase,$funcion)){
                    $objClase->$funcion();
                }else{
                    $_SESSION['error_helpers'] = "La función especificada no existe";
                    redirect('index.php');
                    exit();
                }
            }else{
                $_SESSION['error_helpers'] = "El controlador especificado no existe";
                redirect('index.php');
                exit();
            }
        }else{
            $_SESSION['error_helpers'] = "El módulo especificado no existe";
            redirect('index.php');
            exit();
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
        $connect = $obj->getConnect();

        // Validar que la sesión tenga id_rol
        if (!isset($_SESSION['id_rol']) || empty($_SESSION['id_rol'])) {
            return false;
        }

        $idRol = intval($_SESSION['id_rol']); // Asegurar que sea un entero
        
        // Escapar el slug para prevenir SQL injection
        $slugModulo = pg_escape_string($connect, $slugModulo);

        $sql = "SELECT 1 FROM permisos p, modulos m 
                WHERE (p.id_modulos = m.id OR p.id_modulos = m.id_modulo_padre) 
                AND m.slug = '$slugModulo' 
                AND p.id_roles = $idRol
                AND p.id_acciones = 2
                LIMIT 1";

        $res = pg_query($connect, $sql);
        
        if ($res === false) {
            return false;
        }
        
        return pg_num_rows($res) > 0;
    }

    /**
     * Mapea el nombre del módulo (como viene en la URL) al slug del módulo en la base de datos
     * @param string $nombreModulo Nombre del módulo desde $_GET['modulo']
     * @return string Slug del módulo para validación de permisos
     */
    function obtenerSlugModulo($nombreModulo) {
        // Normalizar el nombre del módulo (capitalizar primera letra de cada palabra)
        $nombreModulo = ucwords($nombreModulo);
        
        // Mapeo de nombres de módulos a slugs (basado en la tabla modulos de la BD)
        $mapeoModulos = array(
            'Zoocriaderos' => 'zoocriaderos',
            'Tanques' => 'tanques',
            'Tipo_tanques' => 'tipo_tanques',
            'Tipo Tanques' => 'tipo_tanques', // Variante con espacio
            'Tipo_actividad' => 'tipo_actividad',
            'Tipo Actividad' => 'tipo_actividad', // Variante con espacio
            'Actividad' => 'tipo_actividad', // Alias: el módulo Actividad usa el slug tipo_actividad
            'Seguimiento' => 'seguimiento',
            'Usuarios' => 'usuarios',
            'Roles' => 'roles',
            'Reportes' => 'reportes',
            'Configuracion' => 'configuracion',
            'Mapa' => 'mapa',
            'Login' => '', // Login no requiere validación de permisos (ya está protegido por helpersLogin)
            'Perfil' => '' // Perfil no requiere validación de permisos (acceso propio del usuario)
        );
        
        if (isset($mapeoModulos[$nombreModulo])) {
            return $mapeoModulos[$nombreModulo];
        }

        // Si no está en el mapeo, por seguridad retornar vacío (negar acceso)
        return '';
    }

    /**
     * Valida si el usuario tiene permisos para acceder a un módulo
     * @param string $nombreModulo Nombre del módulo
     * @return bool True si tiene permisos, False si no
     */
    function validarAccesoModulo($nombreModulo) {
        // Verificar si la sesión está iniciada
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== 'ok') {
            return false;
        }

        // Módulos que no requieren validación de permisos
        $modulosPublicos = array('Login', 'Perfil');
        
        if (in_array($nombreModulo, $modulosPublicos)) {
            return true;
        }

        // Obtener el slug del módulo
        $slugModulo = obtenerSlugModulo($nombreModulo);
        
        // Si no hay slug, no se puede validar (por seguridad, denegar acceso)
        if (empty($slugModulo)) {
            return false;
        }

        // Validar permisos
        return validacionPermisos($slugModulo);
    }

    /**
     * Valida si el usuario tiene permiso para una acción específica en un módulo
     * @param string $slugModulo Slug del módulo
     * @param string $nombreAccion Nombre de la acción (Registrar, Consultar, Actualizar, Eliminar)
     * @return bool True si tiene permiso, False si no
     */
    function validarAccionModulo($slugModulo, $nombreAccion) {
        include_once '../lib/conf/connection.php';

        $obj = new Connection();
        $connect = $obj->getConnect();

        // Validar que la sesión tenga id_rol
        if (!isset($_SESSION['id_rol']) || empty($_SESSION['id_rol'])) {
            return false;
        }

        $idRol = intval($_SESSION['id_rol']); // Asegurar que sea un entero
        
        // Escapar valores para prevenir SQL injection
        $slugModulo = pg_escape_string($connect, $slugModulo);
        $nombreAccion = pg_escape_string($connect, $nombreAccion);

        $sql = "SELECT 1 FROM permisos p, modulos m, acciones a 
                WHERE (p.id_modulos = m.id OR p.id_modulos = m.id_modulo_padre) 
                AND m.slug = '$slugModulo' 
                AND p.id_roles = $idRol
                AND p.id_acciones = a.id
                AND a.nombre = '$nombreAccion'
                LIMIT 1";

        $res = pg_query($connect, $sql);
        
        if ($res === false) {
            return false;
        }
        
        return pg_num_rows($res) > 0;
    }

    /**
     * Helper para usar en vistas: verifica si el usuario tiene permiso para una acción
     * @param string $slugModulo Slug del módulo
     * @param string $nombreAccion Nombre de la acción (Registrar, Consultar, Actualizar, Eliminar)
     * @return bool True si tiene permiso, False si no
     */
    function tienePermiso($slugModulo, $nombreAccion) {
        return validarAccionModulo($slugModulo, $nombreAccion);
    }

    /**
     * Obtiene la acción correspondiente según la función del controlador
     * @param string $funcion Nombre de la función del controlador
     * @return string Nombre de la acción o null si no se puede determinar
     */
    function obtenerAccionPorFuncion($funcion) {
        // Mapeo de funciones a acciones
        $mapeoFunciones = array(
            // Consultar
            'lista' => 'Consultar',
            'list' => 'Consultar',
            'filtro' => 'Consultar',
            // Registrar
            'getCreate' => 'Registrar',
            'postCreate' => 'Registrar',
            // Actualizar
            'getUpdate' => 'Actualizar',
            'postUpdate' => 'Actualizar',
            'updateStatus' => 'Activar',
            // Eliminar
            'getDelete' => 'Eliminar',
            'postDelete' => 'Eliminar',
            'delete' => 'Eliminar',
            'eliminar' => 'Eliminar'
        );

        if (isset($mapeoFunciones[$funcion])) {
            return $mapeoFunciones[$funcion];
        }

        // Por defecto, si no se puede determinar, retornar null
        return null;
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
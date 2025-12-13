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

?>
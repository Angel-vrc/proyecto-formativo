<?php

    include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

    class ZoocriaderoController{


        public function lista(){
            $obj = new ZoocriaderoModel();

            $sql = "SELECT z.*, e.nombre nombre_estado, u.nombre nombre_responsable, u.apellido apellido_responsable FROM zoocriadero z, usuarios u,zoocriadero_estado e WHERE z.responsable = u.id AND z.id_estado = e.id_estado
            ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/list.php';
        }
        
        public function getCreate(){
            $obj = new ZoocriaderoModel();

            //Falta hacer el echo en su respectivo input en el formulario
            // $longitud = $_GET['longitud'];
            // $latitud = $_GET['latitud'];

            $sql = "SELECT id, nombre, apellido FROM usuarios";

            $usuarios = $obj->select($sql);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/create.php';
        }

        public function postCreate(){
            $obj = new ZoocriaderoModel();


            $id_zoocriadero = $obj->autoincrement("zoocriadero", "id_zoocriadero");
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $comuna = $_POST['comuna'];
            $barrio = $_POST['barrio'];
            $responsable = $_POST['responsable'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $punto = "ST_SetSRID(ST_GeomFromText('POINT(-74.5075 4.31428571429)'), 4326)"; 
            
            $sql = "INSERT INTO zoocriadero VALUES ($id_zoocriadero, '$responsable', '$direccion', '', '$telefono', '$comuna', '$barrio', '$nombre', $punto, 1, '$correo')";

            echo $sql;

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero creado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }
        }


        public function getDelete(){
            $obj = new ZoocriaderoModel();
            $id_zoocriadero = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id_zoocriadero <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                return;
            }


            $sql = "SELECT z.*, u.nombre AS responsable_nombre, u.apellido AS responsable_apellido, e.nombre AS estado_nombre FROM zoocriadero AS z
            JOIN usuarios AS u ON z.responsable = u.id
            JOIN zoocriadero_estado AS e ON z.id_estado = e.id_estado
            WHERE z.id_zoocriadero = $id_zoocriadero;";

            $zoocriadero = $obj->select($sql);

            if(empty($zoocriadero)){
                echo "El zoocriadero solicitado no existe";
            }

            include_once '../view/zoocriaderos/delete.php';
        }

        public function postDelete(){
            $obj = new ZoocriaderoModel();

            $id_zoocriadero = ($_POST['id']);

            $sql = "UPDATE zoocriadero SET id_estado = 2 WHERE id_zoocriadero = $id_zoocriadero";

            $resultado = $obj->update($sql);
            
            if($resultado){
                $_SESSION['success'] = "Zoocriadero deshabilitado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }

        }

        public function updateStatus(){
            $obj = new ZoocriaderoModel();
            $id_zoocriadero = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id_zoocriadero <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                return;
            }

            $sql = "UPDATE zoocriadero SET id_estado=1 WHERE id_zoocriadero=$id_zoocriadero";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero habilitado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }
        }


        public function getUpdate(){
            $obj = new ZoocriaderoModel();  

            $id_zoocriadero = $_GET['id'];
            $sql = "SELECT * FROM zoocriadero WHERE id_zoocriadero = $id_zoocriadero";

            $zoocriadero = $obj->select($sql);

            $sql = "SELECT id, nombre, apellido FROM usuarios";

            $usuarios = $obj->select($sql);

            include_once '../lib/data/ubicacion.php';
            include_once '../view/zoocriaderos/update.php';
        }

        public function postUpdate(){
            $obj = new ZoocriaderoModel();

            $id_zoocriadero = $_POST['id'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $comuna = $_POST['comuna'];
            $barrio = $_POST['barrio'];
            $responsable = $_POST['responsable'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];

            $sql = "UPDATE zoocriadero SET nombre='$nombre', direccion='$direccion', comuna='$comuna', barrio='$barrio', responsable='$responsable', telefono='$telefono', correo='$correo' WHERE id_zoocriadero=$id_zoocriadero";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Zoocriadero actualizado correctamente";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el zoocriadero";
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
                exit();
            }
        }

        public function filtro() {
            $obj = new ZoocriaderoModel();

            // Obtener filtros
            $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
            $comuna = isset($_GET['comuna']) ? trim($_GET['comuna']) : '';

            $where = array();

            // Filtro por texto (nombre o responsable)
            if ($buscar !== '') {
                $buscar_escaped = pg_escape_string($buscar);
                $where[] = "(z.nombre ILIKE '%$buscar_escaped%' 
                            OR u.nombre ILIKE '%$buscar_escaped%' 
                            OR u.apellido ILIKE '%$buscar_escaped%')";
            }

            // Filtro por comuna (igualdad exacta)
            if ($comuna !== '') {
                $comuna_escaped = pg_escape_string($comuna);
                $where[] = "z.comuna = '$comuna_escaped'";
            }

            // SQL base
            $sql = "SELECT z.*, e.nombre nombre_estado, u.nombre nombre_responsable, u.apellido apellido_responsable
                    FROM zoocriadero z
                    JOIN usuarios u ON z.responsable = u.id
                    JOIN zoocriadero_estado e ON z.id_estado = e.id_estado";

            // Agregar WHERE dinámico si hay filtros
            if (count($where) > 0) {
                $sql .= " WHERE " . implode(" AND ", $where);
            }

            $sql .= " ORDER BY z.id_zoocriadero ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../view/zoocriaderos/filtro.php';
        }
        
    }


?>
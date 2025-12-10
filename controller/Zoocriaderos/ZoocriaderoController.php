<?php

    include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

    class ZoocriaderoController{


        public function lista(){
            $obj = new ZoocriaderoModel();

            $sql = "SELECT z.*, e.nombre AS nombre_estado, u.nombre AS nombre_responsable, u.apellido AS apellido_responsable FROM zoocriadero AS z
            JOIN usuarios AS u ON z.responsable = u.id
            JOIN zoocriadero_estado AS e ON z.id_estado = e.id_estado
            ORDER BY id_zoocriadero ASC";

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

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{                
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
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

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
            }else{
                echo "No se pudo actualizar el zoocriadero";
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

            $ejecutar = $obj->update($sql);

            if($ejecutar){
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
            }else{
                echo "El zoocriadero solicitado no existe.";
                return;
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
                redirect(getUrl("Zoocriaderos","Zoocriadero","lista"));
            }else{
                echo "error de insercion";
            }
        }

    }


?>
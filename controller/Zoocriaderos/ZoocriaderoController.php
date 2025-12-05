<?php

    include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

    class ZoocriaderoController{


        public function list(){
            $obj = new ZoocriaderoModel();

            $sql = "SELECT * FROM zoocriaderos ORDER BY id ASC";

            $zoocriaderos = $obj->select($sql);

            include_once '../view/zoocriaderos/list.php';
        }
        
        public function getCreate(){
            $obj = new ZoocriaderoModel();
            
            include_once '../view/zoocriaderos/create.php';
        }

        public function postCreate(){
            $obj = new ZoocriaderoModel();


            $id = $obj->autoincrement("zoocriaderos", "id");
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $comuna = $_POST['comuna'];
            $barrio = $_POST['barrio'];
            $responsable = $_POST['responsable'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            
            $sql = "INSERT INTO zoocriaderos VALUES ($id, '$nombre', '$direccion', '$comuna', '$barrio', '$responsable', '$telefono', '$correo')";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{                
                include_once '../view/zoocriaderos/list.php';
            }
        }


        public function getDelete(){
            $obj = new ZoocriaderoModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;


            if($id <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","list"));
                return;
            }

            include_once '../view/zoocriaderos/delete.php';
        }

        public function postDelete(){
            $obj = new ZoocriaderoModel();

            $id = ($_POST['id']);

            $sql = "UPDATE zoocriaderos SET estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                redirect(getUrl("Zoocriaderos","Zoocriadero","list"));
            }else{
                echo "No se pudo actualizar el zoocriadero";
            }

        }

        public function updateStatus(){
            $obj = new ZoocriaderoModel();
            $id = isset($_GET['key']) ? intval($_GET['key']) : 0;

            if($id <= 0){
                redirect(getUrl("Zoocriaderos","Zoocriadero","list"));
                return;
            }

            $sql = "UPDATE zoocriadero SET estado=1 WHERE id=$id";

            $zoocriadero = $obj->update($sql);

            if(empty($zoocriadero)){
                echo "El zoocriadero solicitado no existe.";
                return;
            }

            include_once '../view/zoocriaderos/list.php';
        }

        public function

    }


?>
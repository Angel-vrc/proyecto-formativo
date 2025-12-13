<?php 
    include_once '../model/Tipo_tanques/Tipo_tanquesModel.php';

    class TipotanqueController{
        public function lista(){
            $obj = new Tipo_tanquesModel();
         
            $sql = "SELECT id,nombre,id_estado AS estado FROM tipo_tanque ORDER BY id ASC";
            $tipos = $obj->select($sql);

            include_once '../view/tipo_tanques/list.php';
        }
                
        public function getCreate(){
            $obj = new Tipo_tanquesModel();

            include_once '../view/tipo_tanques/create.php';
        }
        
        public function postCreate(){
            $obj = new Tipo_tanquesModel();
            
            $id = $obj->autoincrement("tipo_tanque", "id");
            $nombre = $_POST['nombre'];
            
            $sql = "INSERT INTO tipo_tanque (id, nombre )VALUES ($id, '$nombre')";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
            }
        }
//        falta la tabla de estado por ahora se queda como referencia el de tanque
         public function getDelete(){
            $obj = new Tipo_tanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                return;
            }
            include_once '../view/tipo_tanques/delete.php';
        }

        public function postDelete(){
            $obj = new Tipo_tanquesModel();

            $id = ($_POST['id']);

            $sql = "UPDATE tipo_tanque SET id_estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
            }else{
                echo "No se pudo actualizar el  tipo de tanque";
            }
        }

        public function updateStatus(){
            $obj = new Tipo_tanquesModel();
            $id = intval($_GET['id']);

            if($id > 0){
                $obj->update("UPDATE tipo_tanque SET id_estado = 1 WHERE id = $id");
            }

            redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
        }

        public function getUpdate(){
            $obj = new Tipo_tanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                return;
            }

            $sql = "SELECT * FROM tipo_tanque WHERE id = $id";
            $tipo_tanque = pg_fetch_assoc($obj->select($sql));

            if(!$tipo_tanque){
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                return;
            }

            include_once '../view/tipo_tanques/update.php';
        }

        public function postUpdate(){
            $obj = new Tipo_tanquesModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $sql = "UPDATE tipo_tanque SET nombre = '$nombre' WHERE id = $id";

            $resultado = $obj->update($sql);

            if(!$resultado){
                echo "Error al actualizar el tipo de tanque";
            } else {
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
            }
        }
    }
?>
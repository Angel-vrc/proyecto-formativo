<?php 
    include_once '../model/Tipo_actividad/Tipo_actividadModel.php';

    class TipoactividaController{
        public function list(){
            $obj = new Tipo_actividadModel();
         
            $sql = "SELECT * FROM tipo_actividad ORDER BY id ASC";
            $tipos = $obj->select($sql);

            include_once '../view/tipo_actividad/list.php';
        }
                
        public function getCreate(){
            $obj = new Tipo_actividadModel();

            include_once '../view/tipo_actividad/create.php';
        }
        
        public function postCreate(){
            $obj = new Tipo_actividadModel();
            
            $id = $obj->autoincrement("Tipo_actividad", "id");
            $nombre = $_POST['nombre'];
            
            $sql = "INSERT INTO tipo_actividad (id, nombre )VALUES ($id, '$nombre')";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
            }
        }
//        falta la tabla de estado por ahora se queda como referencia el de tanque
         public function getDelete(){
            $obj = new Tipo_actividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","list"));
                return;
            }
            include_once '../view/tanques/delete.php';
        }

        public function postDelete(){
            $obj = new Tipo_actividadModel();

            $id = ($_POST['id']);

            $sql = "UPDATE Tanques SET estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                redirect(getUrl("Tanques","Tanque","list"));
            }else{
                echo "No se pudo actualizar el tanque";
            }
        }
//      esta hecho pero pues falta "eliminar"
        public function getUpdate(){
            $obj = new Tipo_actividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                return;
            }

            $sql = "SELECT * FROM tipo_actividad WHERE id = $id";
            $tipo_actividad = pg_fetch_assoc($obj->select($sql));

            if(!$tipo_actividad){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                return;
            }

            include_once '../view/tipo_actividad/update.php';
        }

        public function postUpdate(){
            $obj = new Tipo_actividadModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $sql = "UPDATE tipo_actividad SET nombre = '$nombre' WHERE id = $id";

            $resultado = $obj->update($sql);

            if(!$resultado){
                echo "Error al actualizar el tipo de actividad";
            } else {
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
            }
        }
    }
?>
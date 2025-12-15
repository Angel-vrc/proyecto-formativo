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
        public function getDelete(){
            $obj = new Tipo_actividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                return;
            }

            $sql = "SELECT *, 
                           CASE WHEN id_estado = 1 THEN 'Activo' WHEN id_estado = 2 THEN 'Inactivo' ELSE 'Desconocido' END AS estado_nombre
                    FROM tipo_actividad 
                    WHERE id = $id";

            $tipo_actividad = $obj->select($sql);

            if(!$tipo_actividad || pg_num_rows($tipo_actividad) == 0){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                return;
            }

            include_once '../view/tipo_actividad/delete.php';
        }

        public function postDelete(){
            $obj = new Tipo_actividadModel();
            $id = intval($_POST['id']);

            if($id <= 0){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                return;
            }

            $sql = "UPDATE tipo_actividad SET id_estado = 2 WHERE id = $id";

            $resultado = $obj->update($sql);
            
            if($resultado){
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                exit();
            }else{
                redirect(getUrl("Tipo_actividad","Tipoactivida","list"));
                exit();
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
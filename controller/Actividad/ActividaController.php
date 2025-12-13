<?php 
    include_once '../model/Actividad/ActividadModel.php';

    class  ActividaController {
        public function lista(){
            $obj = new ActividadModel();
         
            $sql = "SELECT id,nombre,id_estado AS estado FROM actividad ORDER BY id ASC";
            $tipos = $obj->select($sql);

            include_once '../view/actividad/list.php';
        }
                
        public function getCreate(){
            $obj = new ActividadModel();

            include_once '../view/actividad/create.php';
        }
        
        public function postCreate(){
            $obj = new ActividadModel();
            
            $id = $obj->autoincrement("actividad", "id");
            $nombre = $_POST['nombre'];
            
            $sql = "INSERT INTO actividad (id, nombre )VALUES ($id, '$nombre')";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{
                redirect(getUrl("Actividad","Activida","lista"));
            }
        }
        public function getDelete(){
            $obj = new ActividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            $sql = "SELECT *, 
                           CASE WHEN id_estado = 1 THEN 'Activo' WHEN id_estado = 2 THEN 'Inactivo' ELSE 'Desconocido' END AS estado_nombre
                    FROM actividad 
                    WHERE id = $id";

            $actividad = $obj->select($sql);

            if(!$actividad || pg_num_rows($actividad) == 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            include_once '../view/actividad/delete.php';
        }

        public function postDelete(){
            $obj = new ActividadModel();
            $id = intval($_POST['id']);

            if($id <= 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            $sql = "UPDATE actividad SET id_estado = 2 WHERE id = $id";

            $resultado = $obj->update($sql);
            
            if($resultado){
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }else{
                redirect(getUrl("Actividad","Activida","lista"));
                exit();
            }
        }
        //para el activar
        public function updateStatus(){
            $obj = new ActividadModel();
            $id = intval($_GET['id']);

            if($id > 0){
                $obj->update("UPDATE actividad SET id_estado = 1 WHERE id = $id");
            }

            redirect(getUrl("Actividad","Activida","lista"));
        }

        public function getUpdate(){
            $obj = new ActividadModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            $sql = "SELECT * FROM actividad WHERE id = $id";
            $tipo_actividad = pg_fetch_assoc($obj->select($sql));

            if(!$tipo_actividad){
                redirect(getUrl("Actividad","Activida","lista"));
                return;
            }

            include_once '../view/actividad/update.php';
        }

        public function postUpdate(){
            $obj = new ActividadModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $sql = "UPDATE actividad SET nombre = '$nombre' WHERE id = $id";

            $resultado = $obj->update($sql);

            if(!$resultado){
                echo "Error al actualizar el tipo de actividad";
            } else {
                redirect(getUrl("Actividad","Activida","lista"));
            }
        }
    }
?>
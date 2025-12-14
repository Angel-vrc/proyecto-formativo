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

            if($resultado){
                $_SESSION['success'] = "tipo de tanque creado correctamento";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el tipo de tanque";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }
        }

         public function getDelete(){
            $obj = new Tipo_tanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                return;
            }

            $sql = "SELECT tpt.id, tpt.nombre, tpts.nombre AS estado
            FROM tipo_tanque tpt INNER JOIN tipo_tanque_estado tpts ON tpt.id_estado = tpts.id
            WHERE tpt.id = $id;";

            $tipoestados = $obj->select($sql);
            include_once '../view/tipo_tanques/delete.php';
        }

        public function postDelete(){
            $obj = new Tipo_tanquesModel();

            $id = ($_POST['id']);

            $sql = "UPDATE tipo_tanque SET id_estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                $_SESSION['success'] = "tipo de tanque deshabilitado correctamente";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el tipo de tanque";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }
        }

        public function updateStatus(){
            $obj = new Tipo_tanquesModel();
            $id = intval($_GET['id']);

            $sql = "UPDATE tipo_tanque SET id_estado=1 WHERE id=$id";

            $resultado = $obj->update($sql);
            
            if($id > 0){
                $obj->update("UPDATE tipo_tanque SET id_estado = 1 WHERE id = $id");
            }

            if($resultado){
                $_SESSION['success'] = "tipo de tanque habilitado correctamente";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el tipo de tanque";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }
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

            if($resultado){
                $_SESSION['success'] = "tipo de tanque actualizado correctamente";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el tipo de tanque";
                redirect(getUrl("Tipo_tanques","Tipotanque","lista"));
                exit();
            }
        }
    }
?>
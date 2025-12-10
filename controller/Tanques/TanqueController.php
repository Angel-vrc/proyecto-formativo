<?php 
    include_once '../model/Tanques/TanquesModel.php';

    class TanqueController{
        public function list(){
            $obj = new TanquesModel();

            $nombre = $_GET['nombre'] ?? '';
            $tipo   = $_GET['tipo'] ?? '';

            $where = "WHERE 1=1";

            if($nombre != ''){
                $where .= " AND t.nombre ILIKE '%$nombre%'";
            }

            if($tipo != ''){
                $where .= " AND t.id_tipo_tanque = $tipo";
            }

            $sql = "SELECT t.id,t.nombre,t.medidas,t.cantidad_peces,t.id_estado AS estado,tt.nombre AS tipo_tanque
            FROM tanques t INNER JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id $where ORDER BY t.id ASC";

            $tanques = $obj->select($sql);

            $tipos = $obj->select("SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC");

            include_once '../view/tanques/list.php';
        }
                
        public function getCreate(){
            $obj = new TanquesModel();

            // Traer tipos de tanque
            $sql = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC";
            $tipos = $obj->select($sql);

            include_once '../view/tanques/create.php';
        }
        
        public function postCreate(){
            $obj = new TanquesModel();
            
            $id = $obj->autoincrement("Tanques", "id");
            $nombre = $_POST['nombre'];
            $medidas = $_POST['medidas'];
            $id_tipo_tanque = $_POST['id_tipo_tanque'];
            $cantidad = $_POST['cantidad'];
            
            $sql = "INSERT INTO tanques (id, nombre, medidas, id_tipo_tanque, cantidad_peces,id_estado)
            VALUES ($id, '$nombre', '$medidas', $id_tipo_tanque, $cantidad,1)";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{
                redirect(getUrl("Tanques","Tanque","list"));
            }
        }
//        falta la tabla de estado
         public function getDelete(){
            $obj = new TanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","list"));
                return;
            }
            include_once '../view/tanques/delete.php';
        }

        public function postDelete(){
            $obj = new TanquesModel();
            $id = intval($_POST['id']);

            $sql = "UPDATE tanques SET id_estado = 2 WHERE id = $id";

            if($obj->update($sql)){
                redirect(getUrl("Tanques","Tanque","list"));
            } else {
                echo "No se pudo actualizar el estado del tanque";
            }
        }
        //para el activar
        public function updateStatus(){
            $obj = new TanquesModel();
            $id = intval($_GET['id']);

            if($id > 0){
                $obj->update("UPDATE tanques SET id_estado = 1 WHERE id = $id");
            }

            redirect(getUrl("Tanques","Tanque","list"));
        }

        public function getUpdate(){
            $obj = new TanquesModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Tanques","Tanque","list"));
                return;
            }

            $sql = "SELECT * FROM tanques WHERE id = $id";
            $tanque = pg_fetch_assoc($obj->select($sql));

            if(!$tanque){
                redirect(getUrl("Tanques","Tanque","list"));
                return;
            }

            $sqlTipos = "SELECT id, nombre FROM tipo_tanque ORDER BY nombre ASC";
            $tipos = $obj->select($sqlTipos);

            include_once '../view/tanques/update.php';
        }

        public function postUpdate(){
            $obj = new TanquesModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $medidas = $_POST['medidas'];
            $id_tipo_tanque = $_POST['id_tipo_tanque'];
            $cantidad = $_POST['cantidad'];

            $sql = "UPDATE tanques SET nombre = '$nombre',medidas = '$medidas',id_tipo_tanque = $id_tipo_tanque,cantidad_peces = $cantidad WHERE id = $id";

            $resultado = $obj->update($sql);

            if(!$resultado){
                echo "Error al actualizar el tanque";
            } else {
                redirect(getUrl("Tanques","Tanque","list"));
            }
        }
    }
?>
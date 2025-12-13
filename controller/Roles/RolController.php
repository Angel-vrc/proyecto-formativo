<link rel="stylesheet" href="assets/css/arregloTablas.css">

<?php

    include_once '../model/Roles/RolModel.php';

    class RolController{

        public function lista(){
            $obj = new RolModel();

            $sql = "SELECT r.*, e.nombre estado_nombre FROM roles r, rol_estado e WHERE r.id_estado = e.id_estado ORDER BY r.id ASC";

            $roles = $obj->select($sql);

            include_once '../view/roles/list.php';
        }

        public function getCreate(){
            $obj = new RolModel();

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/roles/create.php';
        }

        public function postCreate(){
            $obj = new RolModel();

            $id = $obj->autoincrement('roles', 'id');
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];
            $password = str_replace(' ', '', $nombre.$documento);
            $hash = md5($password);

            $sql = "INSERT INTO roles VALUES ($id, '$nombre','$apellido','$documento','$correo','$telefono','$hash', $rol,1)";

            $resultado = $obj->insert($sql);

            if($resultado){
                $_SESSION['success'] = "Rol creado correctamente";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al crear el rol";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }
        }

        public function getUpdate(){
            $obj = new RolModel();

            $id = $_GET['id'];
            $sql = "SELECT * FROM roles WHERE id=$id";
            $rol = pg_fetch_assoc($obj->select($sql));

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/roles/update.php';

        }

        public function postUpdate(){
            $obj = new RolModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];

            $sql = "UPDATE roles SET nombre='$nombre', apellido='$apellido', documento='$documento', correo='$correo',telefono='$telefono', id_rol=$rol WHERE id=$id";


            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Rol actualizado correctamente";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el rol";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }
        }

       public function getDelete(){
            $obj = new RolModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Roles","Rol","lista"));
                return;
            }

            $sql = "SELECT r.*, e.nombre estado_nombre FROM roles r, rol_estado e WHERE r.id = $id AND r.id_estado = e.id_estado ORDER BY r.id ASC";

            $rol = pg_fetch_assoc($obj->select($sql));

            if(!$rol){
                echo "El rol solicitado no existe";
            }

            include_once '../view/roles/delete.php';
        }

        public function postDelete(){
            $obj = new RolModel();

            $id = ($_POST['id']);

            $sql = "UPDATE roles SET id_estado = 2 WHERE id = $id";

            $resultado = $obj->update($sql);
            
            if($resultado){
                $_SESSION['success'] = "Rol deshabilitado correctamente";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al deshabilitar el rol";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }

        }

        public function updateStatus(){
            $obj = new RolModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Roles","Rol","lista"));
                return;
            }

            $sql = "UPDATE roles SET id_estado=1 WHERE id=$id";

            $resultado = $obj->update($sql);

            if($resultado){
                $_SESSION['success'] = "Rol habilitado correctamente";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }else{
                $_SESSION['error'] = "Error al habilitar el rol";
                redirect(getUrl("Roles","Rol","lista"));
                exit();
            }
        }

    }

?>
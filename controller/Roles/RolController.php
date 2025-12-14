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

            $sql = "SELECT * FROM modulos WHERE id_modulo_padre IS NULL ORDER BY id ASC";
            $modulos = $obj->select($sql);

            $sql = "SELECT * FROM acciones ORDER BY id ASC";
            $acciones = $obj->select($sql);

            include_once '../view/roles/create.php';
        }

        public function postCreate(){
            $obj = new RolModel();

            $rol_id = $obj->autoincrement('roles', 'id');
            $nombre = $_POST['nombre'];
           

            $sql = "INSERT INTO roles VALUES($rol_id, '$nombre', 1)";
            
            $resultado = $obj->insert($sql);

            $permisos = $_POST['permisos'];

            $permisosFormateados = array();

            foreach ($permisos as $mod_id => $acciones) {
                foreach ($acciones as $acc_id => $val) {
                    $permisosFormateados[$mod_id][] = $acc_id;
                    $per_id = $obj->autoincrement('permisos','id');
                    
                    $sql = "INSERT INTO permisos VALUES ($per_id, $rol_id, $mod_id, $acc_id)";
                    $obj->insert($sql);
                }
            }

            $_SESSION['success'] = "Rol creado correctamente";
            redirect(getUrl("Roles","Rol","lista"));
            exit();
        }

        public function getUpdate(){
            $obj = new RolModel();

            $rol_id = $_GET['id'];

            $sql = "SELECT * FROM roles WHERE id=$rol_id";
            $rol = pg_fetch_assoc($obj->select($sql));

            $sql = "SELECT * FROM modulos WHERE id_modulo_padre IS NULL ORDER BY id ASC";
            $modulos = $obj->select($sql);

            $sql = "SELECT * FROM acciones ORDER BY id ASC";
            $acciones = $obj->select($sql);

            $sql = "SELECT * FROM permisos WHERE id_roles=$rol_id";
            $permisos = $obj->select($sql);

            $permisos_rol = array();
            while($perm = pg_fetch_assoc($permisos)){
                $permisos_rol[$perm['id_modulos']][] = $perm['id_acciones'];
            }

            include_once '../view/roles/update.php';

        }

        public function postUpdate(){
            $obj = new RolModel();

            $rol_id = $_POST['id_rol'];
            $nombre = $_POST['nombre'];
           

            $sql = "UPDATE roles SET nombre = '$nombre' WHERE id=$rol_id";
            $obj->update($sql);

            $sql = "DELETE FROM permisos WHERE id_roles=$rol_id";
            $obj->delete($sql);

            $permisos = $_POST['permisos'];

            $permisosFormateados = array();

            foreach ($permisos as $mod_id => $acciones) {
                foreach ($acciones as $acc_id => $val) {
                    $permisosFormateados[$mod_id][] = $acc_id;
                    $per_id = $obj->autoincrement('permisos','id');
                    
                    $sql = "INSERT INTO permisos VALUES ($per_id, $rol_id, $mod_id, $acc_id)";
                    $obj->insert($sql);
                }
            }

            $_SESSION['success'] = "Rol actualizado correctamente";
            redirect(getUrl("Roles","Rol","lista"));
            exit();
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

        public function getPermisosRol(){

            $obj = new RolModel();

            $idRol = $_GET['id_rol'];

            echo $idRol;


            $sql = "SELECT p.*, m.nombre modulo, a.nombre accion FROM permisos p, modulos m, acciones a WHERE p.id_roles = $idRol AND p.id_modulos = m.id AND p.id_acciones = a.id ORDER BY modulo ASC";

            $permisos = pg_fetch_assoc($obj->select($sql));

            // HTML
            foreach ($permisos as $modulo => $acciones) {
                echo "<h6 class='mt-3'>$modulo</h6>";
                echo "<ul>";
                foreach ($acciones as $accion) {
                    echo "<li>$accion</li>";
                }
                echo "</ul>";
            }

            exit;
        }

    }

?>
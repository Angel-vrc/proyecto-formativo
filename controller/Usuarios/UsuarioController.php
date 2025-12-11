<?php

    include_once '../model/Usuarios/UsuarioModel.php';

    class UsuarioController{

        public function lista(){
            $obj = new UsuarioModel();

            $sql = "SELECT u.*, r.nombre rol_nombre, e.nombre estado_nombre FROM usuarios u, roles r, usuario_estado e WHERE u.id_rol = r.id AND u.id_estado = e.id_estado ORDER BY id ASC";

            $usuarios = $obj->select($sql);

            include_once '../view/usuarios/list.php';
        }

        public function getCreate(){
            $obj = new UsuarioModel();

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/usuarios/create.php';
        }

        public function postCreate(){
            $obj = new UsuarioModel();

            $id = $obj->autoincrement('usuarios', 'id');
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];
            $password = str_replace(' ', '', $nombre.$documento);

            $sql = "INSERT INTO usuarios VALUES ($id, '$nombre','$apellido','$documento','$correo','$telefono','$password', $rol,1)";

            $resultado = $obj->insert($sql);

            if(!$resultado){
                echo "Error en la insercion de datos";
            }else{                
                redirect(getUrl("Usuarios","Usuario","lista"));
            }
        }

        public function getUpdate(){
            $obj = new UsuarioModel();

            $id = $_GET['id'];
            $sql = "SELECT * FROM usuarios WHERE id=$id";
            $usuario = pg_fetch_assoc($obj->select($sql));

            $sql = "SELECT * FROM roles ORDER BY nombre ASC";
            $roles = $obj->select($sql);

            include_once '../view/usuarios/update.php';

        }

        public function postUpdate(){
            $obj = new UsuarioModel();

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $documento = $_POST['documento'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $rol = $_POST['rol'];

            $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', documento='$documento', correo='$correo',telefono='$telefono', id_rol=$rol WHERE id=$id";

            $resultado = $obj->update($sql);

            if(!$resultado){
                echo "Error en la actualizacion de datos";
            }else{                
                redirect(getUrl("Usuarios","Usuario","lista"));
            }
        }

       public function getDelete(){
            $obj = new UsuarioModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Usuarios","Usuario","lista"));
                return;
            }


            $sql = "SELECT u.id, u.nombre, u.apellido, u.telefono, u.id_estado, u.id_rol, e.nombre estado_nombre, r.nombre rol_nombre FROM usuarios u, usuario_estado e, roles r WHERE u.id=$id AND u.id_rol=r.id AND u.id_estado=e.id_estado";

            $usuario = pg_fetch_assoc($obj->select($sql));

            if(!$usuario){
                echo "El usuario solicitado no existe";
            }

            include_once '../view/usuarios/delete.php';
        }

        public function postDelete(){
            $obj = new UsuarioModel();

            $id = ($_POST['id']);

            $sql = "UPDATE usuarios SET id_estado = 2 WHERE id = $id";

            $ejecutar = $obj->update($sql);
            
            if($ejecutar){
                redirect(getUrl("Usuarios","Usuario","lista"));
            }else{
                echo "No se pudo deshabilitar el usuario";
            }

        }

        public function updateStatus(){
            $obj = new UsuarioModel();
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if($id <= 0){
                redirect(getUrl("Usuarios","Usuario","lista"));
                return;
            }

            $sql = "UPDATE usuarios SET id_estado=1 WHERE id=$id";

            $ejecutar = $obj->update($sql);

            if($ejecutar){
                redirect(getUrl("Usuarios","Usuario","lista"));
            }else{
                echo "El usuario solicitado no existe.";
                return;
            }
        }

    }

?>
<?php

    include_once('../model/Usuarios/UsuarioModel.php');

    class PerfilController{

        public function view(){
            $obj = new UsuarioModel();

            // Obtener el ID del usuario de la sesión
            $id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

            $sql = "SELECT u.*, r.nombre rol_nombre, e.nombre estado_nombre FROM usuarios u, roles r, usuario_estado e WHERE u.id=$id AND u.id_rol = r.id AND u.id_estado = e.id_estado";
            $usuario = $obj->select($sql);

            if(!$usuario){
                $_SESSION['error'] = "Usuario no encontrado";
            }

            $usuario = pg_fetch_assoc($usuario);

            include_once '../view/perfil/view.php';
        }

        public function postUpdate(){
            $obj = new UsuarioModel();

            $id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

            if($id <= 0){
                redirect('index.php');
                exit();
            }

            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $password = str_replace(' ', '', $password);
            $hash = md5($password);

            $sql = "UPDATE usuarios SET correo='$correo',telefono='$telefono', contrasena='$hash' WHERE id=$id";

            $resultado = $obj->update($sql);

             if($resultado){
                $_SESSION['success'] = "Usuario actualizado correctamente";
                redirect(getUrl("Perfil","Perfil","view"));
                exit();
            }else{
                $_SESSION['error'] = "Error al actualizar el usuario";
                redirect(getUrl("Perfil","Perfil","view"));
                exit();
            }
        }

    }

?>


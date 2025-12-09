<?php

    include_once(__DIR__ . "/../../model/MasterModel.php");

    class PerfilController extends MasterModel{

        public function view(){
            
            // Obtener el ID del usuario de la sesión
            $usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

            // Obtener los datos del usuario
            $condition = "id = $usuario_id";
            $result = $this->findOne("usuarios", "id, documento, nombre, apellido, correo, telefono", $condition);

            if($result == "No se encontro ningun registro"){
                $_SESSION['error'] = "Usuario no encontrado";
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            }

            $usuario = pg_fetch_assoc($result);

            include_once '../view/perfil/view.php';
        }

        public function postUpdate(){
            // Verificar que el usuario esté autenticado
            if(!isset($_SESSION['auth']) || $_SESSION['auth'] != "ok"){
                echo "<script>window.location.href = 'login.php';</script>";
                exit();
            }

            $usuario_id = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;

            if($usuario_id <= 0){
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['correo']) && isset($_POST['telefono'])){
                $correo = pg_escape_string($this->getConnect(), $_POST['correo']);
                $telefono = pg_escape_string($this->getConnect(), $_POST['telefono']);

                $sql = "UPDATE usuarios SET correo = '$correo', telefono = '$telefono' WHERE id = $usuario_id";
                $result = $this->update($sql);

                if($result){
                    $_SESSION['success'] = "Perfil actualizado correctamente";
                    echo "<script>window.location.href = '" . getUrl('Perfil', 'Perfil', 'view') . "';</script>";
                    exit();
                } else {
                    $_SESSION['error'] = "Error al actualizar el perfil";
                    echo "<script>window.location.href = '" . getUrl('Perfil', 'Perfil', 'view') . "';</script>";
                    exit();
                }
            } else {
                echo "<script>window.location.href = '" . getUrl('Perfil', 'Perfil', 'view') . "';</script>";
                exit();
            }
        }

    }

?>


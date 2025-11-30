<?php

    include_once(__DIR__ . "/../../model/MasterModel.php");

    class LoginController extends MasterModel{

        public function autenticar(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if(isset($_SESSION['auth']) && $_SESSION['auth'] == "ok"){
                header("Location: index.php");
                exit();
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario']) && isset($_POST['password'])){
                $usuario = trim($_POST['usuario']);
                $password = $_POST['password'];
                
                if(!empty($usuario) && !empty($password)){
                    $usuario = pg_escape_string($this->getConnect(), $usuario);
                    $password = pg_escape_string($this->getConnect(), $password);
                    
                    $condition = "usuario = '$usuario' AND contrasena = '$password'";
                    $result = $this->findOne("usuarios", "id, usuario, contrasena", $condition);
                    
                    if($result != "No se encontro ningun registro"){

                        $userData = pg_fetch_assoc($result);
                        
                        $_SESSION['auth'] = "ok";
                        $_SESSION['usuario'] = $userData['usuario'];
                        $_SESSION['usuario_id'] = $userData['id'];
                        
                        header("Location: index.php");
                        exit();
                    } else {
                        $_SESSION['error_login'] = "Usuario o contraseña incorrectos";
                        header("Location: login.php");
                        exit();
                    }
                } else {
                    $_SESSION['error_login'] = "Por favor complete todos los campos";
                    header("Location: login.php");
                    exit();
                }
            } else {
                header("Location: login.php");
                exit();
            }
        }

        public function cerrarSesion(){
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit();
        }

    }

?>


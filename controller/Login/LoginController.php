<?php

    include_once("../model/MasterModel.php");
    require_once("../lib/conf/recaptcha_config.php");

    class LoginController extends MasterModel{

        public function autenticar(){

            if(isset($_SESSION['auth']) && $_SESSION['auth'] == "ok"){
                redirect('index.php');
                exit();
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario']) && isset($_POST['password'])){
                $usuario = trim($_POST['usuario']);
                $password = $_POST['password'];
                
                // Validar reCAPTCHA
                $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
                
                if(empty($recaptcha_response)){
                    $_SESSION['error_login'] = "Por favor complete la verificación de seguridad";
                    redirect('login.php');
                    exit();
                }
                
                // Verificar reCAPTCHA con Google
                //$recaptcha_verified = $this->verificarRecaptcha($recaptcha_response);
                
                // if(!$recaptcha_verified){
                //     $_SESSION['error_login'] = "La verificación de seguridad falló. Por favor, inténtelo de nuevo.";
                //     redirect('login.php');
                //     exit();
                // }
                
                if(!empty($usuario) && !empty($password)){
                    $documento = pg_escape_string($this->getConnect(), $usuario);
                    $password = pg_escape_string($this->getConnect(), $password);
                    
                    $condition = "documento = '$documento' AND contrasena = '$password'";
                    $result = $this->findOne("usuarios", "id, documento, contrasena, nombre, apellido, correo, telefono", $condition);
                    
                    if($result != "No se encontro ningun registro"){
                        $userData = pg_fetch_assoc($result);
                        
                        $_SESSION['auth'] = "ok";
                        $_SESSION['usuario'] = $userData['documento'];
                        $_SESSION['usuario_id'] = $userData['id'];
                        $_SESSION['nombre'] = isset($userData['nombre']) ? trim($userData['nombre'] . ' ' . (isset($userData['apellido']) ? $userData['apellido'] : '')) : $userData['documento'];
                        
                        redirect('index.php');
                        exit();
                    } else {
                        $_SESSION['error_login'] = "Número de documento o contraseña incorrectos";
                        redirect('login.php');
                        exit();
                    }
                } else {
                    $_SESSION['error_login'] = "Por favor complete todos los campos";
                    redirect('login.php');
                    exit();
                }
            } else {
                redirect('login.php');
                exit();
            }
        }

        public function cerrarSesion(){
            session_unset();
            session_destroy();
            redirect('login.php');
            exit();
        }

        /**
         * Verificar el recapchat con la API de Google
         * @param string $recaptcha_response La respuesta del reCAPTCHA
         * @return bool 
         */
        private function verificarRecaptcha($recaptcha_response){
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => RECAPTCHA_SECRET_KEY,
                'response' => $recaptcha_response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            
            if($result === false){
                return false;
            }

            $result_json = json_decode($result);
            
            return isset($result_json->success) && $result_json->success === true;
        }

    }

?>


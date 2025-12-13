<?php

    include_once("../model/Usuarios/UsuarioModel.php");
    require_once("../lib/conf/recaptcha_config.php");

    class LoginController{

        public function autenticar() {
                session_start();
                $obj = new UsuarioModel();

                if (isset($_SESSION['auth']) && $_SESSION['auth'] === "ok") {
                    redirect('index.php');
                    exit();
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    if (empty($_POST['usuario']) || empty($_POST['password'])) {
                        $_SESSION['error_login'] = "Por favor complete todos los campos";
                        redirect('login.php');
                        exit();
                    }

                    $usuario  = trim($_POST['usuario']);
                    $password = trim($_POST['password']);

                    // Escapar para PostgreSQL
                    $usuario = pg_escape_string($usuario);

                    // Hash (temporalmente MD5)
                    $passHashIngresada = md5($password);

                    //dd($passHashIngresada);

                    $sql = "SELECT u.id, u.documento, u.nombre, u.apellido, u.id_rol, r.nombre AS nombre_rol
                        FROM usuarios u
                        INNER JOIN roles r ON u.id_rol = r.id
                        WHERE u.documento = '$usuario'
                        AND u.contrasena = '$passHashIngresada'
                        LIMIT 1
                    ";

                    $result = $obj->select($sql);

                    if ($result && pg_num_rows($result) === 1) {

                        $userData = pg_fetch_assoc($result);

                        $_SESSION['auth'] = "ok";
                        $_SESSION['usuario'] = $userData['documento'];
                        $_SESSION['usuario_id'] = $userData['id'];
                        $_SESSION['id_rol'] = $userData['id_rol'];
                        $_SESSION['usuario_rol_nombre'] = $userData['nombre_rol'];
                        $_SESSION['nombre'] = trim($userData['nombre'] . ' ' . $userData['apellido']);

                        redirect('index.php');
                        exit();

                    } else {
                        $_SESSION['error_login'] = "Número de documento o contraseña incorrectos";
                        redirect('login.php');
                        exit();
                    }
                }

                redirect('login.php');
                exit();
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


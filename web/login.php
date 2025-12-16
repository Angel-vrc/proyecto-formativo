<?php
include_once '../lib/helpers.php';
session_start();

if(isset($_SESSION['auth']) && $_SESSION['auth'] == "ok"){
    redirect('index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario']) && isset($_POST['password'])){
    include_once '../controller/Login/LoginController.php';
    $loginController = new LoginController();
    $loginController->autenticar();
            exit();
}

$error = "";
if(isset($_SESSION['error_login'])){
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}

// Cargar configuración de reCAPTCHA
require_once '../lib/conf/recaptcha_config.php';
?>
<?php 
$cargar_recaptcha = true; // Variable para indicar que se debe cargar reCAPTCHA
include_once '../view/partials/header.php'; 
?>
<link rel="stylesheet" href="assets/css/login.css">
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="GeoControl Logo">
            <h1>GeoControl</h1>
            <p>Sistema de Información Geográfico</p>
        </div>
        
        <div id="alertContainer"></div>
        
        <?php if($error): ?>
            <div class="alert alert-danger custom-alert" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php" id="loginForm">
            <div class="form-group">
                <label for="usuario">
                    <i class="fas fa-id-card"></i> Número de Documento
                </label>
                <input  type="text"  class="form-control"  id="usuario"  name="usuario"  placeholder="Ingrese su número de documento" required  autocomplete="username" autofocus pattern="[0-9]*" inputmode="numeric">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Contraseña
                </label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Ingrese su contraseña"
                        required
                        autocomplete="current-password"
                    >
                    <button 
                        type="button" 
                        class="password-toggle" 
                        onclick="togglePassword()"
                        aria-label="Mostrar/Ocultar contraseña"
                        tabindex="0"
                    >
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                <p class="robot-message">Seleccione si usted no es un robot</p>
            </div>
            
            <button type="submit" class="btn btn-login" id="submitBtn">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
    </div>
    
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['assets/css/fonts.min.css']
            }
        });
    </script>
    
    <!-- Validaciones del login -->
    <script src="js/validaciones_login.js"></script>
</body>
</html>
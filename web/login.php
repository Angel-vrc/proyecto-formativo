<?php
session_start();

if(isset($_SESSION['auth']) && $_SESSION['auth'] == "ok"){
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario']) && isset($_POST['password'])){
    include_once __DIR__ . '/../controller/Login/LoginController.php';
    $loginController = new LoginController();
    $loginController->autenticar();
    exit();
}

$error = "";
if(isset($_SESSION['error_login'])){
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}
?>
<?php include_once '../view/partials/header.php'; ?>
<link rel="stylesheet" href="assets/css/login.css">
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="assets/img/logo.png" alt="GeoControl Logo">
            <h1>GeoControl</h1>
            <p>Sistema de Información Geográfico</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php" id="loginForm">
            <div class="form-group">
                <label for="usuario">
                    <i class="fas fa-user"></i> Usuario
                </label>
                <input  type="text"  class="form-control"  id="usuario"  name="usuario"  placeholder="Ingrese su usuario" required  autocomplete="username" autofocus>
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
            
            <button type="submit" class="btn btn-login" id="submitBtn">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
        
        <div class="institution-info">
            <p><strong>Secretaría de Salud de Cali</strong></p>
            <p>Sistema de información geografico</p>
        </div>
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
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        document.querySelector('.password-toggle').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePassword();
            }
        });
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const usuario = document.getElementById('usuario').value.trim();
            const password = document.getElementById('password').value;
            const submitBtn = document.getElementById('submitBtn');
            
            if (!usuario || !password) {
                e.preventDefault();
                alert('Por favor complete todos los campos');
                return false;
            }
            
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '';
        });
        
        document.getElementById('usuario').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('password').focus();
            }
        });
        
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });
    </script>
</body>
</html>


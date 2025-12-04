// Función para mostrar/ocultar contraseña
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


document.addEventListener('DOMContentLoaded', function() {
    const usuarioInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('password');
    const loginForm = document.getElementById('loginForm');
    const passwordToggle = document.querySelector('.password-toggle');
    const submitBtn = document.getElementById('submitBtn');

    // Validar que solo se ingresen números en el campo de documento
    if (usuarioInput) {
        usuarioInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const usuario = usuarioInput ? usuarioInput.value.trim() : '';
            const password = passwordInput ? passwordInput.value : '';
            
            if (!usuario || !password) {
                e.preventDefault();
                alert('Por favor complete todos los campos');
                return false;
            }
            
            // Validar que el número de documento sea  un numero 
            if (!/^\d+$/.test(usuario)) {
                e.preventDefault();
                alert('El número de documento solo debe contener números');
                return false;
            }
            
            // Mostrar estado de carga
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '';
            }
        });
    }
});


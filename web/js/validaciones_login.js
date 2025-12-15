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


// Función para verificar si el reCAPTCHA está completado
function verificarRecaptcha() {
    const recaptchaResponse = grecaptcha.getResponse();
    return recaptchaResponse && recaptchaResponse.length > 0;
}

// Función para mostrar alertas personalizadas
function mostrarAlerta(mensaje, tipo = 'danger') {
    const alertContainer = document.getElementById('alertContainer');
    
    // Remover alertas anteriores
    alertContainer.innerHTML = '';
    
    // Crear la alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} custom-alert`;
    alertDiv.setAttribute('role', 'alert');
    
    // Icono según el tipo
    let icono = 'fa-exclamation-circle';
    if (tipo === 'success') {
        icono = 'fa-check-circle';
    } else if (tipo === 'warning') {
        icono = 'fa-exclamation-triangle';
    } else if (tipo === 'info') {
        icono = 'fa-info-circle';
    }
    
    alertDiv.innerHTML = `
        <i class="fas ${icono}"></i>
        <span>${mensaje}</span>
    `;
    
    // Agregar animación de entrada
    alertDiv.style.opacity = '0';
    alertDiv.style.transform = 'translateY(-10px)';
    
    alertContainer.appendChild(alertDiv);
    
    // Animar entrada
    setTimeout(() => {
        alertDiv.style.transition = 'all 0.3s ease';
        alertDiv.style.opacity = '1';
        alertDiv.style.transform = 'translateY(0)';
    }, 10);
    
    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        alertDiv.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 300);
    }, 5000);
    
    // Scroll suave hacia la alerta
    alertDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}


document.addEventListener('DOMContentLoaded', function() {
    const usuarioInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('password');
    const loginForm = document.getElementById('loginForm');
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
            
            // Validar campos requeridos
            if (!usuario || !password) {
                e.preventDefault();
                mostrarAlerta('Por favor complete todos los campos', 'warning');
                return false;
            }
            
            // Validar que el número de documento sea un numero 
            if (!/^\d+$/.test(usuario)) {
                e.preventDefault();
                mostrarAlerta('El número de documento solo debe contener números', 'warning');
                return false;
            }
            
            // Validar reCAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                if (!verificarRecaptcha()) {
                    e.preventDefault();
                    mostrarAlerta('Por favor complete la verificación de seguridad', 'warning');
                    return false;
                }
            }
            
            // Mostrar estado de carga
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '';
            }
        });
    }
});




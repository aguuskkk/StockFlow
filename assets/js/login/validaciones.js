// Validaciones del login

document.addEventListener('DOMContentLoaded', function () {
    const emailInput        = document.getElementById('email');
    const passwordInput     = document.getElementById('password');
    const emailError        = document.getElementById('emailError');
    const passwordError     = document.getElementById('passwordError');
    const togglePasswordBtn = document.querySelector('.toggle-password');

    const MIN_PASSWORD = 12; // Caracteres mínimos de la contraseña

    // ===== Eventos =====
    function showError(input, error, message) {
        error.textContent = message;
        error.style.display = 'block';
        input.style.borderColor = 'red';
    }

    function clearError(input, error) {
        error.textContent = '';
        error.style.display = 'none';
        input.style.borderColor = '';
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // ===== Validaciones =====
    function validateField(input, error) {
        const value = input.value.trim();

        if (input.id === 'email') {
            if (value === '') {
                showError(input, error, 'El correo es obligatorio.');
                return false;
            }
            if (!validateEmail(value)) {
                showError(input, error, 'Correo inválido.');
                return false;
            }
            clearError(input, error);
            return true;
        }

        if (input.id === 'password') {
            if (value === '') {
                showError(input, error, 'La contraseña es obligatoria.');
                return false;
            }
            if (value.length < MIN_PASSWORD) {
                showError(input, error, `Mínimo ${MIN_PASSWORD} caracteres.`);
                return false;
            }
            clearError(input, error);
            return true;
        }
    }

    // ===== Eventos: email =====
    emailInput.addEventListener('blur', function () {
        validateField(emailInput, emailError);
    });

    emailInput.addEventListener('input', function () {
        if (emailError.style.display === 'block') {
            validateField(emailInput, emailError);
        }
    });

    emailInput.addEventListener('focus', function () {
        if (emailError.style.display === 'block') {
            clearError(emailInput, emailError);
        }
    });

    // ===== Eventos: contraseña =====
    passwordInput.addEventListener('blur', function () {
        validateField(passwordInput, passwordError);
    });

    passwordInput.addEventListener('input', function () {
        if (passwordError.style.display === 'block') {
            validateField(passwordInput, passwordError);
        }
    });

    passwordInput.addEventListener('focus', function () {
        if (passwordError.style.display === 'block') {
            clearError(passwordInput, passwordError);
        }
    });

    // ===== Mostrar / ocultar contraseña =====
    togglePasswordBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
});
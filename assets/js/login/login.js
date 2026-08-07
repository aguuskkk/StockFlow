// Validaciones entre cosas

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('LoginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const togglePasswordBtn = document.querySelector('.toggle-password');

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

    function validateField(input, error) {
        const value = input.value.trim();

        if (input.id === 'email') {
            if (value === '') {
                showError(input, error, 'El correo es obligatorio.');
                return false;
            }
            if (value.length >= 256) {
                showError(input, error, 'Demasiado largo.');
                return false;
            }
            if (!validateEmail(value)) {
                showError(input, error, 'Correo inválido.');
                return false;
            }
            clearError(input, error);
            return true;
        }

        // Validacr contraseña
        if (input.id === 'password') {
            // Validar que no esté vacío
            if (value === '') {
                showError(input, error, 'La contraseña es obligatoria.');
                return false;
            }
            // Validar que tenga al menos 12 caracteres
            if (value.length < 12) {
                showError(input, error, 'Mínimo 12 caracteres.');
                return false;
            } 
            // Validar que tenga menos de 256 caracteres
            else if (value.length >= 256) {
                showError(input, error, 'Demasiado largo.');
                return false;
            }
            clearError(input, error);
            return true;
        }
    }

    emailInput.addEventListener('blur', function () {
        validateField(emailInput, emailError);
    });

    emailInput.addEventListener('input', function () {
        if (emailError.style.display === 'block') {
            validateField(emailInput, emailError);
        }
    });

    passwordInput.addEventListener('blur', function () {
        validateField(passwordInput, passwordError);
    });

    passwordInput.addEventListener('input', function () {
        if (passwordError.style.display === 'block') {
            validateField(passwordInput, passwordError);
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const emailValid = validateField(emailInput, emailError);
        const passwordValid = validateField(passwordInput, passwordError);

        if (emailValid && passwordValid) {
            alert('Inicio de sesión exitoso');
        } else {
            if (!emailValid) {
                emailInput.focus();
            } else {
                passwordInput.focus();
            }
        }
    });

    togglePasswordBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    emailInput.addEventListener('focus', function () {
        if (emailError.style.display === 'block') {
            clearError(emailInput, emailError);
        }
    });

    passwordInput.addEventListener('focus', function () {
        if (passwordError.style.display === 'block') {
            clearError(passwordInput, passwordError);
        }
    });
});
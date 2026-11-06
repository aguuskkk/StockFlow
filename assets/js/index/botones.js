const btnLogin = document.getElementById('btn-login')

btnLogin.className = 'btn-login'

// Ir a la pagina del login
btnLogin.addEventListener('click', () => {
    window.location.href = 'views/login.php'
});
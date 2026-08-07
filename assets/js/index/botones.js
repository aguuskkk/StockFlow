const btnLogin = document.getElementById('btn-login')
const btnMore = document.getElementById('btn-more')

btnLogin.className = 'btn-login'
btnMore.className = 'btn-more'

// Ir a la pagina del login
btnLogin.addEventListener('click', () => {
    window.location.href = 'views/login.html'
});
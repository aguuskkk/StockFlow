const btnLogin = document.getElementById('btn-login');
const btnMore = document.getElementById('btn-more');
// Agrego clases a los botones
btnLogin.className = 'btn-uno';
btnMore.className = 'btn-dos';

// Al hacer click ir a login.html
btnLogin.addEventListener('click', () => {
    window.location.href = 'login.html';
});
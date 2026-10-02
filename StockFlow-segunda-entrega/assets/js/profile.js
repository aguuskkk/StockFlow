const profileBtn = document.getElementById('profileBtn');
const profilDropdown = document.getElementById('profileDropdown');

// Abrir/cerrar dropdown 
profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('active');
    profileBtn.classList.toggle('active');
});

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('active');
        profileBtn.classList.remove('active');
    }
});

// Cerrar dropdown al hacer scroll
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        profileDropdown.classList.remove('active');
        profileBtn.classList.remove('active');
    }
});

// Cerrar dropdown al hacer click en boton de menu
document.getElementById('menu-btn').addEventListener('click', () => {
    profileDropdown.classList.remove('active');
    profileBtn.classList.remove('active');
});

// Cerrar dropdown al hacer click en boton de notificaciones
document.getElementById('notifBtn').addEventListener('click', () => {
    profileDropdown.classList.remove('active');
    profileBtn.classList.remove('active');
});
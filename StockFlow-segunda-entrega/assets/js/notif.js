// Notificaciones
const notifBtn = document.getElementById("notifBtn");
const notifPanel = document.getElementById("notifPanel");

// Boton de notificaciones
notifBtn.addEventListener("click", () => {
    notifPanel.classList.toggle("active");
});

// Ocultar notificaciones al hacer scroll
window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        notifPanel.classList.remove("active");
    }
});

// Ocultar notificaciones al hacer click fuera
notifPanel.addEventListener("click", (e) => {
    if (e.target.id !== "notifPanel") {
        notifPanel.classList.remove("active");
    }
});

// Ocultar notificaciones si se presiona perfil
document.getElementById("profileBtn").addEventListener("click", () => {
    notifPanel.classList.remove("active");
});

// Si se presiona el menu, ocultar notificaciones
document.getElementById("menu-btn").addEventListener("click", () => {
    notifPanel.classList.remove("active");
});

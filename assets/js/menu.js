// Menu
const menuBtn = document.getElementById("menu-btn");
const menu = document.getElementById("menu");
const menuBtnClose = document.getElementById("menu-btn-close");

// Boton de menu
menuBtn.addEventListener("click", () => {
    menu.classList.toggle("active");
});

// Boton de cerrar menu
menuBtnClose.addEventListener("click", () => {
    menu.classList.remove("active");
});

// Al hacer scroll, ocultar el menu (En mobile)
window.addEventListener("scroll", () => {
    if (window.scrollY > 100 && window.innerWidth < 768) {
        menu.classList.remove("active");
    }
});

// Al presionar notificaciones, ocultar el menu (En mobile)
document.getElementById("notifBtn").addEventListener("click", () => {
    if (window.innerWidth < 768) {
        menu.classList.remove("active");
    }
});
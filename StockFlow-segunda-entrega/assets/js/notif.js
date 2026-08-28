// Notificaciones
const notifBtn = document.getElementById("notifBtn");
const notifPanel = document.getElementById("notifPanel");

notifBtn.addEventListener("click", () => {
    notifPanel.classList.toggle("active");
});

const cartBtn = document.getElementById("cart-btn");
const cartPanel = document.getElementById("cart-panel");
const cartClose = document.getElementById("cart-close");
const cartOverlay = document.getElementById("cart-overlay");

// Abrir
function openCart() {
    cartPanel.classList.add("active");
    cartOverlay.classList.add("active");
}

// Cerrar
function closeCart() {
    cartPanel.classList.remove("active");
    cartOverlay.classList.remove("active");
}

cartBtn.addEventListener("click", openCart);
cartClose.addEventListener("click", closeCart);
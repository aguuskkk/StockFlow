// Panel de nuevo producto
const panelNew = document.getElementById("panel-new");
const btnOpen = document.getElementById("add-btn");
const btnSave = document.getElementById("product-btn-add");
const btnQuit = document.getElementById("btn-quit");
// Inputs
const nameInput = document.getElementById("name");
const descriptionInput = document.getElementById("description");
const panelPrice = document.getElementById("panel-price");
const panelStock = document.getElementById("panel-stock");
const panelTags = document.getElementById("panel-tags");
// Botones
const minusBtn = document.getElementById("minus-btn");
const plusBtn = document.getElementById("plus-btn");


// Resetear campos formulario
function resetForm() {
    nameInput.value = "";
    descriptionInput.value = "";
    panelPrice.value = "";
    panelStock.value = "";
    panelTags.value = "";
}

// Cerar panel de nuevo producto
function closePanel() {
    panelNew.classList.remove("active");
    btnOpen.classList.remove("active");
    resetFormFields();
}

// Abrir panel de nuevo producto
function openPanel() {
    panelNew.classList.add("active");
    btnOpen.classList.add("active");
}

// Validar campos negativos
function validateNonNegative(input) {
    if (parseFloat(input.value) < 0) {
        input.value = 0;
    }
}

// Abrir panel
btnOpen.addEventListener("click", () => {
    openPanel();
});

// Cerrar con botón de salir
btnQuit.addEventListener("click", function() {
    if (confirm("¿Está seguro de cerrar la ventana? Los datos no guardados se perderán.")) {
        closePanel();
    }
});

// Guardar botón
btnSave.addEventListener("click", () => {

    // Validacion basica

    if (!nameInput.value.trim()) {
        alert("Por favor, ingresa un nombre para el producto.");
        nameInput.focus();
        return;
    }

    if (!panelPrice.value || parseFloat(panelPrice.value) <= 0) {
        alert("Por favor, ingresa un precio válido.");
        panelPrice.focus();
        return;
    }

    if (!panelStock.value || parseInt(panelStock.value) < 0) {
        alert("Por favor, ingresa una cantidad de stock válida.");
        panelStock.focus();
        return;
    }

    if (confirm(`¿Está seguro de guardar el producto "${nameInput.value.trim()}"?`)) {
        // Aca va el restito de logiquita
        // enviar los datos

        alert("Producto guardado correctamente.");
        closePanel();
    }
});

document.addEventListener("keydown", function(e) {
    if (e.key === "Escape" && panelNew.classList.contains("active")) {
        if (confirm("¿Está seguro de cerrar la ventana? Los datos no guardados se perderán.")) {
            closePanel();
        }
    }
});

// Precio
panelPrice.addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9.]/g, '');
    validateNonNegative(this);
});

// Stock
panelStock.addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    validateNonNegative(this);
});

minusBtn.addEventListener("click", function(e) {
    e.preventDefault();
    let currentValue = parseInt(panelStock.value) || 0;
    if (currentValue > 0) {
        panelStock.value = currentValue - 1;
        panelStock.dispatchEvent(new Event('input'));
    }
});

plusBtn.addEventListener("click", function(e) {
    e.preventDefault();
    let currentValue = parseInt(panelStock.value) || 0;
    const maxStock = 999;
    if (currentValue < maxStock) {
        panelStock.value = currentValue + 1;
        panelStock.dispatchEvent(new Event('input'));
    } else {
        alert(`El stock máximo es ${maxStock}.`);
    }
});

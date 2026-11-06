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


// Kakakakkakamil
const $ = id => document.getElementById(id);
let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
let timer;

const formatear = n => '$' + n.toLocaleString('es-UY', { maximumFractionDigits: 2 });

// Cosito para buscar los productitos
$('search-product').addEventListener('input', e => {
    clearTimeout(timer);
    const q = e.target.value.trim();
    timer = setTimeout(() => buscar(q), 300);
});

async function buscar(q) {
    const cont = $('search-results');
    if (q.length < 2) { cont.innerHTML = ''; return; }

    const res = await fetch('../api/buscar_productos.php?q=' + encodeURIComponent(q));
    const productos = await res.json();

    cont.innerHTML = '';
    productos.forEach(p => {
        const div = document.createElement('div');
        div.className = 'search-item';
        div.innerHTML = `<span></span><small></small>`;
        div.children[0].textContent = p.nombre;
        div.children[1].textContent = `${formatear(p.precio_unitario)} · stock ${p.stock}`;
        div.onclick = () => { agregar(p); cont.innerHTML = ''; $('search-product').value = ''; };
        cont.appendChild(div);
    });
}

document.addEventListener('click', e => {
    if (!e.target.closest('.search-input')) $('search-results').innerHTML = '';
});

// Carritito de compras
function agregar(p) {
    const item = carrito.find(i => i.id === p.id);
    if (item) {
        if (item.cantidad < p.stock) item.cantidad++;
    } else {
        carrito.push({ id: p.id, nombre: p.nombre, precio_unitario: p.precio_unitario, stock: p.stock, cantidad: 1 });
    }
    guardarYRender();
    openCart();
}   

document.querySelectorAll('.catalog-add-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.catalog-item');
        const p = {
            id: Number(item.dataset.id),
            nombre: item.dataset.name,
            precio_unitario: Number(item.dataset.price),
            stock: Number(item.dataset.stock)
        };
        agregar(p);
    });
});

function cambiarCantidad(id, delta) {
    const item = carrito.find(i => i.id === id);
    if (!item) return;
    item.cantidad = Math.min(item.stock, item.cantidad + delta);
    if (item.cantidad < 1) carrito = carrito.filter(i => i.id !== id);
    guardarYRender();
}

function quitar(id) {
    carrito = carrito.filter(i => i.id !== id);
    guardarYRender();
}

function guardarYRender() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    render();
}

function render() {
    const body = $('cart-body');
    const total_items = carrito.reduce((s, i) => s + i.cantidad, 0);
    $('cart-count').textContent = total_items;
    if ($('cart-badge')) $('cart-badge').textContent = total_items;

    // Limpiamos todoooo esto menos el estado vacio
    body.querySelectorAll('.cart-item').forEach(el => el.remove());
    $('cart-empty').style.display = carrito.length ? 'none' : '';

    carrito.forEach(i => {
        const row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML = `
            <div class="cart-item-icon">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="cart-item-info">
                <p class="cart-item-name"></p>
                <span class="cart-item-price">${formatear(i.precio_unitario)}</span>
            </div>
            <div class="cart-item-controls">
                <button type="button" class="cart-qty-btn" data-a="menos">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="cart-qty">${i.cantidad}</span>
                <button type="button" class="cart-qty-btn" data-a="mas">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <span class="cart-item-subtotal">${formatear(i.precio_unitario * i.cantidad)}</span>
            <button type="button" class="cart-item-remove" data-a="quitar">
                <i class="fa-solid fa-trash"></i>
            </button>`;
        row.querySelector('.cart-item-name').textContent = i.nombre;
        row.querySelector('[data-a="menos"]').onclick  = () => cambiarCantidad(i.id, -1);
        row.querySelector('[data-a="mas"]').onclick    = () => cambiarCantidad(i.id, 1);
        row.querySelector('[data-a="quitar"]').onclick = () => quitar(i.id);
        body.appendChild(row);
    });
 
    // Totales.
    const subtotal = carrito.reduce((s, i) => s + i.precio_unitario * i.cantidad, 0);
    const iva = subtotal * 0.22;
    $('cart-subtotal').textContent = formatear(subtotal);
    $('cart-tax').textContent      = formatear(iva);
    $('cart-total').textContent    = formatear(subtotal + iva);
}

// Registramos la venta :V
$('cart-checkout').addEventListener('click', async () => {
    if (!carrito.length) return alert('El carrito está vacío');

    const btn = $('cart-checkout');
    btn.disabled = true;

    try {
        const res = await fetch('../api/registrar_venta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ items: carrito.map(i => ({ id: i.id, cantidad: i.cantidad })) })
        });
        const data = await res.json();

        if (data.ok) {
            alert('Venta registrada #' + data.venta_id);
            carrito = [];
            guardarYRender();
            closeCart();
        } else {
            alert('Error: ' + data.error);
        }
    } catch (err) {
        alert('No se pudo conectar con el servidor');
    } finally {
        btn.disabled = false;
    }
});

render();

//Anular una venta
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;

    const fila = btn.closest('[data-id]');
    if (!fila) return;

    const id = fila.dataset.id;

    if (!confirm('¿Está seguro de anular esta venta? Esta acción no se puede revertir.')) return;

    try {
        const formData = new FormData();
        formData.append('id', id);

        const res = await fetch('../api/anular_venta.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.ok) {
            const celdaEstado = fila.querySelector('td:nth-child(6)');
            if (celdaEstado) {
                celdaEstado.textContent = 'Anulada';
                celdaEstado.classList.add('estado-anulada');
            }

            fila.querySelectorAll('.btn-edit, .btn-delete').forEach(b => b.disabled = true);
        } else {
            alert('Error al anular: ' + (data.error || 'desconocido'));
        }
    } catch (err) {
        alert('Error de conexión: ' + err.message);
    }
});
//==============================================================================

//                        Agregar producto

//==============================================================================
const addBtn = document.getElementById('add-btn-desktop');
const addBtnMobile = document.getElementById('add-btn-mobile');


addBtn.addEventListener('click', () => {
    window.location.href = 'inventory_add.php';
});

addBtnMobile.addEventListener('click', () => {
    window.location.href = 'inventory_add.php';
});

//==============================================================================
//                        Editar producto
//==============================================================================
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;
    // Busca el elemento padre que tenga data-id (el <tr> o el <div>)
    const contenedor = btn.closest('[data-id]');
    if (!contenedor) return;
    const id = contenedor.dataset.id;
    window.location.href = `inventory_edit.php?id=${id}`;
});


//==============================================================================

//                        Eliminar producto

//==============================================================================
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;

    const contenedor = btn.closest('[data-id]');
    if (!contenedor) return;

    const id = contenedor.dataset.id;

    if (!confirm('¿Está seguro de eliminar este producto?')) return;

    try {
        const formData = new FormData();
        formData.append('id', id);

        const res  = await fetch('../api/procesar_eliminar_producto.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.ok) {
            contenedor.remove();
        } else {
            alert('Error al eliminar: ' + (data.error || 'desconocido'));
        }
    } catch (err) {
        alert('Error de conexión: ' + err.message);
    }
});


//==============================================================================

//                        Ordenar inventario

//==============================================================================
const orderBtn = document.getElementById('order-btn');
const contentList = document.getElementById('content-list');

orderBtn.addEventListener('click', () => {
    contentList.classList.toggle('active');
});


//==============================================================================

//                        BUSCADOR :VVVVV

//==============================================================================
function inicializarBuscadorInv(inputId, boxId) {
    var input = document.getElementById(inputId);
    var box = document.getElementById(boxId);
    if (!input || !box) return;
    var timer = null;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        var q = input.value.trim();
        timer = setTimeout(function () {
            if (q.length < 2) { box.innerHTML = ''; return; }
            fetch('../api/buscar_inventario.php?q=' + encodeURIComponent(q))
                .then(function (r) { return r.json(); })
                .then(function (datos) {
                    box.innerHTML = '';
                    datos.forEach(function (p) {
                        var div = document.createElement('div');
                        div.className = 'search-item';
                        div.innerHTML = '<span></span><small></small>';
                        div.children[0].textContent = p.nombre;
                        div.children[1].textContent = p.categoria + ' · stock ' + p.stock;
                        div.addEventListener('click', function () {
                            input.value = p.nombre;
                            box.innerHTML = '';
                            filtrarTablaInv(p.nombre);
                        });
                        box.appendChild(div);
                    });
                });
        }, 300);
    });
}

inicializarBuscadorInv('search-inventario', 'search-results-inv');
inicializarBuscadorInv('search-inventario-desktop', 'search-results-inv-desktop');

function filtrarTablaInv(texto) {
    texto = texto.toLowerCase();
    document.querySelectorAll('.table-list tbody tr[data-id]').forEach(function (tr) {
        tr.style.display = tr.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
    document.querySelectorAll('#content-list .product-item').forEach(function (el) {
        el.style.display = el.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-input')) {
        document.querySelectorAll('.search-results').forEach(function (b) { b.innerHTML = ''; });
    }
});
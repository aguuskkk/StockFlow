// Buscador tipo ventas: escribe, espera 300ms, pide a la API y muestra desplegable
var input = document.getElementById('search-user');
var box = document.getElementById('search-results-user');
var timer = null;

input.addEventListener('input', function () {
    clearTimeout(timer);
    var q = input.value.trim();
    timer = setTimeout(function () { buscar(q); }, 300);
});

function buscar(q) {
    if (q.length < 2) { box.innerHTML = ''; return; }

    fetch('../api/buscar_usuarios.php?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (datos) {
            box.innerHTML = '';
            datos.forEach(function (u) {
                var div = document.createElement('div');
                div.className = 'search-item';
                div.innerHTML = '<span></span><small></small>';
                div.children[0].textContent = u.nombre;
                div.children[1].textContent = u.email + ' · ' + u.rol;
                div.addEventListener('click', function () {
                    input.value = u.nombre;
                    box.innerHTML = '';
                    filtrarTabla(u.nombre);
                });
                box.appendChild(div);
            });
        });
}

function filtrarTabla(texto) {
    texto = texto.toLowerCase();
    document.querySelectorAll('#users-tbody tr[data-id]').forEach(function (tr) {
        tr.style.display = tr.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
    document.querySelectorAll('#users-list .user-item').forEach(function (el) {
        el.style.display = el.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-input')) box.innerHTML = '';
});

// Eliminar usuario
document.addEventListener('click', function (e) {
    var btn = e.target.closest('.btn-delete');
    if (!btn || btn.disabled) {
        return;
    }

    var fila = btn.closest('[data-id]');
    if (!fila) {
        return;
    }

    var id = fila.getAttribute('data-id');

    if (!confirm('¿Estás seguro de eliminar este usuario?')) {
        return;
    }

    var form = new FormData();
    form.append('id', id);

    fetch('../api/procesar_eliminar_usuario.php', {
        method: 'POST',
        body: form
    })
    .then(function (respuesta) {
        return respuesta.json();
    })
    .then(function (datos) {
        if (datos.ok) {
            document.querySelectorAll('[data-id="' + id + '"]').forEach(function (el) {
                el.remove();
            });
        } else {
            alert('Error al eliminar: ' + (datos.error || 'desconocido'));
        }
    })
    .catch(function (err) {
        alert('Error de conexión: ' + err.message);
    });
});
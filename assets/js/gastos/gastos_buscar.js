// Buscador tipo ventas para gastos
var input = document.getElementById('search-expense');
var box = document.getElementById('search-results-gas');
var timer = null;

input.addEventListener('input', function () {
    clearTimeout(timer);
    var q = input.value.trim();
    timer = setTimeout(function () { buscar(q); }, 300);
});

function buscar(q) {
    if (q.length < 2) { box.innerHTML = ''; return; }

    fetch('../api/buscar_gastos.php?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (datos) {
            box.innerHTML = '';
            datos.forEach(function (g) {
                var div = document.createElement('div');
                div.className = 'search-item';
                div.innerHTML = '<span></span><small></small>';
                div.children[0].textContent = g.descripcion;
                div.children[1].textContent = g.categoria + ' · $' + g.monto;
                div.addEventListener('click', function () {
                    input.value = g.descripcion;
                    box.innerHTML = '';
                    filtrarTabla(g.descripcion);
                });
                box.appendChild(div);
            });
        });
}

function filtrarTabla(texto) {
    texto = texto.toLowerCase();
    document.querySelectorAll('#expenses-tbody tr').forEach(function (tr) {
        tr.style.display = tr.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
    document.querySelectorAll('#expenses-list .expense-item').forEach(function (el) {
        el.style.display = el.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.search-input')) box.innerHTML = '';
});
// Botón Reponer de la tabla Stock bajo
var botones = document.querySelectorAll('.btn-reponer');

botones.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var fila = btn.closest('tr');
        var id = fila.getAttribute('data-id');

        var cantidad = prompt('¿Cuántas unidades querés reponer?');
        if (cantidad === null) {
            return;
        }

        cantidad = parseInt(cantidad);
        if (isNaN(cantidad) || cantidad <= 0) {
            alert('Ingresá un número mayor que 0');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Guardando...';

        var form = new FormData();
        form.append('id', id);
        form.append('cantidad', cantidad);

        fetch('../api/reponer_stock.php', {
            method: 'POST',
            body: form
        })
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            if (datos.ok) {
                alert('Stock repuesto. Nuevo stock: ' + datos.stock_nuevo);
                location.reload();
            } else {
                alert('Error: ' + datos.error);
                btn.disabled = false;
                btn.textContent = 'Reponer';
            }
        })
        .catch(function () {
            alert('No se pudo conectar con el servidor');
            btn.disabled = false;
            btn.textContent = 'Reponer';
        });
    });
});
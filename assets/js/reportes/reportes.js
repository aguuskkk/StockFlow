// Buscamos los elementos de la página
var form = document.getElementById('report-form');
var tipoSelect = document.getElementById('report-type');
var desdeInput = document.getElementById('date-from');
var hastaInput = document.getElementById('date-to');

var countEl = document.getElementById('report-count');
var rangeEl = document.getElementById('report-range');
var totalEl = document.getElementById('report-total');

var tabla = document.getElementById('table-body');
var listaMobile = document.getElementById('content-list-mobile');



form.addEventListener('submit', function (e) {
    e.preventDefault();
    cargarReporte();
});


function cargarReporte() {
    var tipo = tipoSelect.value;
    var desde = desdeInput.value;
    var hasta = hastaInput.value;

    var url = '../api/reporte.php?tipo=' + tipo + '&desde=' + desde + '&hasta=' + hasta;

    fetch(url)
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            if (!datos.ok) {
                countEl.textContent = 'Hubo un error';
                return;
            }

            mostrarResultados(datos, desde, hasta);
        });
}


//Función para mostrar los datos en pantalla
function mostrarResultados(datos, desde, hasta) {
    // Textos de arriba
    countEl.textContent = datos.count + ' eventos';
    rangeEl.textContent = desde + ' - ' + hasta;
    totalEl.textContent = '$' + datos.totalNeto.toFixed(2);

    // Si no hay resultados
    if (datos.rows.length === 0) {
        tabla.innerHTML = '<tr><td colspan="5">No hay resultados</td></tr>';
        listaMobile.innerHTML = '<p>No hay resultados</p>';
        return;
    }

    // Variables para armar el HTML
    var htmlTabla = '';
    var htmlMobile = '';
    var i;

    //Recorremos cada resultado uno por uno :v
    for (i = 0; i < datos.rows.length; i++) {
        var fila = datos.rows[i];

        var textoTipo = '';
        var textoMonto = '';
        var textoEstado = '';

        // Texto del tipo
        if (fila.tipo === 'sales') {
            textoTipo = 'Venta';
        } else if (fila.tipo === 'expenses') {
            textoTipo = 'Gasto';
        } else {
            textoTipo = 'Stock';
        }

        // Texto del monto
        if (fila.tipo === 'stock') {
            textoMonto = fila.cantidad + ' u.';
        } else if (fila.monto >= 0) {
            textoMonto = '+$' + fila.monto.toFixed(2);
        } else {
            textoMonto = '-$' + Math.abs(fila.monto).toFixed(2);
        }

        // Texto del estado
        if (fila.estado === 'completada') {
            textoEstado = 'Completada';
        } else if (fila.estado === 'pagado') {
            textoEstado = 'Pagado';
        } else {
            textoEstado = fila.estado;
        }

        // Agregamos una fila a la tabla de escritorio
        htmlTabla += '<tr>';
        htmlTabla += '<td>' + fila.fecha + '</td>';
        htmlTabla += '<td><span class="type-badge ' + fila.tipo + '">' + textoTipo + '</span></td>';
        htmlTabla += '<td><strong>' + fila.titulo + '</strong><br>' + fila.descripcion + '</td>';
        htmlTabla += '<td>' + textoMonto + '</td>';
        htmlTabla += '<td>' + textoEstado + '</td>';
        htmlTabla += '</tr>';

        // Agregamos una tarjeta a la vista mobile
        htmlMobile += '<article class="event-item">';
        htmlMobile += '<div class="event-info">';
        htmlMobile += '<h3>' + fila.titulo + '</h3>';
        htmlMobile += '<p>' + fila.fecha + '</p>';
        htmlMobile += '<p>' + fila.descripcion + '</p>';
        htmlMobile += '<p>' + textoMonto + ' - ' + textoEstado + '</p>';
        htmlMobile += '</div>';
        htmlMobile += '</article>';
    }

    // Mostramos todo junto
    tabla.innerHTML = htmlTabla;
    listaMobile.innerHTML = htmlMobile;
}


// Al abrir la página, cargamos el reporte una vez
cargarReporte();

// Botón Descargar PDF
var btnDescargar = document.getElementById('btn-download');

if (btnDescargar) {
    btnDescargar.addEventListener('click', function () {
        window.print();
    });
}
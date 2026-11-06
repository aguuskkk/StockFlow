// Gráfico de ventas de los últimos 7 días
var ctx = document.getElementById("ventasChart");

if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ventasLabels,
            datasets: [{
                label: "Ventas",
                data: ventasData,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Gráfico de estado del stock
var ctx2 = document.getElementById("stockChart");

if (ctx2) {
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ["Stock normal", "Stock bajo", "Sin stock"],
            datasets: [{
                data: stockData
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}
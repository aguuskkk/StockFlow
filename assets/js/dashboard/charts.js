const ctx = document.getElementById("ventasChart")
const ctx2 = document.getElementById("stockChart")

// Ventas
new Chart(ctx, {
    type: 'line',

    data: {
        labels: ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],

        datasets: [{
            label: "Ventas",
            data: [1200, 3450, 2000, 5609, 8990, 12320, 670],

            borderWidth: 2,
            tension: 0.4,
            fill: true
        }],
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                display: false,
            },
        },
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    }
});

// Stock
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ["Stock normal", "Stock bajo", "Sin stock"],

        datasets: [{
            data: [980, 186, 87]
        }],
    },
    options: {
        responsive: true,

        plugins: {
            legend: {
                position: 'bottom',
            },
        }
    }
});

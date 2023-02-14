const coloresTrayecto = [];

camposGraficoTrayecto.forEach((campo) => coloresTrayecto.push(color()));

const dataGraficoTrayecto = {
    labels: camposGraficoTrayecto,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto,
            data: infoGraficoTrayecto,
        },
    ],
};

const configGraficoTrayecto = {
    type: "pie",
    data: dataGraficoTrayecto,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "Trayecto",
                font: {
                    weight: "bold",
                    size: 14,
                    family: "system-ui",
                },
            },
        },
    },
};
const chart3 = new Chart(
    document.getElementById("graficoTrayecto"),
    configGraficoTrayecto
);

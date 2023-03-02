const coloresTrayecto2 = [];

camposTrayecto2.forEach((campo) => coloresTrayecto2.push(color()));

const dataGraficoTrayecto2 = {
    labels: camposTrayecto2,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto2,
            data: infoTrayecto2.map((campo) => {
                return campo;
            }),
        },
    ],
};

const configGraficoTrayecto2 = {
    type: "bar",
    data: dataGraficoTrayecto2,
    options: {
        indexAxis: "y",
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: "Popularidad",
                font: {
                    weight: "bold",
                    size: 14,
                    family: "system-ui",
                },
            },
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: "PNF y Acreditable",
                },
            },
            y: {
                title: {
                    display: true,
                    text: "Estudiantes",
                },
            },
        },
    },
};

const chartTrayecto2 = new Chart(
    document.getElementById("graficoTrayecto2"),
    configGraficoTrayecto2
);

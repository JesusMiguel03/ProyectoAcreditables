const coloresTrayecto3 = [];

camposTrayecto3.forEach((campo) => coloresTrayecto3.push(color()));

const dataGraficoTrayecto3 = {
    labels: camposTrayecto3,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto3,
            data: infoTrayecto3.map((campo) => {
                return campo;
            }),
        },
    ],
};

const configGraficoTrayecto3 = {
    type: "bar",
    data: dataGraficoTrayecto3,
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

const chartTrayecto3 = new Chart(
    document.getElementById("graficoTrayecto3"),
    configGraficoTrayecto3
);

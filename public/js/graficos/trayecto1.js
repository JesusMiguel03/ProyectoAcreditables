const coloresTrayecto1 = [];

camposTrayecto1.forEach((campo) => coloresTrayecto1.push(color()));

const dataGraficoTrayecto1 = {
    labels: camposTrayecto1,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto1,
            data: infoTrayecto1.map((campo) => {
                return campo;
            }),
        },
    ],
};

const configGraficoTrayecto1 = {
    type: "bar",
    data: dataGraficoTrayecto1,
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

const chartTrayecto1 = new Chart(
    document.getElementById("graficoTrayecto1"),
    configGraficoTrayecto1
);

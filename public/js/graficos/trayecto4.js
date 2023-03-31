const coloresTrayecto4 = [];

camposTrayecto4.forEach((campo) => coloresTrayecto4.push(color()));

const dataGraficoTrayecto4 = {
    labels: camposTrayecto4,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto4,
            data: infoTrayecto4.map((campo) => {
                return campo;
            }),
        },
    ],
};

const configGraficoTrayecto4 = {
    type: "bar",
    data: dataGraficoTrayecto4,
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

const chartTrayecto4 = new Chart(
    document.getElementById("graficoTrayecto4"),
    configGraficoTrayecto4
);

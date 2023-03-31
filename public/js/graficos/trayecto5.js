const coloresTrayecto5 = [];

camposTrayecto5.forEach((campo) => coloresTrayecto5.push(color()));

const dataGraficoTrayecto5 = {
    labels: camposTrayecto5,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresTrayecto5,
            data: infoTrayecto5.map((campo) => {
                return campo;
            }),
        },
    ],
};

const configGraficoTrayecto5 = {
    type: "bar",
    data: dataGraficoTrayecto5,
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

const chartTrayecto5 = new Chart(
    document.getElementById("graficoTrayecto5"),
    configGraficoTrayecto5
);

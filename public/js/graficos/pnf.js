const coloresPNF = [];
const coloresAnteriorPNF = [];

camposGraficoPNF.forEach((campo) => {
    coloresPNF.push(color()), coloresAnteriorPNF.push(color());
});

const dataGraficoPNF = {
    labels: camposGraficoPNF,
    datasets: [
        {
            type: "bar",
            label: "Estudiantes (Periodo actual)",
            backgroundColor: coloresPNF,
            data: infoGraficoPNF,
            borderWidth: 2,
            borderColor: "#4ac0c1",
        },
        {
            type: "bar",
            label: "Estudiantes (Periodo anteior)",
            backgroundColor: coloresPNF,
            data: infoGraficoAnteriorPNF,
            borderWidth: 2,
            borderColor: "#9967fe",
        },
        {
            label: "",
            backgroundColor: "transparent",
            data: infoGraficoPNF,
            type: "line",
            borderColor: "#000",
        },
    ],
};

const configGraficoPNF = {
    data: dataGraficoPNF,
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                display: false,
            },
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "PNF",
                font: {
                    weight: "bold",
                    size: 14,
                    family: "system-ui",
                },
            },
        },
    },
};

const chart2 = new Chart(
    document.getElementById("graficoPNF"),
    configGraficoPNF
);

const coloresMaterias = []

camposGraficoMaterias.forEach(campo => coloresMaterias.push(color()))

const dataGraficoMaterias = {
    labels: camposGraficoMaterias,
    datasets: [
        {
            label: "Estudiantes",
            backgroundColor: coloresMaterias,
            data: infoGraficoMaterias,
        },
    ],
};

const configGraficoMaterias = {
    type: "bar",
    data: dataGraficoMaterias,
    options: {
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
                    text: "Materias",
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
const chart1 = new Chart(
    document.getElementById("graficoMaterias"),
    configGraficoMaterias
);

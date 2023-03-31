// Selecciona todos los que tengan +1 comprobante
const comprobantesEstudiantes = document.querySelectorAll(
    "[data-listarComprobantes]"
);

// Donde los mostará
const listadoComprobantes = document.getElementById("seccionComprobantes");

let comprobante;

// Itera cada botón
comprobantesEstudiantes.forEach((estudiante) => {
    // Cuando se haga clic genera un enlace por cada comprobante
    estudiante.addEventListener("click", (e) => {
        let comprobantes = e.currentTarget.getAttribute("data-comprobantes");

        listadoComprobantes.innerText = "";

        for (comprobante = 1; comprobante <= comprobantes; comprobante++) {
            let id = e.currentTarget.getAttribute("data-estudiante");
            let a = document.createElement("a");

            comprobante % 2 === 0
                ? a.classList.add("btn", "btn-danger", "col-5", "offset-2")
                : a.classList.add("btn", "btn-danger", "col-5");
            a.innerText = `Comprobante #${comprobante}`;
            a.href = `/estudiante/${id}/comprobante/${comprobante}`;
            listadoComprobantes.append(a);
        }
    });
});

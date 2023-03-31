// Busca todos los enlaces de comprobantes
const enlaces = document.querySelectorAll("[data-download]");

// Cuando se haga clic muestra un alert info
enlaces.forEach((comprobante) => {
    comprobante.addEventListener("click", () => {
        Swal.fire({
            icon: "info",
            title: "¡Descargando comprobante!",
            html: "Su comprobante se está descargando, espere unos minutos hasta que se haya descargado.",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-info px-5",
            },
        });
    });
});

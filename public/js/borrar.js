const url = `${window.location.href}`;
const botones = document.querySelectorAll(".borrar");
const form = document.getElementById("form-borrar");

// Itera cada boton
botones.forEach((boton) => {
    boton.addEventListener("click", function () {
        /**
         * * Cambia la ruta del formulario, colocando el id seleccionado
         *
         * @param url: Representa la url de la vista actual
         * @param this.id: El id del elemento a borrar
         */
        form.action = `${url}/${this.id}/delete`;

        Swal.fire({
            title: "¿Está seguro?",
            html: `${this.getAttribute(
                "data-type"
            )} <strong>${this.getAttribute("data-name")}</strong> será borrado`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-danger px-5 mr-2",
                cancelButton: "btn btn-secondary px-5 ml-2",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

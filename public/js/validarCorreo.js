// Variables
const form = document.getElementById("recuperar");
const btn = document.querySelector("button");
const correo = document.getElementById("correo");

// Regex de validacion de correo
const validacion =
    /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

btn.addEventListener("click", (e) => {
    e.preventDefault();

    // Busca el mensaje de error
    let mensajeError = document.querySelector("#error");

    if (validacion.test(correo.value)) {

        // Si hay un mensaje de error lo elimina
        if (mensajeError !== null) {
            mensajeError.remove();
        }

        Swal.fire({
            title: "¿Está seguro?",
            html: `Al hacer clic en confirmar se generará una nueva contraseña para el usuario cuyo correo es: <strong>${correo.value}</strong>`,
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
    } else {
        
        // Si no hay mensaje de error, crea uno nuevo
        if (mensajeError === null) {
            let span = document.createElement("span");
            let strong = document.createElement("strong");

            span.classList.add("text-danger");
            span.setAttribute("role", "alert");
            span.setAttribute("id", "error");
            strong.innerText =
                "El correo debe ser una direción de correo electrónico válido";

            span.append(strong);
            document.querySelector(".form-group").append(span);
        }
    }
});

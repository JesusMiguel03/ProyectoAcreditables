// Variables
const form = document.getElementById("recuperar");
const btn = document.querySelector("button");
const correo = document.getElementById("correo");

// Regex de validacion de correo
const validacion =
    /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

// Valida que el correo sea valido antes de permitir el envio
correo.addEventListener("input", (e) => {
    let mensajeError = document.querySelector("#error");

    if (validacion.test(e.currentTarget.value)) {
        btn.removeAttribute("disabled");

        if (mensajeError !== null) {
            mensajeError.remove();
        }
    } else {
        btn.setAttribute("disabled", true);

        if (mensajeError === null) {
            let span = document.createElement("small");
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

btn.addEventListener("click", () => {
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
});

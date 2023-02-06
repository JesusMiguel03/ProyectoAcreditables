const [boton, formulario] = [
    document.getElementById("cambiarAcreditable"),
    document.getElementById("form"),
];

if (boton !== null) {
    boton.addEventListener("click", (e) => {
        e.preventDefault();

        // ID del usuario y materia
        const [usuarioID, materiaID] = [
            e.currentTarget.getAttribute("data-id"),
            e.currentTarget.getAttribute("data-materia"),
        ];

        // Cambia la ruta
        formulario.action = `/inscripcion/${usuarioID}/${materiaID}/cambiar`;

        // Muestra un modal de confirmacion y manda
        Swal.fire({
            icon: "question",
            title: "¿Desea cambiar de acreditable?",
            html: "Tenga en cuenta que al cambiarse si su cupo es tomado por otro estudiante no podrá optar por volver a la acreditable anterior.",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar",
            customClass: {
                action: "separador",
                confirmButton: "btn boton btn-danger",
                cancelButton: "btn boton btn-primary",
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                formulario.submit();
            }
        });
    });
}

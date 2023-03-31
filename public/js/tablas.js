$(document).ready(function () {
    $("#tabla").DataTable({
        lengthMenu: [
            [10, 20, 30, -1],
            [10, 20, 30, "Todos"],
        ],
        language: {
            lengthMenu: "Mostrar _MENU_",
            zeroRecords: "No se encontraron datos",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay datos disponibles",
            infoFiltered: "(filtrado de _MAX_ registros)",
            search: "Buscar",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
    });
});

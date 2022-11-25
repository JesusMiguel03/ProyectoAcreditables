document.addEventListener("DOMContentLoaded", function () {
    let formulario = document.getElementById("horario");

    const calendarEl = document.getElementById("agenda");
    const calendar = new FullCalendar.Calendar(calendarEl, {
        expandRows: true,
        height: "70vh",
        contentHeight: "120",
        initialView: "timeGridWeek",
        locale: "es",
        allDaySlot: false,
        slotMinTime: "07:30:00",
        slotMaxTime: "16:00:00",
        slotDuration: "00:45:00",
        dayHeaderFormat: { weekday: "long" },
        weekends: false,
        slotLabelFormat: {
            hour: "numeric",
            minute: "2-digit",
            meridiem: "short",
            hourCycle: "h12",
        },
        headerToolbar: {
            left: "",
            center: "",
            right: "",
        },
        events:  "http://proyectoacreditables.test/horario/show",
        dateClick: function (info) {
            $("#evento").modal("show");
        },
    });
    calendar.render();

    document.getElementById("btnGuardar").addEventListener("click", () => {
        const datos = new FormData(formulario);

        // $.ajax({
        //     type: 'POST',
        //     url: 'horario/store',
        //     body: JSON.stringify(datos),
        // })

        // fetch('horario/store', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //     },
        //     body: JSON.stringify(datos),
        // })

        // console.log(datos);

        // fetch("horario/store", {
        //     method: "POST",
        //     headers: {
        //         data: datos,
        //     },
        // })
        //     .then((respuesta) => {
        //         $("#evento").modal("hide");
        //     })
        //     .catch((error) => {
        //         error.response ? console.log(error.resopnse.data) : "";
        //     });
    });
});

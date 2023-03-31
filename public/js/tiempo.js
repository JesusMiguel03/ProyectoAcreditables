// Iniacializa las variables
let [mostrarTiempo, actualizarContador] = ["", 0];

// Busca el elemento donde mostrar la hora
const ubicacion = document.getElementById("time") || "";
mostrarTiempo = ubicacion;

// Devuelve el número en formato 00
const ceros = (tiempo) => {
    return tiempo.toString().length >= 2 ? tiempo : "0".concat(tiempo);
};

// Arrays con los dias y meses abreviados
const [dia, mes] = [
    ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
    [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic",
    ],
];

// Actualiza la fecha
const actualizar = () => {
    if (mostrarTiempo !== "") {
        const tiempo = new Date();
        let [diaSemana, diaNumero, mesActual, fecha, hora, minutos, amPM] = [
            dia[tiempo.getDay()],
            tiempo.getDate(),
            mes[tiempo.getMonth()],
            tiempo.getFullYear(),
            ceros(
                tiempo.getHours() > 12
                    ? tiempo.getHours() - 12
                    : tiempo.getHours()
            ),
            ceros(tiempo.getMinutes()),
            tiempo.getHours() >= 12 ? "PM" : "AM",
        ];

        mostrarTiempo.innerText = `${diaSemana}, ${diaNumero} de ${mesActual} de ${fecha} - ${hora}:${minutos} ${amPM}`;
    }
};
setInterval(actualizar, 1000);

mostrarTiempo ? (actualizarContador = actualizar()) : "";

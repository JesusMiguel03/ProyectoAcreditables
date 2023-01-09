"use strict";

// Iniacializa las variables
let [mostrarTiempo, actualizarContador] = ["", 0];

// Busca el elemento donde mostrar la hora
document.getElementById("time")
    ? (mostrarTiempo = document.getElementById("time"))
    : "";

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
        mostrarTiempo.innerHTML = `${
            dia[tiempo.getDay()]
        }, ${tiempo.getDate()} de ${
            mes[tiempo.getMonth()]
        } de ${tiempo.getFullYear()} - ${ceros(
            tiempo.getHours() > 12 ? tiempo.getHours() - 12 : tiempo.getHours()
        )}:${ceros(tiempo.getMinutes())} ${
            tiempo.getHours() >= 12 ? "PM" : "AM"
        }`;
    }
};
setInterval(actualizar, 1000);

mostrarTiempo ? (actualizarContador = actualizar()) : "";

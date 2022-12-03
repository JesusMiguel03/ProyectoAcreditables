"use strict";

let [displayTime, updaterContainer] = ["", 0];

document.getElementById("time")
    ? (displayTime = document.getElementById("time"))
    : "";

const addZero = (time) => {
    return time.toString().length >= 2 ? time : "0".concat(time);
};

const [day, month] = [
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

const update = () => {
    if (displayTime !== "") {
        const time = new Date();
        displayTime.innerHTML = `${
            day[time.getDay()]
        }, ${time.getDate()} de ${
            month[time.getMonth()]
        } de ${time.getFullYear()} - ${addZero(time.getHours() > 12 ? time.getHours()- 12 : time.getHours())}:${addZero(
            time.getMinutes()
        )} ${time.getHours() >= 12 ? "PM" : "AM"}`;
    }
};
setInterval(update, 1000);

displayTime ? (updaterContainer = update()) : "";

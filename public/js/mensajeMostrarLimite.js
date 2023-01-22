/**
 *  Cambiar el color del texto de un elemento
 *
 *  @param {HTMLInputElement} elemento
 *  @param {int} max
 *  @param {HTMLSmallElement} textoAyuda
 *  @param {boolean} numero
 *  @returns void
 */
const cambiarColorAyuda = (elemento, max, textoAyuda, numero = "") => {
    let condicion = "";

    numero.length === 0
        ? (condicion = elemento.value.length <= max)
        : (condicion = parseInt(elemento.value) <= parseInt(max));

    if (numero.length !== 0 && elemento.value === "") {
        textoAyuda.classList.remove("text-success", "text-danger");
        textoAyuda.classList.add("text-muted");

        return;
    }

    if (condicion) {
        if (numero === "invertido") {
            textoAyuda.classList.remove("text-success", "text-muted");
            textoAyuda.classList.add("text-danger");

            return;
        }
        textoAyuda.classList.remove("text-danger", "text-muted");
        textoAyuda.classList.add("text-success");
    } else {
        if (numero === "invertido") {
            textoAyuda.classList.remove("text-danger", "text-muted");
            textoAyuda.classList.add("text-success");

            return;
        }
        textoAyuda.classList.remove("text-success", "text-muted");
        textoAyuda.classList.add("text-danger");
    }
};

/**
 *  Inicializa variables
 */
const [input, contadores, btn] = [
    document.querySelectorAll("input, textarea"),
    [],
    document.querySelector(".btn-success"),
];

/**
 *  Filtra solo los <input> que tendrán mensaje
 */
input.forEach((elemento) => {
    if (
        elemento.hasAttribute("maxlength") ||
        (elemento.hasAttribute("minlength") &&
            elemento.hasAttribute("data-nombre"))
    ) {
        contadores.push(elemento);
    }
});

/**
 *  Crea elementos <div> y <small>, le asigna sus clases y contenido
 */
contadores.forEach((contador) => {
    let [cantidad, tipo] = [
        contador.getAttribute("maxlength") ||
            contador.getAttribute("minlength"),
        contador.getAttribute("data-nombre"),
    ];
    let [div, small] = [
        document.createElement("div"),
        document.createElement("small"),
    ];

    div.classList.add("input-group");

    small.classList.add("ayuda", "text-muted");

    let inicio = tipo !== "caracteres" ? contador.value : contador.value.length;
    inicio === "" ? (inicio = contador.value.length) : "";

    small.textContent = `${inicio} / ${cantidad} ${tipo}`;

    div.append(small);
    contador.parentNode.append(div);
});

/**
 *  Guarda todos los elementos <small> con clase
 */
const textoAyuda = document.querySelectorAll(".ayuda");

/**
 *  Actualiza en tiempo real la cantidad de caracteres
 */
contadores.forEach((contador, i) => {
    let [cantidad, tipo] = [
        contador.getAttribute("maxlength") ||
            contador.getAttribute("minlength"),
        contador.getAttribute("data-nombre"),
    ];

    let valorNumerico = tipo !== "caracteres" ? "numero" : "";

    if (contador.getAttribute("minlength")) {
        valorNumerico = "invertido";
    }

    contador.addEventListener("input", function () {
        cambiarColorAyuda(this, cantidad, textoAyuda[i], valorNumerico);

        let valor = "";
        if (tipo !== "caracteres") {
            valor = this.value;

            parseInt(valor) > parseInt(cantidad)
                ? ((this.value = cantidad), (valor = cantidad))
                : "";
        } else {
            valor = this.value.length;
        }

        valor === "" ? (valor = 0) : "";

        textoAyuda[i].innerText = `${valor} / ${cantidad} ${tipo}`;
    });
});

/**
 *
 * @param {arr} $array
 * @param {valor} $string
 * @returns
 */
const remover = (arr, valor) => {
    for (let i = 0; i < arr.length; i++) {
        arr[i] === valor ? arr.splice(i, 1) : "";
    }
    return arr;
};

/**
 *
 * @param {elemento} $HTMLelement
 * @param {max} $int
 * @param {textoAyuda} $HTMLelement
 * 
 * ! Si el nro es 0 no se coloca danger
 * ! En la vista de /horarios se muestra cupos en vez de número
 */
const cambiarColorAyuda = (elemento, max, textoAyuda) => {
    let condicion =
        elemento.type === "number"
            ? elemento.value > max
            : elemento.value.length > max;

    condicion
        ? (textoAyuda.classList.add("text-danger"),
          textoAyuda.classList.remove("text-muted", "text-success"))
        : (textoAyuda.classList.add("text-success"),
          textoAyuda.classList.remove("text-muted", "text-danger"));
};

/**
 *  @param {contadores} $array
 *  @param {temporal} $HTMLelement
 *  @param {btn} $HTMLelement
 */
const [contadores, temporal, btn] = [
    document.querySelectorAll(".contador"),
    document.getElementById("temporal"),
    document.querySelector(".btn-success"),
];

const limites = remover(temporal.innerText.replace(/\s+/g, ",").split(","), "");

// Remueve el elemento con los limites
temporal.remove();

// Itera cada elemento a contar
contadores.forEach((contador, i) => {
    // Crea un elemento <small>
    let small = document.createElement("small");

    // Estila
    small.classList.add("ayuda", "text-muted");

    // Corrige el limite de telefeno descontando el codigo
    contador.getAttribute('name') === 'telefono' ? limites[i] -= 4 : '';

    // Asigna texto
    contador.type === "number"
        ? (small.textContent = `${contador.value.length} / ${limites[i]} cupos`)
        : (small.textContent = `${contador.value.length} / ${limites[i]} carácteres`);

    // Añade al contendor
    contador.parentNode.insertBefore(small, contador.nextSibling);
});

// Selecciona todos los elementos <small> creados
const textoAyuda = document.querySelectorAll(".ayuda");

// Itera de nuevo
contadores.forEach((contador, i) => {
    // Deshabilita el boton si se pasa el limite
    contador.addEventListener("input", function () {
        // Cambia el color de la ayuda
        cambiarColorAyuda(this, limites[i], textoAyuda[i]);

        // Actualiza el contador de carácteres
        this.type === "number"
            ? (textoAyuda[i].innerText = `${this.value} / ${limites[i]} cupos`)
            : (textoAyuda[
                  i
              ].innerText = `${this.value.length} / ${limites[i]} carácteres.`);
    });
});

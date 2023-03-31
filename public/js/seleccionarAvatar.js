/**
 * Inicializa las variables
 * 
 * @param avatares: Todas las imagenes/avatares disponibles.
 * @param avatarSeleccionado: El contendor que muestra el avatar seleccionado.
 * @param seleccionado: El elemento <img> que muestra el avatar.
 * @param input: El elemento <input> que contiene el id del avatar.
 */
const [avatares, avatarSeleccionado, seleccionado, input] = [
    document.querySelectorAll(".avatar"),
    document.getElementById("avatarSeleccionado"),
    document.getElementById("seleccion"),
    document.getElementById("avatarID"),
];

// Itera todos los avatares.
avatares.forEach((avatar) => {

    // Al hacer clic en uno.
    avatar.addEventListener("click", function () {

        // Comprueba que tenga la clase .d-none y la borra, sino, omite.
        avatarSeleccionado.classList.contains("d-none")
            ? avatarSeleccionado.classList.remove("d-none")
            : "";

        // Se coloca la ruta de la imagen y su id en los elementos <img> e <input> correspondientes.
        seleccion.src = this.src;
        input.value = this.id;
    });
});

let archivo = document.getElementById('imagen_materia')
let previsualizar = document.getElementById("previsualizar")
let campoImagen = document.getElementById("campoImagen")
let textoAlternativo = document.getElementById("noImagen")

archivo.addEventListener("change", (e) => {
    if (e.target.files.length === 1) {
        const lector = new FileReader();
        const archivos = e.target.files[0];
        lector.readAsDataURL(archivos);
        lector.onload = function () {
            temp = lector.result;
        };
        console.log(URL.createObjectURL(archivos));
        previsualizar.src = URL.createObjectURL(archivos);
        campoImagen.innerHTML = e.target.files[0].name;
        textoAlternativo ? (textoAlternativo.style.display = "none") : "";
    } else {
        previsualizar.src = "";
        campoImagen.innerHTML = "";
        textoAlternativo ? (textoAlternativo.style.display = "block") : "";
    }
});
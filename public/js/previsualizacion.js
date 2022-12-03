let archivo = document.getElementById('imagen_materia')
let previsualizar = document.getElementById("previsualizar")
let campoImagen = document.getElementById("campoImagen")

archivo.addEventListener("change", (e) => {
    if (e.target.files.length === 1) {
        const lector = new FileReader();
        const archivos = e.target.files[0];
        lector.readAsDataURL(archivos);
        lector.onload = function () {
            temp = lector.result;
        };
        previsualizar.src = URL.createObjectURL(archivos);
        campoImagen.innerHTML = e.target.files[0].name;
    } else {
        previsualizar.src = "";
        campoImagen.innerHTML = "";
    }
});

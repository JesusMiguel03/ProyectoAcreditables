let archivo = document.getElementById("archivo");
let campoArchivo = document.getElementById("campoArchivo");

archivo.addEventListener("change", (e) => {
    if (e.target.files.length === 1) {
        const lector = new FileReader();
        const archivos = e.target.files[0];
        lector.readAsDataURL(archivos);
        lector.onload = function () {
            temp = lector.result;
        };
        campoArchivo.innerHTML = e.target.files[0].name;
    } else {
        campoArchivo.innerHTML = "";
    }
});

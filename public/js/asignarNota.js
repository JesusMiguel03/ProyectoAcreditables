const botones = document.querySelectorAll(".notas")
const form = document.getElementById("asignarNota")
const estudianteSeleccionado = document.getElementById("estudianteSeleccionado")
const notasEstudiantes = document.querySelectorAll(".notaAsignadaEstudiante")
const botonEnviar = document.getElementById("formularioNotas")
const inputNota = document.getElementById("campoNotaEstudiante")

botones.forEach((boton, index) => {
    boton.addEventListener("click", (e) => {
        let CI = e.currentTarget.getAttribute("data-CI")
        let estudiante = e.currentTarget.getAttribute("data-estudiante")
        let ID = e.currentTarget.id

        inputNota.value = notasEstudiantes[index].innerText

        estudianteSeleccionado.innerText = `CI: (${CI}) ${estudiante}`
        form.action = `/estudiantes/${ID}/nota`
    })
})

botonEnviar.addEventListener("click", () => {
    form.submit()
})

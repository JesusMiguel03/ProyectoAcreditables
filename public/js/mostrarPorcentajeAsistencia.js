const [casillas, mostrarPorcentaje] = [
    document.querySelectorAll('[data-name]'),
    document.getElementById('contador')
]
let contador = 0

// Cambia el  color del contador, si esta aprovado o no
const colorContador = () => {
    if (Math.round(contador / 100) <= 74) {
        mostrarPorcentaje.classList.remove('text-success')
        mostrarPorcentaje.classList.add('text-danger')
    } else {
        mostrarPorcentaje.classList.remove('text-danger')
        mostrarPorcentaje.classList.add('text-success')
    }
}

// Coloca el % de asistencias
const porcentaje = () => {
    mostrarPorcentaje.innerText = `${Math.round(contador / 100)}%`
}

casillas.forEach(casilla => {
    // Establece el valor actual
    casilla.checked ? contador += 833 : ''

    // Cada vez que se cambie el estado de un checkbox se suma/resta del total
    casilla.addEventListener('change', (e) => {
        e.currentTarget.checked ? contador += 833 : contador -= 833
        porcentaje()

        colorContador()
    })
})

colorContador()
porcentaje()
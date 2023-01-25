/**
 *  Cambiar el color del texto de un elemento
 *
 *  @param {HTMLSmallElement} mensaje
 *  @param {string} color
 *  @returns void
 */
const cambiarColor = (mensaje, color) => {
    if (color === "verde") {
      mensaje.classList.remove("text-muted", "text-danger")
      mensaje.classList.add("text-success")
    } else {
      mensaje.classList.remove("text-success", "text-muted")
      mensaje.classList.add("text-danger")
    }
  }
  
  /**
   *  Inicializa variables
   */
  const [campos, contadores, btn] = [
    document.querySelectorAll("input, textarea"),
    [],
    document.querySelector(".btn-success"),
  ]
  
  /**
   *  Filtra solo los <input> que tendrán mensaje
   */
  campos.forEach((campo) => {
    campo.hasAttributes("maxlength", "minlength", "data-nombre") ? contadores.push(campo) : ""
  })
  
  /**
   *  Crea elementos <div> y <small>, le asigna sus clases y contenido
   */
  contadores.forEach((contador) => {
    const [cantidadCaracteres, tipoCampo, div, small] = [
      contador.getAttribute("maxlength") || contador.getAttribute("minlength"),
      contador.getAttribute("data-nombre"),
      document.createElement("div"),
      document.createElement("small"),
    ]
  
    let inicioContador = tipoCampo !== "caracteres" ? contador.value : contador.value.length
    inicioContador === "" ? (inicioContador = contador.value.length) : ""
  
    small.classList.add("ayuda", "text-muted")
    small.textContent = `${inicioContador} / ${cantidadCaracteres} ${tipoCampo}`
  
    div.classList.add("input-group")
    div.append(small)
    contador.parentNode.append(div)
  })
  
  /**
   *  Guarda todos los elementos <small> con clase
   */
  const textoAyuda = document.querySelectorAll(".ayuda")
  
  /**
   *  Actualiza en tiempo real la cantidad de caracteres
   */
  contadores.forEach((contador, i) => {
    let [cantidad, tipo] = [
      contador.getAttribute("maxlength") || contador.getAttribute("minlength"),
      contador.getAttribute("data-nombre"),
    ]
  
    contador.addEventListener("input", (e) => {
      let [el, valor] = [e.currentTarget, 0]
  
      const tipos = ["caracteres", "dígitos"]
  
      if (tipo === 'números') {
          e.currentTarget.value ? cambiarColor(textoAyuda[i], "rojo") : ''
      } else {
          e.currentTarget.value.length ? cambiarColor(textoAyuda[i], "verde") : ''
      }
  
      if (tipos.includes(tipo)) {
        valor = el.value.length
      } else {
        valor = el.value
        parseInt(valor) > parseInt(cantidad) ? ((valor = parseInt(cantidad)), (el.value = parseInt(cantidad))) : ""
      }
  
      textoAyuda[i].innerText = `${valor} / ${cantidad} ${tipo}`
    })
  })
  
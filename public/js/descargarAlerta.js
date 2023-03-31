const respaldos = document.querySelectorAll(".descargar");

// Botones de descarga
respaldos.forEach((respaldo) => {

  // Al 'decargar'
  respaldo.addEventListener("click", (e) => {
      Swal.fire({
          icon: "info",
          title: "¡Descarga en progreso!",
          html: "Se esta descargando la copia de seguridad en segundo plano",
          buttonsStyling: false,
          customClass: {
              confirmButton: "btn btn-info px-5",
          },
      });
  });
});

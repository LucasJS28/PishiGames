setTimeout(function() {
    var alerta = document.getElementById('alerta');
    if (alerta) {
        alerta.style.animation = 'aparecer 2s forwards'; // Ajusta la duración de la animación de aparición
        setTimeout(function() {
            alerta.style.animation = 'desaparecer 5s forwards'; // Ajusta la duración de la animación de desaparición
            setTimeout(function() {
                alerta.style.display = 'none';
            }, 5000); // Ajusta el tiempo de espera antes de ocultar el elemento
        }, 200); // Ajusta el tiempo de espera antes de iniciar la animación de desaparición
    }
}, 10000);

document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var juegos = document.getElementsByClassName('juego');

    for (var i = 0; i < juegos.length; i++) {
        var titulo = juegos[i].getElementsByClassName('titulo')[0].textContent.toLowerCase();
        var descripcion = juegos[i].getElementsByClassName('descripcion')[0].textContent.toLowerCase();

        if (titulo.includes(input) || descripcion.includes(input)) {
            juegos[i].style.display = 'block';
        } else {
            juegos[i].style.display = 'none';
        }
    }
});


/* Ajax tienda.php */

// Manejador de evento clic para los botones "Agregar al Carrito"
var agregarCarritoButtons = document.getElementsByClassName('agregar-carrito');
for (var i = 0; i < agregarCarritoButtons.length; i++) {
    agregarCarritoButtons[i].addEventListener('click', function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario

        var idJuego = this.getAttribute('data-id');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Actualizar la interfaz de usuario si es necesario
                var response = xhr.responseText;
                var alertaDiv = document.getElementById('alerta');

                if (response === "<div id='alerta' class='AlertaBuena'>Se añadió una nueva copia al Carro</div>") {
                    // Mostrar mensaje de éxito
                    alertaDiv.innerHTML = "Se añadió una nueva copia al Carro";
                    alertaDiv.className = "AlertaBuena";
                } else if (response === "<div id='alerta' class='AlertaBuena'>Se añadió al Carrito</div>") {
                    // Mostrar otro mensaje de éxito
                    alertaDiv.innerHTML = "Se añadió al Carrito";
                    alertaDiv.className = "AlertaBuena";
                } else {
                    // Mostrar mensaje de error u otra respuesta desconocida
                    alertaDiv.innerHTML = response;
                    alertaDiv.className = "AlertaError";
                }
            }
        };
        xhr.send('agregarCarrito=true&idJuego=' + idJuego);
    });
}


/* script para eliminar -1 de stock cuando se presiona agregar al carro */

var botonesAgregarCarrito = document.getElementsByClassName("agregar-carrito");

  // Recorrer cada botón y agregar el evento de clic
  for (var i = 0; i < botonesAgregarCarrito.length; i++) {
    botonesAgregarCarrito[i].addEventListener("click", function() {
      // Obtener el elemento <p> del stock correspondiente al botón presionado
      var stockSeleccionado = this.parentNode.querySelector(".stock");
      // Obtener el valor actual del stock
      var stock = parseInt(stockSeleccionado.innerText.split(" ")[1]);
      // Verificar si hay suficiente stock para restar 1
      if (stock >= 1) {
        // Restar 1 al stock
        stock--;
        // Actualizar el contenido del elemento <p> con el nuevo stock
        stockSeleccionado.innerText = "Stock: " + stock;
      }
    });
  }

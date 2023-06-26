
//Animaciones para las alertas de errores o mensajes exitosos
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

//Funcion para el input de buscar
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var juegos = document.getElementsByClassName('juego');

    for (var i = 0; i < juegos.length; i++) {
        var titulo = juegos[i].getElementsByClassName('titulo')[0].textContent.toLowerCase();
        if (titulo.includes(input)) {
            juegos[i].style.display = 'block';
        } else {
            juegos[i].style.display = 'none';
        }
    }
});


//Funcion para el input de buscar por correo en el PanelAdministrador
document.getElementById('buscar').addEventListener('input', function() {
    var input = this.value.toLowerCase();
    var usuarios = document.getElementsByClassName('usuario');
    for (var i = 0; i < usuarios.length; i++) {
        var correo = usuarios[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        if (correo.includes(input)) {
            usuarios[i].style.display = 'table-row';
        } else {
            usuarios[i].style.display = 'none';
        }
    }
});

/* Ajax tienda.php */

// Manejador de evento clic para los botones "Agregar al Carrito"
var agregarCarritoButtons = document.getElementsByClassName('agregar-carrito');

// Recorrer todos los elementos obtenidos
for (var i = 0; i < agregarCarritoButtons.length; i++) {
    // Agregar un event listener para el evento 'click'
    agregarCarritoButtons[i].addEventListener('click', function(event) {
        event.preventDefault(); // Evitar que se envíe el formulario

        // Obtener el ID del juego desde el atributo 'data-id'
        var idJuego = this.getAttribute('data-id');

        // Crear una nueva solicitud XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Configurar la solicitud
        xhr.open('POST', '', true); // Realizar una solicitud POST al mismo documento actual
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Establecer la cabecera 'Content-Type'

        // Definir la función de retorno de llamada cuando cambie el estado de la solicitud
        xhr.onreadystatechange = function() {
        /* xhr.readyState === 4 verifica si el estado de la solicitud es 4, lo cual significa que la solicitud ha sido completada.
            xhr.status === 200 verifica si el estado de la respuesta del servidor es 200, lo cual indica que la solicitud se ha realizado 
            correctamente y sin errores. El código de estado 200 en HTTP significa "OK" y se utiliza para indicar una respuesta exitosa del servidor. */
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Procesar la respuesta recibida del servidor
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
        // Enviar la solicitud al servidor con los datos necesarios
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


// PanelJefe.php
// Funcion para mostrar los datos en el formulario por defecto
  function fillForms() {
    var select = document.getElementById('juego');
    var selectedOption = select.options[select.selectedIndex];
    var stockAnteriorInput = document.getElementById('stock_anterior');
    var precioAnteriorInput = document.getElementById('precio_anterior');
    var imagenJuego = document.getElementById('imagen_juego');

    stockAnteriorInput.value = selectedOption.dataset.stock;
    precioAnteriorInput.value = selectedOption.dataset.precio;
    imagenJuego.src = selectedOption.dataset.imagen;
    imagenJuego.removeAttribute('hidden');
}

// Llenar los formularios al cargar la página con el primer juego
window.addEventListener('load', function() {
    fillForms();
});

//Esta funcion es para el eliminar pedidos en el panel revisarPedidos.php
//añade una ventana emergente que pregunta si esta seguro o no de elimianr el producto y devuelve true o false
function confirmarEliminacion(idPedido) {
    var respuesta = confirm("¿Estás seguro de que deseas cancelar este pedido?");
    if (respuesta) {
        document.getElementById("confirmacion_" + idPedido).value = "si";
        return true;
    } else {
        return false;
    }
}

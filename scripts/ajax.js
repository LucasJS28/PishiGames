/* Este Documento JS busca poder juntar todo el Codigo AJAX para mayor entendimiento */

/* Funciones AJAX para revisarPedidos.php */
function actualizarEstadoPedido(idPedido, estado) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "revisarPedidos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            alert("Pedido Actualizado con Exito");
            console.log(xhr.responseText);
        }
    };
    xhr.send("idPedido=" + encodeURIComponent(idPedido) + "&estado=" + encodeURIComponent(estado));
}

function eliminarPedido(idPedido) {
    var confirmacion = confirm("¿Estás seguro de que deseas cancelar este pedido?");
    if (confirmacion) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "revisarPedidos.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                alert("Producto Eliminado con Éxito");
                console.log(xhr.responseText);
                // Eliminar la fila del pedido de la tabla sin recargar la página
                var fila = document.getElementById("fila-" + idPedido); //Elimina el tr con el ID que se genera con cada una de las tablas
                if (fila) {
                    fila.parentNode.removeChild(fila);
                }
            }
        };
        xhr.send("idPedidoCancelar=" + encodeURIComponent(idPedido) + "&confirmacion_" + idPedido + "=si");
    }
}

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
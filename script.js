// Función para cargar los mensajes desde el servidor
function cargarMensajes() {
    // Realizar una solicitud AJAX para obtener los mensajes
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'obtener_mensajes.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            // Parsear la respuesta JSON del servidor
            const mensajes = JSON.parse(xhr.responseText);

            // Mostrar los mensajes en la interfaz de usuario
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.innerHTML = '';

            mensajes.forEach(function (mensaje) {
                const div = document.createElement('div');
                div.className = 'mensaje';
                div.textContent = mensaje.mensaje;
                chatMessages.appendChild(div);
            });

            // Desplazarse hacia abajo para mostrar los últimos mensajes
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    };

    xhr.send();
}

// Llamar a la función cargarMensajes cada 2 segundos (o el intervalo que desees)
setInterval(cargarMensajes, 2000);

// Manejar el envío de mensajes desde el cliente
const enviarBtn = document.getElementById('enviar');
enviarBtn.addEventListener('click', function () {
    const mensajeInput = document.getElementById('mensaje');
    const mensaje = mensajeInput.value.trim();

    if (mensaje !== '') {
        // Realizar una solicitud AJAX para enviar el mensaje al servidor
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar_mensaje.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Limpiar el campo de entrada después de enviar el mensaje
                mensajeInput.value = '';
            }
        };

        // Enviar el mensaje al servidor
        xhr.send('mensaje=' + encodeURIComponent(mensaje));
    }
});

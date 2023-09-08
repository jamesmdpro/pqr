<?php
// Conexión a la base de datos (reemplaza 'localhost', 'usuario', 'contraseña' y 'basededatos' con tus propias credenciales)
$conexion = mysqli_connect('localhost', 'usuario', 'contraseña', 'basededatos');

// Verifica la conexión
if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Función para guardar un mensaje en la base de datos
function guardarMensaje($codigoUsuario, $mensaje) {
    global $conexion;
    
    $sql = "INSERT INTO mensajes (codigo_usuario, mensaje) VALUES ('$codigoUsuario', '$mensaje')";
    
    if (mysqli_query($conexion, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Función para obtener los mensajes de la base de datos
function obtenerMensajes() {
    global $conexion;
    
    $sql = "SELECT * FROM mensajes ORDER BY fecha_envio ASC";
    $result = mysqli_query($conexion, $sql);
    
    $mensajes = [];
    
    if ($result) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $mensajes[] = $fila;
        }
    }
    
    return $mensajes;
}

// Recibe una solicitud AJAX para guardar un mensaje
if (isset($_POST['codigoUsuario']) && isset($_POST['mensaje'])) {
    $codigoUsuario = $_POST['codigoUsuario'];
    $mensaje = $_POST['mensaje'];
    
    if (guardarMensaje($codigoUsuario, $mensaje)) {
        echo "Mensaje guardado correctamente";
    } else {
        echo "Error al guardar el mensaje";
    }
}

// Recibe una solicitud AJAX para obtener los mensajes
if (isset($_GET['obtenerMensajes'])) {
    $mensajes = obtenerMensajes();
    
    header('Content-Type: application/json');
    echo json_encode($mensajes);
}

// Cierra la conexión a la base de datos al finalizar el script
mysqli_close($conexion);
?>

<?php
// Configuración de la conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "enviar_db";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

// Verificar si el email ya existe en la base de datos
$consulta = $conexion->prepare("SELECT * FROM formulario WHERE email = ?");
$consulta->bind_param("s", $email);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {
    echo "Este email ya ha sido registrado. Por favor, usa otro email o actualiza el mensaje.";
} else {
    // Insertar los datos si el email no existe
    $stmt = $conexion->prepare("INSERT INTO formulario (nombre, email, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    if ($stmt->execute()) {
        echo "Formulario enviado correctamente!";
        // Redirigir después de 2 segundos
        header("Refresh: 2; URL=videojuegos.html"); 
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$consulta->close();
$conexion->close();
?>

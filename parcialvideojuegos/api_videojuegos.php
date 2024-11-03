<?php
header('Content-Type: application/json'); // El contenido lo devuelve en JSON
$host = "localhost";
$user = "root"; // Usuario predeterminado de XAMPP
$pass = "";     // Contraseña vacía por defecto en XAMPP
$dbname = "juegosDB"; 
// Conexion a la base de datos
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar los datos de la tabla `juegos`
$sql = "SELECT titulo, descripcion, imagen_url, plataformas, lanzamiento FROM juegos";
$result = $conn->query($sql);

$juegos = [];
if ($result->num_rows > 0) {
    // Convertir cada fila de resultados en un arreglo asociativo y añadirlo al arreglo `$juegos`
    while ($row = $result->fetch_assoc()) {
        $juegos[] = $row;
    }
}

// Convertir el arreglo `$juegos` a JSON y devolverlo como respuesta
echo json_encode($juegos);

// Cerrar la conexion
$conn->close();
?>

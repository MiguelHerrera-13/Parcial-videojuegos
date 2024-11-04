<?php
header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "juegosDB";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres y el idioma de la conexión
$conn->set_charset("utf8mb4");
$conn->query("SET lc_time_names = 'es_ES'");

// Verificar si hay un parámetro de sección en la URL
$seccion = isset($_GET['seccion']) ? $_GET['seccion'] : '';

// Usar DATE_FORMAT para formatear la fecha de lanzamiento en español
if ($seccion) {
    $stmt = $conn->prepare("SELECT titulo, descripcion, imagen_url, plataformas, DATE_FORMAT(lanzamiento, '%d %M %Y') AS lanzamiento FROM juegos WHERE seccion = ?");
    $stmt->bind_param("s", $seccion);
} else {
    $stmt = $conn->prepare("SELECT titulo, descripcion, imagen_url, plataformas, DATE_FORMAT(lanzamiento, '%d %M %Y') AS lanzamiento FROM juegos");
}

$stmt->execute();
$result = $stmt->get_result();

$juegos = [];
while ($row = $result->fetch_assoc()) {
    $juegos[] = $row;
}

echo json_encode($juegos);
$stmt->close();
$conn->close();
?>

<?php
$conn = new mysqli('localhost', 'root', '', 'diplomas');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $conn->query("INSERT INTO directores (nombre) VALUES ('$nombre')");
    echo "Directores agregado correctamente.";
}
?>

<form method="POST">
    <label>Nombre del Director:</label>
    <input type="text" name="nombre" required>
    <input type="submit" value="Agregar">
</form>
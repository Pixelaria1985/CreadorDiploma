<?php
$conn = new mysqli('localhost', 'root', '', 'diplomas');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $conn->query("INSERT INTO alumnos (nombre) VALUES ('$nombre')");
    echo "Alumno agregado correctamente.";
}
?>

<form method="POST">
    <label>Nombre del Alumno:</label>
    <input type="text" name="nombre" required>
    <input type="submit" value="Agregar">
</form>

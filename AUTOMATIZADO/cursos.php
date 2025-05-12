<?php
$conn = new mysqli('localhost', 'root', '', 'diplomas');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $conn->query("INSERT INTO cursos (nombre) VALUES ('$nombre')");
    echo "Curso agregado correctamente.";
}
?>

<form method="POST">
    <label>Nombre del Curso:</label>
    <input type="text" name="nombre" required>
    <input type="submit" value="Agregar">
</form>
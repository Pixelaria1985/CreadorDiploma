<?php
$conn = new mysqli('localhost', 'root', '', 'diplomas');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alumno_id = intval($_POST['alumno_id']);
    $curso_id = intval($_POST['curso_id']);
    $docente_id = intval($_POST['docente_id']);
    $director_id = intval($_POST['director_id']);
    $fecha_finalizacion = $_POST['fecha_finalizacion'];  // Obtener la fecha de finalización

    // Insertar los datos en la base de datos, incluyendo la fecha de finalización
    $stmt = $conn->prepare("
        INSERT INTO certificados (alumno_id, curso_id, docente_id, director_id, fecha_finalizacion)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iiiss", $alumno_id, $curso_id, $docente_id, $director_id, $fecha_finalizacion);
    $stmt->execute();

    echo "<p style='color: green;'>✅ Certificado registrado correctamente.</p>";
}

// Obtener datos para los selects
$alumnos = $conn->query("SELECT id, nombre FROM alumnos");
$cursos = $conn->query("SELECT id, nombre FROM cursos");
$docentes = $conn->query("SELECT id, nombre FROM docentes");
$directores = $conn->query("SELECT id, nombre FROM directores");
?>

<h2>Generar nuevo certificado</h2>
<form method="POST">
    <label>Alumno:</label><br>
    <select name="alumno_id" required>
        <option value="">-- Seleccione un alumno --</option>
        <?php while($a = $alumnos->fetch_assoc()): ?>
            <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nombre']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="curso_id" required>
        <option value="">-- Seleccione un curso --</option>
        <?php while($c = $cursos->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Docente (Instructor):</label><br>
    <select name="docente_id" required>
        <option value="">-- Seleccione un docente --</option>
        <?php while($d = $docentes->fetch_assoc()): ?>
            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nombre']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Director:</label><br>
    <select name="director_id" required>
        <option value="">-- Seleccione un director --</option>
        <?php while($di = $directores->fetch_assoc()): ?>
            <option value="<?= $di['id'] ?>"><?= htmlspecialchars($di['nombre']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Fecha de finalización:</label><br>
    <input type="date" name="fecha_finalizacion" required><br><br>

    <input type="submit" value="Generar certificado">
</form>

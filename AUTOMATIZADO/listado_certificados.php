<?php
$conn = new mysqli('localhost', 'root', '', 'diplomas');

$query = "
SELECT 
    certificados.id,
    alumnos.nombre AS alumno,
    cursos.nombre AS curso,
    docentes.nombre AS docente,
    docentes.titulo AS titulo_docente,
    directores.nombre AS director,
    directores.titulo AS titulo_director,
    certificados.fecha
FROM certificados
JOIN alumnos ON certificados.alumno_id = alumnos.id
JOIN cursos ON certificados.curso_id = cursos.id
JOIN docentes ON certificados.docente_id = docentes.id
JOIN directores ON certificados.director_id = directores.id
ORDER BY certificados.fecha DESC
";

$result = $conn->query($query);
?>

<h2>Listado de Certificados Generados</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Alumno</th>
        <th>Curso</th>
        <th>Docente</th>
        <th>Director</th>
        <th>Fecha</th>
        <th>PDF</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['alumno']) ?></td>
            <td><?= htmlspecialchars($row['curso']) ?></td>
            <td><?= htmlspecialchars($row['docente']) ?> (<?= $row['titulo_docente'] ?>)</td>
            <td><?= htmlspecialchars($row['director']) ?> (<?= $row['titulo_director'] ?>)</td>
            <td><?= $row['fecha'] ?></td>
            <td><a href="crear_pdf.php?id=<?= $row['id'] ?>" target="_blank">🖨️ Imprimir PDF</a></td>
        </tr>
    <?php endwhile; ?>
</table>

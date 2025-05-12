<?php
require 'fpdf/fpdf.php';

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'diplomas');

if (!isset($_GET['id'])) {
    die('ID de certificado no especificado');
}

function traducirFecha($fecha) {
    $meses = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre',
    ];

    $timestamp = strtotime($fecha);
    $dia = date('j', $timestamp);
    $mes_en = date('F', $timestamp);
    $anio = date('Y', $timestamp);

    $mes_es = $meses[$mes_en];

    return "$dia de $mes_es de $anio";
}

$id = intval($_GET['id']);

// Consulta para obtener los datos del certificado, incluyendo la fecha de finalización
$query = "
SELECT 
    alumnos.nombre AS alumno,
    cursos.nombre AS curso,
    docentes.nombre AS docente,
    docentes.titulo AS titulo_docente,
    directores.nombre AS director,
    directores.titulo AS titulo_director,
    certificados.fecha_finalizacion
FROM certificados
JOIN alumnos ON certificados.alumno_id = alumnos.id
JOIN cursos ON certificados.curso_id = cursos.id
JOIN docentes ON certificados.docente_id = docentes.id
JOIN directores ON certificados.director_id = directores.id
WHERE certificados.id = $id
";

$result = $conn->query($query);

if ($result->num_rows === 0) {
    die('Certificado no encontrado');
}

$data = $result->fetch_assoc();

// Función para simplificar la escritura centrada
function setText($pdf, $texto, $longitud, $x, $y)
{
    $pdf->SetXY($x, $y);
    $pdf->Cell($longitud, 5, $texto, 0, 1, 'C');
}

// Crear el PDF
$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetCreator('Sistema de Certificados');

// Fondo del certificado
$pdf->Image('images/certificado.png', 0, 0, 280, 220);

// Nombre del alumno
$pdf->SetFont('Arial', 'B', 22);
$pdf->SetXY(65, 90);
$pdf->Cell(160, 5, utf8_decode(strtoupper($data['alumno'])), 0, 1, 'C');

// Nombre del curso
$pdf->SetFont('Arial', 'B', 24);
setText($pdf, utf8_decode(strtoupper($data['curso'])), 160, 65, 120);

// Nombre del docente (instructor)
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, utf8_decode($data['docente']), 70, 30, 145);
setText($pdf, utf8_decode($data['titulo_docente']), 70, 30, 160); // Título del instructor

// Nombre del director
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, utf8_decode($data['director']), 70, 180, 145);
setText($pdf, utf8_decode($data['titulo_director']), 70, 180, 160); // Título del director

// FECHA DE FINALIZACIÓN del curso
$pdf->SetFont('Arial', 'B', 15);

// Convertir la fecha de finalización a formato "12 de Mayo de 2025"
setlocale(LC_TIME, 'es_ES.UTF-8'); // Configurar el idioma a español
$fecha_finalizacion = strftime('%e de %B de %Y', strtotime($data['fecha_finalizacion'])); // Formato "12 de Mayo de 2025"
$pdf->SetXY(65, 180); 
$pdf->Cell(160, 5, traducirFecha($data['fecha_finalizacion']), 0, 1, 'C');

// Mostrar el PDF
$pdf->Output();
?>

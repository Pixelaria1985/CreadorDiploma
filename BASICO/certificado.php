<?php

require 'fpdf/fpdf.php';

function setText($pdf, $texto, $longitud, $x, $y)
{
    $pdf->SetXY($x, $y); //Posicion del texto
    $pdf->Cell($longitud, 5, $texto, 0, 1, 'C');
}

$pdf = new FPDF('L', 'mm', 'Letter'); //L = horizonta P = vertical - mm (en que vamos a trabajar) - tamaño de hoja
$pdf->AddPage(); //Se agrega la pagina
$pdf->SetFont('Arial', 'B', 16); //Tipo de fuente - B = Bold podria ser Italic o lo que sea - Tamaño de fuente
$pdf->SetCreator('Sebastian Giancaspro'); //Autor

//Tamaño del certificado
$pdf->Image('images/certificado.png', 0, 0, 280, 220); //ruta del certificado - posicion X =0 - posicion Y=0 - ancho en mm - alto en mm

//Nombre del alumno sin usar funciones todo a mano
$pdf->SetFont('Arial', 'B', 22);
$pdf->SetXY(65, 90); //Posicion del texto
$pdf->Cell(160, 5, "Juan Perez", 0, 1, 'C'); //Long de la celda - alto - texto que va ir - borde - salto de linea - alineacion

//Nombre del CURSO usando la funcion "setText"
$pdf->SetFont('Arial', 'B', 24);
setText($pdf, "PROGRAMACION BASICA", 160, 65, 120);

//Nombre del INSTRUCTOR usando la funcion "setText"
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, "Mario Crippa", 70, 30, 145);

//Titulo del INSTRUCTOR usando la funcion "setText"
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, "Instructor", 70, 30, 160);

//Nombre del DIRECTOR usando la funcion "setText"
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, "Sebastian Giancaspro", 70, 180, 145);

//Titulo del DIRECTOR usando la funcion "setText"
$pdf->SetFont('Arial', 'B', 18);
setText($pdf, "Director", 70, 180, 160);


$pdf->Output();

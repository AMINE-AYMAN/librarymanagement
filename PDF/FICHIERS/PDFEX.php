<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("select l.titreLiv,ex.codeBar,ed.anneeEdi
from livre l,exemplaire ex,edition ed
where l.ISBN=ex.ISBN
and ex.codeEdi=ed.codeEdi;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Titre livre","Code-barres","Edition");

$pdf = new FPDF('P','mm',array(245,375));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(120,20,'Listes des exemplaires',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',205  ,6,30);
		
    
foreach($width_cell as $heading) {
        $pdf->Cell(75,12,$heading,1,0,'C');
}

foreach($data as $row) {
	$pdf->SetFont('arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(75,20,$column,1,0,'C');
}
$pdf->Output();
?>
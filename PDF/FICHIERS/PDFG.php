<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("SELECT CBGest,nomG,prenomG,cinG,telephoneG,dateinscripG FROM gestionnaire");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Code-barres","Nom","Prenom","CIN","Telephone","Date inscript");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(80,20,'Listes des gestionnaires',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',170,6,30);
		
    
foreach($width_cell as $heading) {
        $pdf->Cell(32,12,$heading,1,0,'C');
}

foreach($data as $row) {
	$pdf->SetFont('arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(32,20,$column,1,0,'C');
}
$pdf->Output();
?>
<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("select et.nomEtu,et.prenomEtu,et.CNE,et.CNI,f.libelleFi
from etudiant et,filiere f
where et.codeFi = f.codeFi;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Nom étudiant","Prénom étudiant","CNE","CNI","Filière");

$pdf = new FPDF('P','mm',array(300,400));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(160,25,'Listes des étudiants',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',255,6,30);
		
    
foreach($width_cell as $heading) {
        $pdf->Cell(55,12,$heading,1,0,'C');
}

foreach($data as $row) {
	$pdf->SetFont('arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(55,20,$column,1,0,'C');
}
$pdf->Output();
?>
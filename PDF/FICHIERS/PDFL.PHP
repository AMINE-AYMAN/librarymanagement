<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("select l.titreLiv,d.libelleDis,a.nomAut,a.prenomAut,l.coteL,l.type,l.description
from livre l,auteur a,rediger r,discipline d
where l.codeDis=d.codeDis
and r.ISBN=l.ISBN
and a.codeAut = r.codeAut;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Titre livre","Discipline","Nom auteur","Prenom auteur","Cote","Type","Description");

$pdf = new FPDF('P','mm',array(620,550));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(410,20,'Listes des livres',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',500,6,30);
		
    
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
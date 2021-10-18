<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("select etudiant.nomEtu,etudiant.prenomEtu,filiere.libelleFi, 
punition.libellePun,livre.titreLiv,emprunt.codeBar,emprunt.dateDebut,emprunt.dateFin
from etudiant,filiere,punition,punir,emprunt,livre,exemplaire
WHERE etudiant.codeFi=filiere.codeFi
and punition.codePun=punir.codePun
and punir.CNE=etudiant.CNE
and punir.codeEmprunt=emprunt.codeEmprunt
and livre.ISBN=exemplaire.ISBN
and exemplaire.codeBar=emprunt.codeBar;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Nom étudiant","Prénom étudiant","Filière","Punition","Livre","exemplaire","Date début","Date fin");

$pdf = new FPDF('P','mm',array(550,550));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(400,20,'Listes des punitions',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',495  ,6,30);
		
    
foreach($width_cell as $heading) {
        $pdf->Cell(65,12,$heading,1,0,'C');
}

foreach($data as $row) {
	$pdf->SetFont('arial','',12);	
	$pdf->Ln();
	foreach($row as $column)
		$pdf->Cell(65,20,$column,1,0,'C');
}
$pdf->Output();
?>
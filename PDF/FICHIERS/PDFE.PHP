<?php
require_once('../fpdf.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("select e.codeEmprunt,l.titreLiv,d.libelleDis,et.nomEtu,et.prenomEtu,et.CNI,e.dateDebut,e.dateFin
from emprunt e,livre l,exemplaire ex,etudiant et,discipline d
where l.ISBN=ex.ISBN
and d.codeDis=l.codeDis
and ex.codeBar = e.codeBar 
and	e.CNE=et.CNE
and e.etat = 1
order by e.codeEmprunt ;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    

$width_cell=array("Code emprunt","Titre livre","Discipline","Nom etd","Prenom etd","CNI","Date debut","Date fin");

$pdf = new FPDF('P','mm',array(545,600));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
    // Logo
    $pdf->Image('../../Images/log.jpg',10,6,30);
    // Arial bold 15
    // Move to the right
    $pdf->Cell(57);
    // Title
    $pdf->Cell(405,25,'Listes des emprunts',1,10,'C');
    // Line break
    $pdf->Ln(20);
    $pdf->Image('../../Images/log.jpg',500,6,30);
		
    
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
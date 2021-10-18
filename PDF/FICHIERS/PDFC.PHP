<?php
require_once('../fpdf.php');
require_once('PDF_Label.php');
require_once("../../functions.php");
$pdo = pdo_connect_mysql();
$result = $pdo->prepare("
select etudiant.CNE,etudiant.nomEtu,etudiant.prenomEtu,etudiant.CBR,filiere.libelleFi
from etudiant,filiere
WHERE etudiant.codeFi=filiere.codeFi;
	 ;");
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
    
$pdf = new PDF_Label('L7163');

$pdf->AddPage();

// Print labels
for($i=1;$i<=1;$i++) {
    $pdf->Cell(100,24,"lol",1,0,'C');
    $text = sprintf("%s\n%s\n%s\n%s %s, %s", "Laurent $i", 'Immeuble Toto', 'av. Fragonard', '06000', 'NICE', 'FRANCE');
    $pdf->Cell(55,12,$text,1,0,'C');
    
}

$pdf->Output();

?>



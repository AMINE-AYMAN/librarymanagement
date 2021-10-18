<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

$stmt1 = $pdo->prepare('select etudiant.nomEtu,etudiant.prenomEtu,filiere.libelleFi, 
punition.libellePun,livre.titreLiv,emprunt.codeBar,emprunt.dateDebut,emprunt.dateFin
from etudiant,filiere,punition,punir,emprunt,livre,exemplaire
WHERE etudiant.codeFi=filiere.codeFi
and punition.codePun=punir.codePun
and punir.CNE=etudiant.CNE
and punir.codeEmprunt=emprunt.codeEmprunt
and livre.ISBN=exemplaire.ISBN
and exemplaire.codeBar=emprunt.codeBar;');
$stmt1 -> execute();
$emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//Check the export button is pressed or not
if(isset($_POST["excelPi"])) {
//Define the filename with current date
$fileName = "Punitions-".date('d-m-Y').".xls";

//Set header information to export data in excel format
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$fileName);

//Set variable to false for heading
$heading = false;

//Add the MySQL table data to excel file
if(!empty($emprunts1)) {
foreach($emprunts1 as $emprunts) {
if(!$heading) {
echo implode("\t", array_keys($emprunts)) . "\n";
$heading = true;
}
echo implode("\t", array_values($emprunts)) . "\n";
}
}
exit();
}

?>
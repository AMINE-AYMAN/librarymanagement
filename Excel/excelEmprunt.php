<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

$stmt1 = $pdo->prepare('select  e.codeEmprunt,e.dateDebut,e.dateFin,l.titreLiv,et.CNI,et.nomEtu,et.prenomEtu,d.libelleDis
from emprunt e,livre l,exemplaire ex,etudiant et,discipline d
where l.ISBN=ex.ISBN
and d.codeDis=l.codeDis
and ex.codeBar = e.codeBar 
and	e.CNE=et.CNE
and e.Etat = 1
order by e.codeEmprunt desc;');
$stmt1 -> execute();
$emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//Check the export button is pressed or not
if(isset($_POST["excelEmp"])) {
//Define the filename with current date
$fileName = "Emprunts-".date('d-m-Y').".xls";

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
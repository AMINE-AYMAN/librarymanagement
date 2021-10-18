<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

$stmt1 = $pdo->prepare('SELECT l.ISBN,l.titreLiv,a.nomAut,a.prenomAut,d.libelleDis,l.nbExemplaire,l.coteL,l.type,l.description 
FROM auteur a, rediger r, livre l,discipline d  
  WHERE a.codeAut=r.codeAut
  and r.ISBN=l.ISBN
  and d.codeDis=l.codeDis
  order by l.ISBN');
$stmt1 -> execute();
$emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//Check the export button is pressed or not
if(isset($_POST["excelLi"])) {
//Define the filename with current date
$fileName = "Livres-".date('d-m-Y').".xls";

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
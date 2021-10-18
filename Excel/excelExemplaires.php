<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

$stmt1 = $pdo->prepare('select e.codeBar,e.ISBN,l.titreLiv,ed.anneeEdi,e.etatEx
from exemplaire e,livre l,edition ed
where e.ISBN=l.ISBN
and e.codeEdi = ed.codeEdi
  order by e.codeBar');
$stmt1 -> execute();
$emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//Check the export button is pressed or not
if(isset($_POST["excelEx"])) {
//Define the filename with current date
$fileName = "Exemplaires-".date('d-m-Y').".xls";

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
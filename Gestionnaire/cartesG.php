<?php
//delete.php
include '../functions.php';
require_once('PDF_Label.php');
$pdo = pdo_connect_mysql();
if(isset($_POST["id"]))
{
 echo $_POST["id"];}

?>

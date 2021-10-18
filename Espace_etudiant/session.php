<?php
include("bd.php");
session_start();
$cne_check=$_SESSION["CNE"];
$sql=mysqli_query($conn, "select * from etudiant,filiere WHERE 
                          filiere.codeFi=etudiant.codeFi and etudiant.CNE='$cne_check'");
$row=mysqli_fetch_array($sql, MYSQLI_ASSOC);
$_SESSION["Nom"]=$row["nomEtu"];
$_SESSION["Pre"]=$row['prenomEtu'];
$_SESSION["fil"]=$row['libelleFi'];
$_SESSION['last_login'] = time();
if(!isset($_SESSION["CNE"])){
    header("location:connexion.php");
    exit();
}else{
    if((time() - $_SESSION['last_login'])>10)
    {
        header("location:logout.php");
    }
}
?>

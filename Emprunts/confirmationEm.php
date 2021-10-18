<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

global $vale;
$stmt2 = $pdo->prepare('select CBGest from gestionnaire where nomG = ? and prenomG = ?');
$stmt2 -> execute([$_SESSION['nom'],$_SESSION['prenom']]);
$gest = $stmt2->fetchAll(PDO::FETCH_ASSOC);
foreach($gest as $g){
    $value = $g['CBGest'];
}

if (isset($_GET['codeEmprunt'])) {
    $stmt = $pdo->prepare('SELECT * FROM emprunt WHERE codeEmprunt = ?');
    $stmt->execute([$_GET['codeEmprunt']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('emprunt nexites pas');
    }
    if(isset($_POST['exemp'])){
    $exemp = $_POST['exemp'];
    $stmt = $pdo->prepare('update emprunt
    set Etat = 1
    ,codeBar = ?
    ,CBGest = ?
    WHERE codeEmprunt = ?');
    $stmt->execute([$exemp,$value,$_GET['codeEmprunt']]);        
    }
}
?>


<?php
require_once('../functions.php');
$pdo = pdo_connect_mysql();
$msg='';

if (!empty($_GET)) { 
    $codeb = $_POST['codeb'] ;
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $stmt0 = $pdo->prepare('SELECT * FROM gestionnaire ');
        $stmt0->execute();
        $codeA = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        foreach($codeA as $code){
            if($codeb === $code['CBGest']){
                $msg = '';
                $stmt1 = $pdo->prepare('SELECT * FROM gestionnaire where CBGest = ? ');
                    $stmt1->execute([$codeb]);
                    $session = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($session as $ses){
                        $_SESSION["code"]=$ses['CBGest'];
                        $_SESSION["nom"]=$ses['nomG'];
                        $_SESSION["prenom"]=$ses['prenomG'];
                    }
               header('Location:../Statistiques/indexS.php');
            }
            else{
                $msg='Code-barres invalide ';
            }
        }
}
?>
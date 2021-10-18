<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
global $val1;
// Check if POST data is not empty
if (isset($_GET['codeBar'])) {
if (!empty($_POST)) { 
    $cb = $_POST['cb'];
    $isbn = $_POST['isbn'];
    $annee = $_POST['annee'];
    $inv = $_POST['inv'];

    $statement2 = $pdo->prepare('SELECT * FROM edition WHERE anneeEdi LIKE :title');
    $statement2->bindValue(':title',$annee);
    $statement2->execute();
    $codeD = $statement2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($codeD as $discipline){
    $val1 = $discipline['codeEdi'];
    }

    $stmt = $pdo->prepare('UPDATE exemplaire
        SET codeBar = ?,etatEx = 1, ISBN = ?, codeEdi = ?,inv=?
        WHERE codeBar = ?');
        $stmt->execute([ $cb, $isbn, $val1,$inv,$_GET['codeBar']]);
        $msg = 'Modifié avec succès !';
        header('Location: indexE.php');
}
    $stmt = $pdo->prepare('SELECT e.* , ed.anneeEdi FROM exemplaire e,edition ed  
    WHERE e.codeEdi=ed.codeEdi
    and   e.codeBar = ?');
    $stmt->execute([$_GET['codeBar']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Gestionnaire nexistes pas');
    }
} 
?>

<?=template_header('Read')?>

<div class="content update">
	<h2 style="color: black;">Modifier exemplaire : </h2>
    <form action="updateE.php?codeBar=<?=$contact['codeBar']?>" method="post">
        <div class="wrap">
            <label for="id">Code-barres</label>
            <input type="text" name="cb" placeholder="1234567" value="<?=$contact['codeBar']?>"  id="cb">
            <label for="id">ISBN</label>
            <input type="text" name="isbn" placeholder="987123512" value="<?=$contact['ISBN']?>" id="isbn">
            <label for="name">Année edition</label>
            <input type="text" name="annee" placeholder="2000" value="<?=$contact['anneeEdi']?>" id="anne">
            <label for="name">Inv</label>
            <input type="text" name="inv" placeholder="2000" value="<?=$contact['inv']?>" id="anne">
            <input type="submit" value="Modifier" class="crt" style="letter-spacing: 1px;width:40%"> 
        </div>
    </form>
</div>

<?=template_footer()?>
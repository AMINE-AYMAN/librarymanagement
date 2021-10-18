<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
// Check if POST data is not empty
global $val1;

if (!empty($_POST)) {
    $cb = $_POST['cb'];
    $isbn = $_POST['isbn'];
    $annee = $_POST['edition'];
    $inv = $_POST['inv'];
    $stmt = $pdo->prepare('INSERT INTO edition VALUES (DEFAULT,?)');
    $stmt->execute([$annee]);
    $statement2 = $pdo->prepare('SELECT * FROM edition WHERE anneeEdi LIKE :title');
    $statement2->bindValue(':title',$annee);
    $statement2->execute();
    $codeD = $statement2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($codeD as $discipline){
    $val1 = $discipline['codeEdi'];
    }
    $stmt3 = $pdo->prepare('INSERT INTO exemplaire VALUES ( ?, ?, ?, ?,?)');
    $stmt3->execute([$cb,1,$isbn,$val1,$inv]);
    header("Location:indexE.php");
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2 style="color: black;">Ajouter exemplaire : </h2>
    <form action="createE.php" method="post">
        <div class="wrap">
            <label for="id">Code-barres</label>
            <input type="text" name="cb" placeholder="Q11111"  id="cin">
            <label for="name">ISBN</label>
            <input type="text" name="isbn" placeholder="John" id="nom">
            <label for="title">Année edition</label>
            <input type="text" name="edition" placeholder="fake.fake@fake.com" id="email">
            <label for="title">Inv</label>
            <input type="text" name="inv" placeholder="11111" id="email">
            <input type="submit" value="Ajouter" class="crt" style="letter-spacing: 1px;width:40%">    
        </div>
    </form>
</div>

<?=template_footer()?>
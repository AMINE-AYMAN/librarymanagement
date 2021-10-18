<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
global $val1;
global $val2;

if (!empty($_POST)) {
$isbn = isset($_POST['isbn']) && !empty($_POST['isbn']) && $_POST['isbn'] != 'auto' ? $_POST['isbn'] : NULL;
$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$disc = isset($_POST['disc']) ? $_POST['disc'] : '';
$cote = isset($_POST['cote']) ? $_POST['cote'] : '';
$descr = isset($_POST['description']) ? $_POST['description'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$stmt = $pdo->prepare('INSERT INTO Auteur VALUES ( default, ?, ?)');
$stmt->execute([$nom, $prenom]);

$statement = $pdo->prepare('SELECT * FROM Auteur ORDER BY codeAut DESC LIMIT 1');
$statement->execute();
$codeA = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($codeA as $contact){
    $val1 = $contact['codeAut'];
}

$statement2 = $pdo->prepare('SELECT * FROM Discipline WHERE libelleDis LIKE :title');
$statement2->bindValue(':title',$disc);
$statement2->execute();
$codeD = $statement2->fetchAll(PDO::FETCH_ASSOC);
foreach ($codeD as $discipline){
    $val2 = $discipline['codeDis'];
}

$stmt = $pdo->prepare('INSERT INTO Livre VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([$isbn, $titre, 5, $val2,$cote,$descr,$type]);
$stmt = $pdo->prepare('INSERT INTO rediger VALUES (?, ?)');
$stmt->execute([$isbn,$val1]);
$msg = 'Ajouté avec succès !!';
header("Location:indexL.php");
}
?>
<?=template_header('Create')?>


<div class="content update">
<h2 style="color: black;">Ajouter Livre : </h2>
<form action="createL.php" method="post">
<div class="wrap">
    <div class="row1">
        
        <label for="id">Titre</label>
        <input type="text" name="titre" placeholder="Software Engineering"  id="titre">
        <label for="name">Nom auteur</label>
        <input type="text" name="nom" placeholder="John " id="nom">
        <label for="email">Prénom auteur</label>
        <input type="text" name="prenom" placeholder="doe" id="prenom">
        <label for="email">Cote</label>
        <input type="text" name="cote" placeholder="4459821" id="prenom">
    </div>
    <div class="row2">
    <label for="title" >Type</label>
    <?php
            $smt = $pdo->prepare('select DISTINCT type From livre');
            $smt->execute();
            $data = $smt->fetchAll();
        ?>
    <select name="type" id="disc">
            <option>Livre</option>
            <option>Document</option>
            <option>Mémoire</option>
            <option>Brevet</option>
            <option>Biographie</option>
        </select>
        <label for="email">Description</label>
        <input type="text" name="description" placeholder="4459821" id="prenom">
        <label for="title" >Discipline</label>
        <?php
            $smt = $pdo->prepare('select libelleDis From Discipline');
            $smt->execute();
            $data = $smt->fetchAll();
        ?>
        <select name="disc" id="disc">
            <?php foreach ($data as $row): ?>
                <option><?=$row["libelleDis"]?></option>
            <?php endforeach ?>
        </select>
        
   
        <label for="id">ISBN </label>
        <input type="text" name="isbn" placeholder="XXXXXXXXXXXXX"  id="isbn">
        </div>
    <input type="submit" value="Ajouter" class="crt" style="letter-spacing: 1px;"> 
</div>
</form>
<?php if ($msg): ?>
<p style="color: black;"><?=$msg?></p>
<?php endif; ?>
</div>

<?=template_footer()?>
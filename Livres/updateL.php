<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
global $val1;
global $val2;

if (isset($_GET['ISBN'])) {
if (!empty($_POST)) { 
    $isbn = $_POST['isbn'] ;
    $titre = $_POST['titre'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $disc = $_POST['disc'];
    $cote = $_POST['cote'];
    $desc = $_POST['descr'];
    $type = $_POST['type'];
    $stmt = $pdo->prepare('UPDATE auteur a,rediger r
        SET a.nomAut = ?, a.prenomAut = ?
        WHERE a.codeAut = r.codeAut
        and r.ISBN = ?');
        $stmt->execute([$nom,$prenom,$_GET['ISBN']]);

    $stmt0 = $pdo->prepare('SELECT * FROM rediger where ISBN = ?');
        $stmt0->execute([$_GET['ISBN']]);
        $codeA = $stmt0->fetchAll(PDO::FETCH_ASSOC);
        foreach ($codeA as $contact){
            $val1 = $contact['codeAut'];
        }

    $stmt1 = $pdo->prepare('SELECT * FROM Discipline WHERE libelleDis LIKE :title');
            $stmt1->bindValue(':title',$disc);
            $stmt1->execute();
            $codeD = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($codeD as $discipline){
            $val2 = $discipline['codeDis'];
        }

    $stmt2 = $pdo->prepare('UPDATE livre
        SET ISBN = ?, titreLiv = ?, nbExemplaire = ?,codeDis=?,coteL = ?,description = ?,type = ?
        WHERE ISBN = ?');
        $stmt2->execute([$_GET['ISBN'], $titre, 5, $val2, $cote,$desc,$type,$_GET['ISBN']]);
    
    $stmt3 = $pdo->prepare('UPDATE rediger
        SET ISBN = ?, codeAut=?
        WHERE ISBN = ?');
        $stmt3->execute([$_GET['ISBN'],$val1 ,$_GET['ISBN']]);
        $msg = 'Modifié avec succès !';
        header('Location: indexL.php');
}
    $stmt = $pdo->prepare
    ('SELECT l.ISBN,l.titreLiv,a.nomAut,a.prenomAut,d.libelleDis,l.nbExemplaire,l.coteL,l.description 
    FROM auteur a, rediger r, livre l,discipline d  
    WHERE a.codeAut=r.codeAut
    and r.ISBN=l.ISBN
    and d.codeDis=l.codeDis
    and l.ISBN = ?');
    $stmt->execute([$_GET['ISBN']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Gestionnaire nexistes pas');
    }
} 
?>

<?=template_header('Read')?>

<div class="content update">
	<h2 style="color: black;">Modifier livre : </h2>
    <form action="updateL.php?ISBN=<?=$contact['ISBN']?>" method="post">
    <div class="wrap">
        <div class="row1">
            
            <label for="id">Titre</label>
            <input type="text" name="titre" placeholder="Q11111" value="<?=$contact['titreLiv']?>" id="cin">
            <label for="name">Nom Auteur</label>
            <input type="text" name="nom" placeholder="John" value="<?=$contact['nomAut']?>" id="nom">
            <label for="title">Prénom auteur</label>
            <input type="text" name="prenom" placeholder="fake.fake@fake.com" value="<?=$contact['prenomAut']?>" id="email">
            <label for="name">Cote</label>
            <input type="text" name="cote" placeholder="123555mar" value="<?=$contact['coteL']?>" id="nom">        
        </div>
       
        <div class="row2">
        <label for="title" >Type</label>
           
            <?php
                $s = $pdo->prepare('select type From livre 
                where ISBN = ?
                ');
                $s->execute([$_GET['ISBN']]);
                $dt = $s->fetchAll();
            ?>
            <select name="type" id="disc" value="">
                <?php foreach ($dt as $r): ?>
                    <option ><?=$r["type"]?></option>
                <?php endforeach ?>
                    <option>Livre</option>
                    <option>Document</option>
                    <option>Mémoire</option>
                    <option>Brevet</option>
                    <option>Biographie</option>
            </select>

            <label for="name">Description</label>
            <input type="text" name="descr" placeholder="123555mar" value="<?=$contact['description']?>" id="nom">

            <label for="title" >Discipline</label>
            <?php
                $smt = $pdo->prepare('select libelleDis From Discipline');
                $smt->execute();
                $data = $smt->fetchAll();
            ?>
            <?php
                $s = $pdo->prepare('select libelleDis 
                from discipline d,livre l
                where d.codeDis=l.codeDis
                and l.ISBN = ?
                ');
                $s->execute([$_GET['ISBN']]);
                $dt = $s->fetchAll();
            ?>
            <select name="disc" id="disc" value="">
                <?php foreach ($dt as $r): ?>
                    <option ><?=$r["libelleDis"]?></option>
                <?php endforeach ?>
                <?php foreach ($data as $row): ?>
                    <option ><?=$row["libelleDis"]?></option>
                <?php endforeach ?>
            </select>
            
            <label for="id">ISBN</label>
            <input type="text" name="isbn" placeholder="Q11111" value="<?=$contact['ISBN']?>"  id="cb">
            
        </div>
        <input type="submit" value="Modifier" class="crt" style="letter-spacing: 1px;"> 
    </div>
</form>
</div>

<?=template_footer()?>
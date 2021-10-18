<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
global $val1;
global $val2;

if (isset($_GET['CNE'])) {
if (!empty($_POST)) { 
    $cne = $_GET['CNE'];
    $cni = isset($_POST['cni']) ? $_POST['cni'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $tele = isset($_POST['tele']) ? $_POST['tele'] : '';
    $fil = isset($_POST['filiere'])? $_POST['filiere'] : $_POST['filiere'];
    $statement2 = $pdo->prepare('SELECT * FROM filiere WHERE libelleFi LIKE :title');
    $statement2->bindValue(':title',$fil);
    $statement2->execute();
    $codeD = $statement2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($codeD as $filiere){
        $val2 = $filiere['codeFi'];
    }

    $stmt = $pdo->prepare('
        UPDATE etudiant
        SET CNE = ?, CNI = ?,
        nomEtu = ?,prenomEtu = ?,
        telephone = ?,codeFi = ?
        WHERE CNE = ?');
        $stmt->execute([$cne,$cni,$nom,$prenom,$tele,$val2,$_GET['CNE']]);
        header('Location: indexT.php');
}
        $stmt = $pdo->prepare
        ('select et.nomEtu,et.prenomEtu,et.CNE,et.CNI,et.telephone,f.libelleFi
        from etudiant et,filiere f
        where et.codeFi = f.codeFi
        and et.CNE = ?;');
        $stmt->execute([$_GET['CNE']]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
} 
?>

<?=template_header('Read')?>

<div class="content update">
	<h2 style="color: black;">Modifier étudiant : </h2>
    
<form action="updateT.php?CNE=<?=$_GET['CNE']?>" method="post">
    <div class="wrap">
        <div class="row1">
        <label for="id">CNE </label>
            <input type="text" name="cne" placeholder="F1313131313131"  id="cne" value="<?=$contact['CNE']?>">
            <label for="id">CNI</label>
            <input type="text" name="cni" placeholder="Q321654"  id="cni" value="<?=$contact['CNI']?>">
            <label for="name">Nom étudiant</label>
            <input type="text" name="nom" placeholder="Alaoui" id="nom" value="<?=$contact['nomEtu']?>">
    </div>
    <div class="row2">
        <label for="email">Prénom étudiant</label>
        <input type="text" name="prenom" placeholder="Samir" id="prenom" value="<?=$contact['prenomEtu']?>">
        <label for="title">Téléphone</label>
        <input type="text" name="tele" placeholder="0645123265" id="tele" value="<?=$contact['telephone']?>">
        <label for="title" >Filière</label>
        <?php
            $smt = $pdo->prepare('select libelleFi 
            from filiere f,etudiant e
            where e.codeFi=f.codeFi
            and e.CNE = ?
            ');
            $smt->execute([$contact['CNE']]);
            $data = $smt->fetchAll();
        ?>
        <select name="filiere" id="disc">
            <?php foreach ($data as $row): ?>
                <option><?=$row["libelleFi"]?></option>
            <?php endforeach ?>
            <?php
                $sm = $pdo->prepare('select libelleFi From filiere');
                $sm->execute();
                $dat = $sm->fetchAll();
            ?>
            <?php foreach ($dat as $ro): ?>
                <option><?=$ro["libelleFi"]?></option>
            <?php endforeach ?>
        </select> 
    </div>
    <input type="submit" value="Modifier" class="crt" style="letter-spacing: 1px;"> 
</div>
</form>
</div>

<?=template_footer()?>
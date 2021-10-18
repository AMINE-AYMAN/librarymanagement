<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
global $val1;
global $val2;


    

if (!empty($_POST)) {
    $stmt1 = $pdo->prepare('select CBR from etudiant order by dateAjout desc LIMIT 1;');
            $stmt1->execute();
            $codeD = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($codeD as $dis){
            $val1 = $dis['CBR'];
        }
        echo $val1+1;
    $cne = isset($_POST['cne']) && !empty($_POST['cne']) && $_POST['cne'] != 'auto' ? $_POST['cne'] : NULL;
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
    
    $stmt = $pdo->prepare('INSERT INTO etudiant VALUES ( ?, ?,?, ?,?,?,?,?)');
    $stmt->execute([$cne,$cni,$val1+1 ,$nom, $prenom,$tele,$val2,date('Y/m/d H:i:s')]);
    header("Location:indexT.php");
}
?>
<?=template_header('Create')?>


<div class="content update">
<h2 style="color: black;">Ajouter étudiant </h2>
<form action="createT.php" method="post">
<div class="wrap">
    <div class="row1">
        <label for="id">CNE </label>
        <input type="text" name="cne" placeholder="F1313131313131"  id="isbn">
        <label for="id">CNI</label>
        <input type="text" name="cni" placeholder="Q321654"  id="titre">
        <label for="name">Nom étudiant</label>
        <input type="text" name="nom" placeholder="Alaoui" id="nom">
    </div>
    <div class="row2">
        <label for="email">Prénom étudiant</label>
        <input type="text" name="prenom" placeholder="Samir" id="prenom">
        <label for="title">Téléphone</label>
        <input type="text" name="tele" placeholder="0645123265" id="nbxmp">
        <label for="title" >Filière</label>
        <?php
            $smt = $pdo->prepare('select libelleFi From filiere');
            $smt->execute();
            $data = $smt->fetchAll();
        ?>
        <select name="filiere" id="disc">
            <?php foreach ($data as $row): ?>
                <option><?=$row["libelleFi"]?></option>
            <?php endforeach ?>
        </select> 
    </div>
    <input type="submit" value="Ajouter" class="crt" style="letter-spacing: 1px;"> 
</div>
</form>
</div>

<?=template_footer()?>

<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
// Check if POST data is not empty
if (isset($_GET['CBGest'])) {
if (!empty($_POST)) { 
    $cin = isset($_POST['cin'])? $_POST['cin'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $tele = isset($_POST['tele']) ? $_POST['tele'] : '';
    $mdp = isset($_POST['mdpp']) ? $_POST['mdpp'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('UPDATE Gestionnaire
        SET CBGest = ?, cinG = ?, nomG = ?, prenomG = ?, emailG = ?,telephoneG = ? , mdpG = ?, dateinscripG = ? 
        WHERE CBGest = ?');
        $stmt->execute([$_GET['CBGest'], $cin, $nom,$prenom, $email, $tele ,$mdp, $created, $_GET['CBGest']]);
        $msg = 'Modifié avec succès !';
        header('Location: indexG.php');
}
    $stmt = $pdo->prepare('SELECT * FROM Gestionnaire WHERE CBGest = ?');
    $stmt->execute([$_GET['CBGest']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Gestionnaire nexistes pas');
    }
} 
?>

<?=template_header('Read')?>

<div class="content update">
	<h2 style="color: black;">Modifier gestionnaire : </h2>
    <form action="updateG.php?CBGest=<?=$contact['CBGest']?>" method="post">
    <div class="wrap">
        <div class="row1">
            <label for="id">Code-barres</label>
            <input type="text" name="cb" placeholder="Q11111" value="<?=$contact['CBGest']?>"  id="cb">
            <label for="id">CIN</label>
            <input type="text" name="cin" placeholder="Q11111" value="<?=$contact['cinG']?>" id="cin">
            <label for="name">Nom </label>
            <input type="text" name="nom" placeholder="John" value="<?=$contact['nomG']?>" id="nom">
            <label for="email">Prénom </label>
            <input type="text" name="prenom" placeholder="doe" value="<?=$contact['prenomG']?>" id="prenom">
        </div>
       
        <div class="row2">
            <label for="title">Email</label>
            <input type="text" name="email" placeholder="fake.fake@fake.com" value="<?=$contact['emailG']?>" id="email">
            <label for="title">Telephone</label>
            <input type="text" name="tele" placeholder="06060606" value="<?=$contact['telephoneG']?>" id="tele">
            <label for="tel">Mot de passe </label>
            <input type="password" name="mdp" value="<?=$contact['mdpG']?>"  id="mdp">
            <label for="created">Confirmer mot de passe </label>
            <input type="password" name="mdpp" value="<?=$contact['mdpG']?>" id="mdpp">
        </div>
        <input type="submit" value="Modifier" class="crt" style="letter-spacing: 1px;"> 
    </div>
    </form>
    <?php if ($msg): ?>
    <p style="color: black;"><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['CNE'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM etudiant WHERE CNE = ?');
    $stmt->execute([$_GET['CNE']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact n exites pas');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM etudiant
                                    WHERE CNE = ?');
            $stmt->execute([$_GET['CNE']]);
            $msg = 'Vous avez supprimé l étudiant !';
            header('Location: indexT.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: indexT.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete" style="text-align: center;">
	<h2>Supprimer étudiant #<?=$contact['CNE']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p style="color: black;font-size: 1.2rem;">Voulez vous vraiment supprimer<br> l'étudiant avec le CNE <br> <strong> <?=$contact['CNE']?> </strong> ?</p>
    <div class="yesno">
        <a href="deleteT.php?CNE=<?=$contact['CNE']?>&confirm=yes"  style="border-radius: 4px;background-color:#1DB954">Oui</a>
        <a href="deleteT.php?CNE=<?=$contact['CNE']?>&confirm=no"  style="border-radius: 4px;background-color:rgb(250, 49, 49)">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>

<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['ISBN'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM Livre 
                            WHERE ISBN = ?');
    $stmt->execute([$_GET['ISBN']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact n exites pas');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM Livre WHERE ISBN = ?');
            $stmt->execute([$_GET['ISBN']]);
            $msg = 'Vous avez supprimé le livre !';
            header('Location: indexL.php');
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: indexL.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Delete')?>

<div class="content delete" style="text-align: center;">
	<h2>Supprimer Livre #<?=$contact['ISBN']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p style="color: black;font-size: 1.2rem;">Voulez vous vraiment supprimer<br> le livre avec l'ISBN <br> <strong> <?=$contact['ISBN']?> </strong> ?</p>
    <div class="yesno">
        <a href="deleteL.php?ISBN=<?=$contact['ISBN']?>&confirm=yes"  style="border-radius: 4px;background-color:#1DB954">Oui</a>
        <a href="deleteL.php?ISBN=<?=$contact['ISBN']?>&confirm=no"  style="border-radius: 4px;background-color:rgb(250, 49, 49)">Non</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
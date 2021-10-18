<?php include('header.php'); ?>
<div class="bloc_page2">
    <div id="div1">
   <form action="" method="post">
  <div class="main_imp"> 
    <table cellspacing="20" class="tab">
        <tr>
            <td><img src="images/FS_El_jadida.png" alt=""></td>
            <td><h2>Bibliotheque UCD</h2>
                <h4>Votre CNE : <?php echo $_SESSION["CNE"];?></h4>
            </td>
        </tr>
        <tr>
            <td>Num Emprunt :</td>
            <td><?php echo $_GET["idE"]; ?></td>
        </tr>
        <tr>
            <td>Nom :</td>
            <td><?php echo $_SESSION["Nom"]; ?></td>
        </tr>
        <tr>
            <td>Prenom :</td>
            <td><?php echo $_SESSION["Pre"]; ?></td>
        </tr>
        <tr>
            <td>ISBN :</td>
            <td><?php echo $_GET["isbn"]; ?></td>
        </tr>
        <tr>
            <td>Titre :</td>
            <td><?php echo $_GET["titre"]; ?></td>
        </tr>
        <tr>
            <td>Date Debut :</td>
            <td><?php echo $_GET["dd"]; ?></td>
        </tr>
        <tr>
            <td>Date Fin :</td>
            <td><?php echo $_GET["df"]; ?></td>
        </tr>
        <tr>
            <td colspan="2"><button id="aa" onclick="imprimer()" class="crt">Imprimer recu</button> </td>
        </tr>
    </table>
</div>
</form>
<script>

function imprimer(){
    var n = document.getElementById("n");
    n.style.display="none";
    n.style.visibility="none";
    window.print();
}
</script>
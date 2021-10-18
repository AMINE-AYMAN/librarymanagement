<?php
include('header.php');
if(isset($_GET['codebar']))
{
    $id = $_GET['codebar'];
    $sql = "select livre.ISBN,livre.titreLiv,auteur.nomAut,auteur.prenomAut,discipline.libelleDis 
    from exemplaire,livre,rediger,auteur,discipline 
    where exemplaire.ISBN=livre.ISBN 
    and livre.ISBN=rediger.ISBN 
    and auteur.codeAut=rediger.codeAut
     and livre.codeDis=discipline.codeDis 
     and exemplaire.codeBar LIKE '%{$id}%'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $isbn = $row["ISBN"];
        $cne = $_SESSION["CNE"];
        $nom = $_SESSION["Nom"];
        $prenom = $_SESSION["Prenom"];
        $titre = $row["titreLiv"];
        $categorie = $row["libelleDis"];
        $dd=date('Y/m/d H:i:s');
        $df=date("Y/m/d H:i:s", strtotime('+2 days', strtotime($dd)));
    }
}
else{
    $message = "Emprunt Invalide";
}
   if(isset($_POST['valide'])){
        $req = "insert into emprunt 
        (dateDebut, dateFin,Etat,codeBar,CNE) 
        values ('{$dd}', '{$df}',0, '{$id}' , '{$cne}')";
         mysqli_query($conn, $req);
         $sql = "select * from emprunt group by codeEmprunt desc";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            header("location:imprimer.php?idE=".$row["codeEmprunt"]."&titre=".$titre."&isbn=".$isbn."&dd=".$dd."&df=".$df);
            
        }
        else
        {
              echo "vérifier vos informations";
        }
    }
    if(isset($_POST['annuler'])){
        header('location: recherche.php');
    }

   
?>



<div class="content update">
        <h2 style="color: black;"> Verifier Votre informations </h2>
        <form action="" method="post">
        <div class="wrap">
           <div class="row1">
                <label for="id">ISBN livre :</label>
                <input type="text" name="codeE" id="cin" value="<?php {echo $isbn;} ?>" disabled>
                <label for="name">CNE :</label>
                <input type="text" name="cne" id="nom" value="<?php {echo $cne;} ?>" disabled>
                <label for="email">Nom :</label>
                <input type="text" name="nomE" id="prenom" value="<?php {echo $nom;} ?>" disabled>
                <label for="email">Prénom :</label>
                <input type="text" name="prenomE" id="prenom" value="<?php {echo $prenom;} ?>" disabled>
            </div>
           
            <div class="row2">
                <label for="title">Titre Livre : </label>
                <input type="text" name="titreLiv" id="email" value="<?php {echo $titre;} ?>" disabled>
                <label for="title">Catégorie :</label>
                <input type="text" name="categorie" id="tele" value="<?php {echo $categorie;} ?>" disabled>
                <label for="tel">Date debut : </label>
                <input type="text" name="dd"  id="mdp" value="<?php {echo $dd;} ?>" disabled>
                <label for="created">Date fin : </label>
                <input type="text" name="df"  id="mdpp" value="<?php {echo $df;} ?>" disabled>
            </div>
        </div>
        <div class="forum_btn">
        <input type="submit" value="Valider Emprunt" name="valide" class="crt" style="letter-spacing: 1px;"> 
        <input type="submit" value="Annuler Emprunt" name="annuler" class="crt" style="letter-spacing: 1px;" onclick="javascript:history.back();"> 
        
       </div> 
    </form>
    </div>
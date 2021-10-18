<?php
include("bd.php");
session_start();
$msg="";
if(isset($_POST['login'])){
    $cne = htmlspecialchars(trim(strtolower($_POST["cne"])));
    $sql = "select * from etudiant where CNE='$cne'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $check = "select CNE from etudiant where '$cne' in (select cne from emprunt where termine=0)";
        $result_check = mysqli_query($conn, $check);
    }
    else{
       $msg="CNE invalid";
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login2.css">
    <link rel="stylesheet" href="css/connect_etud.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    
  <div class="bloc_page">
      <div id="main_abs">
           <div class="msg" id="msg">
               <div class="head_msg">
                   <h2>Attention</h2>
                   <button onclick="cacher()"><i class="fas fa-window-close"></i></button>
               </div>
               <div class="sec_msg">
                <i class="far fa-times-circle"></i>
                <p>Vous avez effucuter deja une emprunt</p>
               </div>
               <div class="foot_msg">
                    <button onclick="cacher()" id="btc">Fermer</button>
               </div>
           
        </div> 
      </div>
    <div class="form_img" id="fr">
        <center><h1>Bienvenue au Bibliotheque UCD</h1></center>
        <p>Connecter à Votre Espace Etudiant.</p>
    </div>
    <div class="form_conn">
        <div class="form_login"> 
            <form action="" method="post">
              <div class="info">
                  <h1>Connexion</h1>
                  <h3>Connecter à votre espace etudiant</h3>
              </div>
           
              <div class="barecode ff">
                  <p>Entrer Votre CNE</p>
                  <h3 id="er"> <?php echo $msg; ?> </h3>
                  <input type="text" name="cne" class="inp" placeholder="Entrer Votre CNE..." required>
              </div>
             <div class="form_bt ff">
                 <button id="btv" name="login" onclick="valider()">SIGN UP</button>
             </div>
            </form>
    </div>
        
  </div>
 
</div>
  <div class="bloc_service" id="bc">
    <div class="txt_service1">
      
    </div>
    <div class="txt_service2">   
        <h1>Nos Services</h1>
        <p>
Cette plateforme vous permet de rechercher et de consulter les livres disponibles dans la bibliothèque de la Faculté des Sciences de l'Université Chaib Doukkali.
Vous avez le droit de réserver 1 livre pour une période de 48 heures. Si vous rencontrez un problème, contactez l'administration de la bibliothèque.</p>
    </div>
</div>
 <script>
       <?php
       if(mysqli_num_rows($result_check)>0)
       {
       ?>
       swal({
  title: "ATTENTION!",
  text: "Vous avez deja une emprunte!",
  icon: "error",
  button: "ok",
});
       <?php
       }  else{
        $row  = mysqli_fetch_assoc($result);
        $_SESSION["CNE"] = $cne;
        $_SESSION["Nom"]= $row['nomEtu'];
        $_SESSION["Prenom"]= $row['prenomEtu'];
        header("location: recherche.php");
        
        }
       ?>
   </script>
</body>
</html>
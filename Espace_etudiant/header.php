<?php include('session.php');


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/mesemp.css">
    <link rel="stylesheet" href="css/login2.css">
    <link rel="stylesheet" href="css/indexL.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/empr.css">
    <link rel="stylesheet" href="css/connect_etud.css">
    <link rel="stylesheet" href="css/imprimer_style.css">
    <link rel="stylesheet" href="css/print.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body>
    <nav id="n">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">FS ELJADIDA UCD</label>
      <ul>
        <li><a href="recherche.php">Recherche Livre</a></li>
        <li><a href="livres.php">Liste Des livres</a></li>
        <li><a href="mesempruntes.php">Mes Emprunts</a></li>
       
       <li class="menu_info">
         <a href="#" class="ic">
           <i class="fas fa-user-alt"> &nbsp;&nbsp; 
            <span class="ses"> <?php
                 echo $_SESSION["Nom"];?>&nbsp;
                <?php echo $_SESSION["Prenom"];?></span> 
         </i></a> 
         <ul class="sous_menu">
          <li><?php
                 echo $_SESSION["Nom"];?>&nbsp;
                <?php echo $_SESSION["Prenom"];?></li>
          <li><?php echo $_SESSION['fil']; ?></li>
          <li><?php echo $_SESSION['CNE']; ?></li>
        </ul>
        </li>
        <li><a href="logout.php" class="ic"><i class="fas fa-sign-out-alt"></i></a></li>
      </ul>
    </nav>

     <script>
      const cuurentlocation=location.href;
      const menuItem=document.querySelectorAll('a');
      const menuLength=menuItem.length;
      for(let i=0;i<menuLength;i++){
        if(menuItem[i].href===cuurentlocation){
          menuItem[i].className="active";
        }
      }
    </script>
  </body>
</html>

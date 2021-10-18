<?php

session_start();


function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'bibliotheque';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!');
    }
}

      

function template_header($title) {
  if(empty($_SESSION["nom"])){
    header('Location: ../Login/login.php');
  }else{ 
  $nom = $_SESSION["nom"];
  $prenom = $_SESSION["prenom"];
}
  global $nom1;
  global $nom2;
  global $prenom1;
  global $prenom2;
  global $titre1;
  global $titre2;
  global $isbn1;
  global $isbn2;

            $stmt=pdo_connect_mysql()->prepare('select et.nomEtu,et.prenomEtu,l.ISBN,l.titreLiv
            from livre l,exemplaire ex,emprunt e,etudiant et
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and	e.CNE=et.CNE
            order by dateDebut desc
            LIMIT 1;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($records as $rec){
                  $nom1 = $rec['nomEtu'];
                  $prenom1 = $rec['prenomEtu'];
                  $titre1 = $rec['titreLiv'];
                  $isbn1 = $rec['ISBN'];
            }

$stmt=pdo_connect_mysql()->prepare('select et.nomEtu,et.prenomEtu,l.ISBN,l.titreLiv
            from livre l,exemplaire ex,emprunt e,etudiant et
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and	e.CNE=et.CNE
            order by dateDebut desc
            LIMIT 2;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($records as $rec){
                  $nom2 = $rec['nomEtu'];
                  $prenom2 = $rec['prenomEtu'];
                  $titre2 = $rec['titreLiv'];
                  $isbn2 = $rec['ISBN'];
            }

echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../nav.css">
      <link rel="stylesheet" href="../Livres/indexL.css">
      <link rel="stylesheet" href="../Livres/createL.css">
      <link rel="stylesheet" href="../Gestionnaire/deleteG.css">
      <link rel="stylesheet" href="../Emprunts/indexEm.css">
      <link rel="stylesheet" href="../Statistiques/indexS.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <script src="../script.js" defer></script>
      <script src="../JsBarcode.all.min.js"></script>
      <script src="../jquery.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
      <title>Bibliothèque FSJ</title>
    </head>
    <body>
      <nav class="navbar">
        <div class="brand-title">FS EL JADIDA UCD</div>
        <a href="#" class="toggle-button">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </a>
        <div class="navbar-links">
          <ul>
            <li><a href="../Statistiques/indexS.php">Statistiques</a></li>
            <li><a href="../Gestionnaire/indexG.php">Gestionnaires</a></li>
            <li><a href="../Livres/indexL.php">Livres</a></li>
            <li><a href="../Exemplaire/indexE.php">Exemplaires</a></li>
            <li><a href="../Emprunts/indexEm.php">Emprunts</a></li>
            <li><a href="../Nonretournées/Nonr.php">Punitions</a></li>
            <li><a href="../Etudiant/indexT.php">Etudiants</a></li>
            <li id="bell" style="padding: 12px;cursor:pointer">
            <i style="font-size:larger" class="fas fa-bell">
              <span class="fa fa-comment"></span>
              <span class="num">2</span>            
            </i>
            </li>
            <div class="notification" >           
              <ul class="notification-menu" >
                <li>
                  <h3>Etudiant : $nom1 $prenom1 </h3>
                  <p>Titre : $titre1</p>
                  <p>ISBN : $isbn1 </p>
                </li>
                <li>
                  <h3>Etudiant : $nom2 $prenom2 </h3>
                  <p>Titre : $titre2 </p>
                  <p>ISBN : $isbn2 </p>
                </li>
                  <a class="voir" href="../Notifications/notif.php">
                      Voir tous les notifications
                  </a> 
              </ul>
            </div>
          </ul>
        </div>
        <div class="navbar-links ">
          <div class="dropdown">    
            <ul>
                <li> 
                    <a href="">  $nom $prenom   
                      <i style="margin:5px 2px 2px 4px" class="fas fa-angle-down"></i>
                    </a>
                </li>
            </ul>
            <div class="dropdown-content">
                <a href="../Gestionnaire/profilG.php">Profil</a>
                <a href="../Login/logout.php">Déconnexion</a>
            </div>
          </div>
        </div>
      </nav>
      <main>
        <div class="container">
EOT;
}

function template_footer() {
echo <<<EOT
        </div>
      </main>
      <footer style="background-color:#162B32;color:white;padding:10px">
        <center>
          © Faculté des Sciences-El Jadida  UCD 2021
        </center>
      </footer>
    </body>
    <script>       
    const toggleButton = document.getElementsByClassName('toggle-button')[0]
    const navbarLinks = document.getElementsByClassName('navbar-links')[0]
    const navbarLinks2 = document.getElementsByClassName('navbar-links')[1]
    toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active');
    navbarLinks2.classList.toggle('active');
    })

    </script>
</html>
EOT;
}
?>
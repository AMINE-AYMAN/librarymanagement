
<?php
include '../functions.php';
$pdo = pdo_connect_mysql();

$nom = $_SESSION["nom"];
$prenom = $_SESSION["prenom"];
?>

<?=template_header('Read')?>

<div class="main">
<h3 style="font-family: myFont;color: gray;margin-left: 10px;"> Date d'aujourd'hui : <?php echo date('Y-m-d')?></h3>
        <h1 style="font-family: myFont;color: black;margin-left: 10px;"> Bonjour <?php echo $_SESSION["nom"]." ".$_SESSION["prenom"] ?>,</h1>
        <p style="font-family: myFont;color: black;margin-left: 10px;">Bienvenue à votre tableau de bord, voici la liste des statistiques. </p>
        <nav class="navbar2">
        <div class="navbar-links2">
          <ul>
            <li><a href="#em1">Statistiques emprunts</a></li>
            <li><a href="#em2">Actualités du jour</a></li>
            <li><a href="#em3">Historique des recherches</a></li>
            <li><a href="#em4">Statistiques livres</a></li>
            <li><a href="#em5">Statistiques étudiants</a></li>
            <li><a href="#em6">Statistiques disciplines</a></li>
            <li><a href="#em7">Statistiques punitions</a></li>
          </ul>
        </div>
      </nav>
        <h1 id="em1">Statistiques emprunts </h1>
        <div class="main_overview">     
          <div class="overview_card">
          <?php
            global $val;
            $stmt=$pdo->prepare('
            select count(l.ISBN) as nblivres 
            from livre l,exemplaire ex,emprunt e
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and DAY(e.dateDebut) = DAY(CURDATE())
            and MONTH(e.dateDebut) = MONTH(CURDATE())
            and YEAR(e.dateDebut) = YEAR(CURDATE())
            and e.Etat = 1;
            ');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" >  <?= $val ?>  </div>
            <div class="overview_card-icon"> livres empruntés aujourd'hui</div>
          </div>
          <?php
            global $val1;
            $stmt=$pdo->prepare('select count(l.ISBN) as nblivres 
            from livre l,exemplaire ex,emprunt e
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and YEARWEEK(e.dateDebut) = YEARWEEK(CURDATE())
            and MONTH(e.dateDebut) = MONTH(CURDATE())
            and e.Etat = 1 ;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val1 = $record['nblivres'];
            }
            ?>
          <div class="overview_card">
            <div class="overview_card-info"> <?= $val1 ?> </div>
            <div class="overview_card-icon">livres empruntés cette semaine</div>
          </div>
          <div class="overview_card">
          <?php
            global $val2;
            $stmt=$pdo->prepare('select count(l.ISBN) as nblivres 
            from livre l,exemplaire ex,emprunt e
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and MONTH(e.dateDebut) = MONTH(CURDATE())
            and YEAR(e.dateDebut) = YEAR(CURDATE())
            and e.Etat = 1;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val2 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info"> <?= $val2 ?> </div>
            <div class="overview_card-icon">livres empruntés ce mois</div>
          </div>
          <div class="overview_card">
          <?php
            global $val2;
            $stmt=$pdo->prepare('select count(l.ISBN) as nblivres 
            from livre l,exemplaire ex,emprunt e
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and YEAR(e.dateDebut) = YEAR(CURDATE())
            and e.Etat = 1 ;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val2 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info"> <?= $val2 ?> </div>
            <div class="overview_card-icon">livres empruntés cette année</div>
          </div>
          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('select count(e.codeEmprunt) as nblivres 
            from livre l,exemplaire ex,emprunt e
            where l.ISBN=ex.ISBN
            and e.codeBar=ex.codeBar
            and e.Etat = 1;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3 ?> </div>
            <div class="overview_card-icon">Total de livres empruntés</div>
          </div>
        </div>
<div class="wrap1">
    <div class="row11">
    <center>
            <h3>Nombres des exemplaires empruntés par mois</h3>
    </center>
    <canvas id="chart" style="width:162%; height: 50vh; background: #162B32; border: 1px solid #555652; margin-top: 10px;padding:10px"></canvas>

<?php
    $stmt = $pdo->prepare('select count(codeBar) as nb
        from emprunt
        where MONTH(emprunt.dateFin)=?;');
    $arr[]=[1,2,3,4,5,6,7,8,9,10,11,12];
    $arr2=array();
    for ($i=1; $i < 13; $i++) { 
        $stmt->execute([$i]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        array_push($arr2,$contact['nb']);
    }
    $data2 = implode(",",$arr2);
    
?>

        <script>
    var ctx = document.getElementById("chart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
        datasets: 
        [
        {
            data: [<?php echo $data2; ?>],
            backgroundColor: 'transparent',
            label: "Nombres d'emprunts",
            borderColor:'rgba(0,255,255)',
            borderWidth: 3	
        }]
    },
 
    options: {
        scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
        tooltips:{mode: 'index'},
        legend:{display: false, position: 'top', labels: {fontColor: 'white', fontSize: 16}}
    }
});
        </script>
    </div>   
    
</div>
</div>
<h1 id="em2">Actualités du jour </h1>

<div class="wrap1">
        <?php  
        $stmt=$pdo->prepare('
        select l.titreLiv ,et.nomEtu,et.prenomEtu,d.libelleDis,e.dateDebut,e.dateFin
        from livre l,discipline d,exemplaire ex,emprunt e,etudiant et
        where l.ISBN=ex.ISBN
        and d.codeDis=l.codeDis
        and	e.CNE=et.CNE
        and e.codeBar=ex.codeBar
        and YEAR(e.dateDebut) = YEAR(CURDATE())
        and MONTH(e.dateDebut) = MONTH(CURDATE())
        and DAY(e.dateDebut) = DAY(CURDATE())
        and e.Etat = 1
        and e.termine = 0;');
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="card">Les livres empruntés aujourd'hui: 
            <ol class="book-list">
            <?php foreach ($records as $emprunt): ?>
              <li> 
                <strong>Titre : </strong> <?= $emprunt['titreLiv']?> <br> 
                <strong>Nom étudiant :   </strong><?= $emprunt['nomEtu']?><br>
                <strong>Prénom étudiant :   </strong><?= $emprunt['prenomEtu']?><br>
                <strong> Discipline : </strong><?= $emprunt['libelleDis']?><br>
                <strong>Date début :   </strong><?= $emprunt['dateDebut']?><br>
                <strong>Date fin :   </strong><?= $emprunt['dateFin']?><br>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>
        <?php
            $stmt=$pdo->prepare('select l.titreLiv ,et.nomEtu,et.prenomEtu,d.libelleDis,e.dateDebut,e.dateFin
            from livre l,discipline d,exemplaire ex,emprunt e,etudiant et
            where l.ISBN=ex.ISBN
            and d.codeDis=l.codeDis
            and	e.CNE=et.CNE
            and e.codeBar=ex.codeBar
            and YEAR(e.dateFin) = YEAR(CURDATE())
            and MONTH(e.dateFin) = MONTH(CURDATE())
            and DAY(e.dateFin) = DAY(CURDATE())
            and e.Etat = 1
            and e.termine = 0;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
    <div class="card">Les livres à retournés aujourd'hui: 
        <ol class="book-list">
            <?php foreach ($records as $emprunt): ?>
            <li> <strong>Titre : </strong> <?= $emprunt['titreLiv']?> <br> 
              <strong>Nom étudiant :   </strong><?= $emprunt['nomEtu']?><br>
              <strong>Prénom étudiant :   </strong><?= $emprunt['prenomEtu']?><br>
              <strong> Discipline : </strong><?= $emprunt['libelleDis']?><br>
              <strong>Date début :   </strong><?= $emprunt['dateDebut']?><br>
              <strong>Date Fin :   </strong><?= $emprunt['dateFin']?><br>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
    

</div>

<h1 id="em3">Historique des recherches</h1>
<div class="wr">
        <?php
            $stmt=$pdo->prepare('
            select r.date_rech,r.CNE,r.text,et.nomEtu,et.prenomEtu,f.libelleFi
            from rechercheparjour r,etudiant et,filiere f
            where r.CNE=et.CNE
            and f.codeFi=et.codeFi
            order by date_rech desc;
            ');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            global $parJour ; 
            $stmtJour=$pdo->prepare('
            select count(id_rech) as nb 
            from rechercheparjour 
            where DAY(date_rech) = DAY(CURRENT_TIMESTAMP())
            and MONTH(date_rech) = MONTH(CURRENT_TIMESTAMP())
            and YEAR(date_rech) = YEAR(CURRENT_TIMESTAMP())
            ;
            ');
            $stmtJour->execute();
            $Jour = $stmtJour->fetchAll(PDO::FETCH_ASSOC);
            foreach ($Jour as $j) {
                $parJour = $j['nb'];
            }   
            global $total ; 
            $stmtTotal=$pdo->prepare('
            select count(id_rech) as nb 
            from rechercheparjour ;
            ');
            $stmtTotal->execute();
            $tt = $stmtTotal->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tt as $t) {
                $total = $t['nb'];
            }

        ?>
<div class="ro">
<div class="overview_card1">
            <div class="overview_card-info" style="margin-right: 10px;">
                <h3><?= $parJour ?> </h3> 
            </div>
            <div class="overview_card-icon"> 
                <h4>
                    Recherches /jour
                </h4>
            </div>
          </div>
          <div class="overview_card1">
            <div class="overview_card-info" style="margin-right: 10px;"> 
              <h3><?= $total ?> </h3>  
            </div>
            <div class="overview_card-icon"> 
                    <h4>Recherches total</h4>
            </div>
          </div>
    
    </div>
    <div class="ro2">
    <div class="cardd" style="width: 100%;">
        <ol class="book-list">
            <?php foreach ($records as $emprunt): ?>
            <li> 
              <strong style="font-family:mtfont">Etudiant :   </strong><?php echo $emprunt['nomEtu']." ".$emprunt['prenomEtu']?><br>
              <strong  style="font-family:mtfont">Filière :   </strong><?= $emprunt['libelleFi']?><br>
              <strong style="font-family:mtfont">Texte de recherche : </strong>  <?= $emprunt['text']?>
               <span >
                   <strong style="font-family:mtfont">
                   à la date 
                   </strong>
                </span> 
               <?= $emprunt['date_rech'] ?> <br>
              <hr>
            </li>
            <?php endforeach; ?>
        </ol>
     </div>
    </div>
</div>

<h1 id="em4">Statistiques livres </h1>
<div class="main_overview">     

          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('select count(ISBN) as nblivres 
            from livre l;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3  ?> </div>
            <div class="overview_card-icon"><span style="font-size: 2rem;">Livres</span></div>
          </div>
        
          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('select count(codeBar) as nblivres 
            from exemplaire e;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3 ?> </div>
            <div class="overview_card-icon"> <span style="font-size: 2rem;">Exemplaires</span></div>
          </div>
        </div>
<div class="wrap1">
    <div class="row11">
        <?php
        global $val;
        $stmt=$pdo->prepare('select l.titreLiv,count(*) as nombres
        from livre l,exemplaire ex,emprunt e
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) desc
        LIMIT 5;');
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h3 style="text-align: center;">Les livres les<span style="color: #1DB954;"> plus </span> empruntés : </h3>
        <table >
            <tbody>
                <tr>
                    <td>Livres</td>
                    <td>Nombres d'emprunts</td>
                </tr>
            <?php foreach ($records as $record):?>
                <tr>
                    <td><?= $record['titreLiv'] ?></td>
                    <td><?= $record['nombres'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>    
    </div>
            
    <div class="row22">
    <?php
        global $val;
        $stmt=$pdo->prepare('select l.titreLiv,count(*) as nombres
        from livre l,exemplaire ex,emprunt e
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) asc
        LIMIT 5;');
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr = array();

        ?>
        <h3 style="text-align: center;">Les livres les <span style="color: red;"> moins </span> empruntés : </h3>
        <table >
            <tbody>
                <tr>
                    <td>Livres</td>
                    <td>Nombres d'emprunts</td>
                </tr>
            <?php foreach ($records as $record):?>
                <tr>
                    <td><?= $record['titreLiv'] ?></td>
                    <td><?= $record['nombres'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
</div>
<div class="wrap1">
    <div class="row11">
    <center>
            <h3>Graphe des livres plus empruntés</h3>
    </center>
    <canvas id="bar-chart" ></canvas>
    
    <?php
        global $val;
        $arr = array();
        $ar = array();
        $stmta=$pdo->prepare('
        select l.titreLiv,count(*) as nb
        from livre l,exemplaire ex,emprunt e
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) asc
        LIMIT 5;');
        $stmta->execute();
        $recordsa = $stmta->fetchAll(PDO::FETCH_ASSOC);
        foreach ($recordsa as $k) {
            array_push($arr,$k['titreLiv']);
            array_push($ar,$k['nb']);
        }
        $dg = implode("','",$arr);
        $df = implode(",",$ar);
        ?>
    <script>
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ['<?php echo $dg;?>'],
      datasets: [
        {
          label: "Nombres d'emprunts",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [<?php echo $df; ?>]
        }
      ]
    },
    options: {
      legend: { display: false },
      
    }
});
     </script>
  </div>
</div>
<h1 id="em5" >Statistiques étudiants </h1>
<div class="main_overview">     

          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('select count(CBR) as nblivres 
            from etudiant;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3 ?> </div>
            <div class="overview_card-icon"><span style="font-size: 2rem;">Etudiants</span></div>
          </div>
        </div>
<div class="wrap1">
    <div class="row11">
        <?php
        global $val;
        $stmt=$pdo->prepare('
        select et.nomEtu,et.prenomEtu,count(*) as nombres 
        from livre l,exemplaire ex,emprunt e,etudiant et
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        and	e.CNE=et.CNE
        and e.Etat = 1
        group by et.nomEtu,et.prenomEtu
        order by nombres DESC
        LIMIT 5;');
        $stmt->execute();
        $record= $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
         <h3 style="text-align: center;">Les étudiants avec le<span style="color: #1DB954;"> plus </span> nombres d'emprunts : </h3>
        <table >
            <tbody>
                <tr>
                    <td>Etudiant</td>
                    <td>Nombres d'emprunts</td>
                </tr>
            <?php foreach ($record as $recor):?>
                <tr>
                    <td><?php echo $recor['nomEtu']. " ". $recor['prenomEtu']  ?></td>
                    <td><?php echo $recor['nombres'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<h1 id="em6" >Statistiques disciplines </h1>
<div class="main_overview">     

          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('select count(codeDis) as nblivres 
            from discipline;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nblivres'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3  ?> </div>
            <div class="overview_card-icon"><span style="font-size: 2rem;">Disciplines</span></div>
    </div>
</div>
<div class="wrap1">
    <div class="row11">
        <?php
        global $val;
        $stmt=$pdo->prepare('
        select DISTINCT d.libelleDis,count(*) as nomb
        from livre l,exemplaire ex,emprunt e,discipline d
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        AND d.codeDis = l.codeDis
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) desc
        LIMIT 5;');
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
         <h3 style="text-align: center;">Les disciplines les<span style="color: #1DB954;"> plus </span> empruntés : </h3>
        <table >
            <tbody>
                <tr>
                    <td>Discipline</td>
                    <td>Nombres d"emprunts </td>
                </tr>
            <?php foreach ($records as $record):?>
                <tr>
                    <td><?= $record['libelleDis'] ?></td>
                    <td><?= $record['nomb'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="row22">
    <?php
        global $val;
        $stmt=$pdo->prepare('
        select DISTINCT d.libelleDis,count(*) as nomb
        from livre l,exemplaire ex,emprunt e,discipline d
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        AND d.codeDis = l.codeDis
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) asc
        LIMIT 5;');
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h3 style="text-align: center;">Les disciplines les <span style="color: red;"> moins </span> empruntés : </h3>
        <table >
            <tbody>
                <tr>
                    <td>Discipline</td>
                    <td>Nombres d'emprunts</td>
                </tr>
            <?php foreach ($records as $record):?>
                <tr>
                    <td><?= $record['libelleDis'] ?></td>
                    <td><?= $record['nomb'] ?></td>
                </tr>
                
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="wrap1">
    <div class="row11">
    <center>
            <h3>Graphe des disciplines les plus empruntés</h3>
    </center>
    <canvas id="bar-chrt" style=" margin-top: 10px;padding:20px;width:40vh;height:50vh;"></canvas>
    <?php
        global $val;
        $a = array();
        $ar1 = array();
        $s=$pdo->prepare('
        select DISTINCT d.libelleDis,count(*) as nomb
        from livre l,exemplaire ex,emprunt e,discipline d
        where l.ISBN=ex.ISBN
        and ex.codeBar = e.codeBar
        AND d.codeDis = l.codeDis
        and e.Etat = 1
        group by l.titreLiv
        order by count(*) desc
        LIMIT 5;');
        $s->execute();
        $re = $s->fetchAll(PDO::FETCH_ASSOC);
        foreach ($re as $ke) {
            array_push($a,$ke['libelleDis']);
            array_push($ar1,$ke['nomb']);
        }
        $dgg = implode("','",$a);
        $dff = implode(",",$ar1);
        ?>
    <script>
new Chart(document.getElementById("bar-chrt"), {
    type: 'pie',
    data: {
      labels: ['<?php echo $dgg;?>'],
      datasets: [
        {
          label: "Nombres d'emprunts",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [<?php echo $dff; ?>]
        }
      ]
    },
});
     </script>
  </div>
</div>

<h1 id="em7" >Statistiques punitions </h1>
<div class="main_overview">     
          <div class="overview_card">
          <?php
            global $val;
            $stmt=$pdo->prepare('
            select count(codePun) as nb
            from punir ;
            ');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val = $record['nb'];
            }
            ?>
            <div class="overview_card-info" >  <?= $val ?>  </div>
            <div class="overview_card-icon">Punitions</div>
          </div>
          <?php
            global $val1;
            $stmt=$pdo->prepare('select count(codePun) as nb
            from punir 
            where codePun = 1 ;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val1 = $record['nb'];
            }
            ?>
          <div class="overview_card">
            <div class="overview_card-info"> <?= $val1 ?> </div>
            <div class="overview_card-icon">Courtes</div>
          </div>
          <div class="overview_card">
          <?php
            global $val2;
            $stmt=$pdo->prepare('select count(codePun) as nb
            from punir 
            where codePun = 2;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val2 = $record['nb'];
            }
            ?>
            <div class="overview_card-info"> <?= $val2 ?> </div>
            <div class="overview_card-icon">Permanentes</div>
          </div>
          
          <div class="overview_card" style="background-color: #1b363f;color: white;">
            <?php
            global $val3;
            $stmt=$pdo->prepare('
            select count(CNE) as nb
            from punir 
            where codePun = 2;');
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($records as $record) {
                $val3 = $record['nb'];
            }
            ?>
            <div class="overview_card-info" "> <?= $val3 ?> </div>
            <div class="overview_card-icon">Etudiants suspendus</div>
          </div>
        </div>
</div>
<?=template_footer()?>
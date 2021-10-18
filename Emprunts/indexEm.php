<?php

include '../functions.php';
$pdo = pdo_connect_mysql();



$stmt1 = $pdo->prepare('select * from emprunt where etat = 1');
$stmt1 -> execute();
$emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('select * from emprunt where etat = 0');
$stmt2 -> execute();
$emprunts2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

global $value;
$stmt2 = $pdo->prepare('select CBGest from gestionnaire where nomG = ? and prenomG = ?');
$stmt2 -> execute([$_SESSION['nom'],$_SESSION['prenom']]);
$gest = $stmt2->fetchAll(PDO::FETCH_ASSOC);
foreach($gest as $g){
    $value = $g['CBGest'];
}


  $statement2 = $pdo->prepare
        ('select  e.codeEmprunt,e.dateDebut,e.dateFin,l.titreLiv,l.ISBN,et.CNI,et.nomEtu,et.prenomEtu,d.libelleDis
        from emprunt e,livre l,exemplaire ex,etudiant et,discipline d
        where l.ISBN=ex.ISBN
        and d.codeDis=l.codeDis
        and ex.codeBar = e.codeBar 
        and	e.CNE=et.CNE
        and e.etat = 0
        order by e.dateDebut desc
        LIMIT 1;');
    $statement2->execute();
    $contacts2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
    global $titre;
    foreach($contacts2 as $ct){
      $titre = $ct['titreLiv'];
    }
    
    
   if (isset($_POST['codeEm'])) {
      if (isset($_POST['confirme'])) {
          if ($_POST['confirme'] == 'yes') {
            if(isset($_POST['exeme'])){ 
              $smtLivre =$pdo->prepare('
              select l.titreLiv
              from livre l,exemplaire e
              where e.ISBN=l.ISBN
              and e.codeBar LIKE ?;
              ');
              global $titreL;
              $smtLivre->execute([$_POST['exeme']]);
              foreach($smtLivre as $smtL){
                $titreL = $smtL['titreLiv'];
              }
              if($titreL === $titre){
              $stmt = $pdo->prepare
              ('update emprunt,exemplaire 
              set emprunt.Etat = 1
              ,exemplaire.etatEx = 0
              ,emprunt.termine=0
              ,emprunt.codeBar = ?
              ,emprunt.CBGest = ?
              WHERE emprunt.codeBar = exemplaire.codeBar
              and emprunt.codeEmprunt = ?');
              $stmt->execute([$_POST['exeme'],$value,$_POST['codeEm']]); 
                }else{
                  echo "<h1>Pas disponible</h1>";
                }                            
              }
            }else{
              $stmt = $pdo->prepare('delete from emprunt
              WHERE codeEmprunt = ?');
              $stmt->execute([$_POST['codeEm']]);
              exit; 
          }
        }  
      }
?>

<?=template_header('Read')?>
<nav class="navbar2">
        <div class="navbar-links2">
          <ul>
            <li><a href="#emp1">Emprunts en cours</a></li>
            <li><a href="#emp2">Emprunts retournés</a></li>
            <li><a href="#emp3">Listes des emprunts</a></li>
          </ul>
        </div>
      </nav>
<div class="container">   
            <div class="head" id="emp1">
              <h2>Emprunts en cours </h2><br> 
            </div>
            <div class="grid" >
            <?php foreach ($contacts2 as $contact):?>
                <article>
                  <div class="text">
                    <div class="h"> 
                      <div class="r1">
                    <h3 >Titre Livre : 
                      <?= $contact['titreLiv'] ?>
                    </h3>
                    <h3>
                        Catégorie livre  :  
                        <?= $contact['libelleDis'] ?>
                    </h3>
                    </div>
                    <div class="r2">
                    <h3>
                      Étudiant  :  
                        <?php echo $contact['nomEtu']." ".$contact['prenomEtu'] ?>
                    </h3>                   
                    <h3>
                        CIN : 
                        <?= $contact['CNI'] ?>
                    </h3>
                    </div>
                    <div class="r3">
                    <h3>
                        Date début : 
                        <?= $contact['dateDebut'] ?>
                    </h3>
                    <h3>
                        Date fin : 
                        <?= $contact['dateFin'] ?>
                    </h3>
                    </div>
                    </div>
                    <div class="btn">
                        <a class="btnapp shw"   style="cursor: pointer;">
                            <i class="fas fa-check"></i>
                                Confirmer
                            </a>
                        <a id="del" class="btndelete" style="cursor: pointer;">
                            <i class="fas fa-times"></i>
                                Rejeter
                            </a>
                          
                    </div>
                    
                    <div id="" class="hide" style="display: none;">
                    
                          <input id="exe" type="text" class="searching" name="exemp" style="width: 100%;margin:17px 0 17px;" placeholder="Scanner le code-barres de l'exemplaire"><br>
                          <button class="btna" style="width: 100%;padding:8px;font-size:medium;cursor:pointer">
                            Validation
                          </button>
                          </div> 

                          <script >
                            $(document).ready(function(){
                            $('.btna').click(function() {
                                var exem = $('#exe').val();
                                var confirm = 'yes';
                              $.ajax({
                                url: 'indexEm.php',
                                type: 'POST',
                                data: { exeme : exem,
                                  codeEm : <?=$contact['codeEmprunt']?>,
                                  confirme :  confirm
                                },
                                success: function(output){
                                  window.location.reload(true);
                                }
                              });
                            });
                            $('#del').click(function() {
                                var confirm = 'no';
                              $.ajax({
                                url: 'indexEm.php',
                                type: 'POST',
                                data: { 
                                  codeEm : <?=$contact['codeEmprunt']?>,
                                  confirme : confirm
                                },
                                success: function(output){
                                  window.location.reload(true);
                                }
                              });
                            });
                            
                          });
                    </script>         
                  </div>
                </article>
            <?php endforeach; ?>      
        </div>
        <h2 style="margin-top: 50px;" id="emp2">Emprunts retournés </h2>
        <div class="wrapi" >
          <?php
          if(isset($_POST['codeB'])){
            $smtEmprunt = $pdo->prepare('
            SELECT DISTINCT codeEmprunt 
            FROM emprunt
            where codeBar = ?
            ORDER by dateDebut DESC
            LIMIT 1;
            ');
          $smtEmprunt -> execute([$_POST['codeB']]);
          $cts = $smtEmprunt->fetchAll(PDO::FETCH_ASSOC);
          global $codeEmprunt;
          foreach ($cts as $ct) {
            $codeEmprunt = $ct['codeEmprunt'];
          }
          $df=date('Y/m/d H:i:s');
          $stmtUpdate = $pdo -> prepare('
          UPDATE exemplaire,emprunt
          SET exemplaire.etatEx=1,
          emprunt.termine=1,
          emprunt.dateFin=?
          WHERE exemplaire.codeBar=emprunt.codeBar
          AND exemplaire.codeBar=?
          AND emprunt.codeEmprunt = ?
          ');
          $stmtUpdate -> execute([$df,$_POST['codeB'],$codeEmprunt]);

          $smDate = $pdo->prepare('
          SELECT DATEDIFF(dateFin,dateDebut) as nbr
          from emprunt
          WHERE codeEmprunt= ?;');
          $smDate -> execute([$codeEmprunt]);
          $ct = $smDate->fetchAll(PDO::FETCH_ASSOC);
          global $periode;
          foreach ($ct as $c) {
            $periode = $c['nbr'];
          }
          if($periode>2){
            $smtCNE = $pdo->prepare('
            SELECT CNE 
            from emprunt
            WHERE codeEmprunt= ?;
            ');
             $smtCNE -> execute([$codeEmprunt]);
             $c = $smtCNE->fetchAll(PDO::FETCH_ASSOC);
             global $CNE;
             foreach ($c as $cr) {
               $CNE = $cr['CNE'];
             }
             $smtExiste = $pdo->prepare('select exists
              (select * from punir where CNE = ?)
               as existe;');
             $smtExiste -> execute([$CNE]);
             $ctt = $smtExiste->fetchAll(PDO::FETCH_ASSOC);
             global $EX;
             foreach ($ctt as $rc) {
               $EX = $rc['existe'];
             }
             if($EX === 1){
                $stPunir = $pdo->prepare('
                UPDATE punir 
                set codePun = 2
                where CNE = ?;');
                $stPunir -> execute([$CNE]);
             }else{
                $stPunir = $pdo->prepare('INSERT INTO punir VALUES
                (?,?,?);');
                $stPunir -> execute([$CNE,1,$codeEmprunt]);
             }
          }
        }
          ?>
              <form action="indexEm.php" method="post">
                <input type="text" name="codeB" class="searching" style="width: 100%;" placeholder="Scanner le code-barres de l'exemplaire retourné">
                  <button type="submit" class="btna" style="width: 100%;padding:8px;font-size:medium;cursor:pointer;margin:5px 0 0 0">
                          Validation
                  </button>
              </form>
        </div>
        <h2 style="margin-top: 50px;" id="emp3">Listes des emprunts </h2>
        <form>
              <div class="cont" style="margin-top: 20px;margin-bottom:15px;" >
              <input type="text" class="search" name="search2"
               placeholder="Rechercher par ISBN, exemplaire, étudiant, discipline, CIN, date"
               value="<?php  ?>">
                    <button type="submit" class="btnsearch">
                        <i class="fas fa-search">
                        </i>
                     </button>
              </div>
        </form>
        <div class="form-inline">
            <form  method="post" action="../PDF/FICHIERS/PDFE.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-right:5px" >
              <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
               PDF
              </button>
              </form>
              <form  method="post" action="../Excel/excelEmprunt.php">
                <button type="submit" id="pdf" name="excelEmp" style="text-align: center;font-size:large" >
                <i style="color:#1DB954;" class="fas fa-file-excel"></i>
                  EXCEL
              </button>
            </form>    
        </div>
            <div style="overflow-x: auto;overflow-y:auto;">
        <table>
        <thead>
            <tr>              
                <td>Titre livre</td>
                <td>Exemplaire</td>
                <td>Catégorie</td>
                <td>Etudiant</td>
                <td>CIN</td>
                <td>Date début</td>
                <td>Date fin</td>
            </tr>
        </thead>
        <tbody>

              <?php
              $search2 = $_GET['search2']??'';
              $records_per_page =0;
              $page = 0;
              if($search2){
                  $smt = $pdo->prepare
                  ('select  e.codeEmprunt,e.codeBar,e.dateDebut, e.dateFin, l.titreLiv,
                   et.CNI,et.nomEtu, et.prenomEtu,d.libelleDis,et.CBR
                  from emprunt e,livre l,exemplaire ex,etudiant et,discipline d
                  where l.ISBN=ex.ISBN
                  and d.codeDis=l.codeDis
                  and ex.codeBar = e.codeBar 
                  and	e.CNE=et.CNE
                  and e.Etat = 1
                  and (l.ISBN like :title
                  or et.nomEtu like :title
                  or et.prenomEtu like :title
                  or l.titreLiv like :title
                  or d.libelleDis like :title
                  or e.dateDebut like :title
                  or e.dateFin like :title
                  or et.CNI like :title
                  or e.codeBar like :title
                  or et.CBR like :title)
                  ;');
                  $smt->bindValue(':title',"%$search2%");
              }else{
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $records_per_page = 6;
                $smt = $pdo->prepare
                      ('select  e.codeEmprunt,e.codeBar,e.dateDebut,e.dateFin,l.titreLiv,et.CNI,et.nomEtu,et.prenomEtu,d.libelleDis
                      from emprunt e,livre l,exemplaire ex,etudiant et,discipline d
                      where l.ISBN=ex.ISBN
                      and d.codeDis=l.codeDis
                      and ex.codeBar = e.codeBar 
                      and	e.CNE=et.CNE
                      and e.Etat = 1
                      order by e.codeEmprunt desc
                      LIMIT :current_page, :record_per_page;');
              }
                $smt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
                $smt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
                $smt->execute();
                $ctts = $smt->fetchAll(PDO::FETCH_ASSOC);
                $num_contacts = $pdo->query('SELECT COUNT(*) FROM emprunt')->fetchColumn();
              ?>
            <?php foreach ($ctts as $contact):?>
            <tr>
                <td>
                    <?= $contact['titreLiv'] ?>
                </td>
                <td>
                    <?= $contact['codeBar'] ?>
                </td>
                <td><?= $contact['libelleDis'] ?></td>
                <td><?php echo $contact['nomEtu'] ." ".$contact['prenomEtu'] ?></td>
                <td><?= $contact['CNI'] ?></td>
                <td><?=$contact['dateDebut']?></td>
                <td><?=$contact['dateFin']?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="7">
              <?php
                global $val1;
                $stmt1 = $pdo->prepare('select count(*) as nombre from emprunt where etat = 1');
                $stmt1 -> execute();
                $emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach($emprunts1 as $emprunts){
                  $val1 = $emprunts['nombre'];
                }
              ?>
              Le nombre total des emprunts validés est <?php echo $val1; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <center>
      <div class="pagination">
      <p style="color: black;">
		<?php if ($page > 1): ?>
		<a href="indexEm.php?page=<?=$page-1?>" class="ar"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
     <?php echo $page*$records_per_page ?> emprunts sur <?php echo $num_contacts ?>
		<a href="indexEm.php?page=<?=$page+1?>" class="ar"> <i class="fas fa-angle-double-right fa-sm"></i></a> </p>
		<?php endif; ?>
	  </div>
    </center>
    </div>
<?=template_footer()?>
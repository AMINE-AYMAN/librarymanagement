<?php

include '../functions.php';
$pdo = pdo_connect_mysql();

  $statement2 = $pdo->prepare
        ('select et.nomEtu,et.CNI,et.prenomEtu,l.ISBN,l.titreLiv,d.libelleDis,e.dateDebut,e.dateFin
        from livre l,exemplaire ex,emprunt e,etudiant et,discipline d
        where l.ISBN=ex.ISBN
        and e.codeBar=ex.codeBar
        and	e.CNE=et.CNE
        and d.codeDis = l.codeDis 
        order by dateDebut desc
        ;');
    $statement2->execute();
    $contacts2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Read')?>

<div class="container">   
            <div class="head" id="emp1">
              <h2>Notifications </h2><br> 
            </div>
            <div class="grid" >
            <?php foreach ($contacts2 as $contact):?>
                <article class="click">
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
                                               
                  </div>
                </article>
            <?php endforeach; ?>      
        </div>
      </div>
   
<?=template_footer()?>
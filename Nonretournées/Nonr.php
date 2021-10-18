<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$search = $_GET['search']??'';
$records_per_page =0;
$page = 0;

if($search){
    $statement = $pdo->prepare
    ('select etudiant.nomEtu,etudiant.prenomEtu,filiere.libelleFi, 
    punition.libellePun,emprunt.codeBar,livre.titreLiv,emprunt.dateDebut,emprunt.dateFin
    from etudiant,filiere,punition,punir,emprunt,livre,exemplaire
    WHERE etudiant.codeFi=filiere.codeFi
    and punition.codePun=punir.codePun
    and punir.CNE=etudiant.CNE
    and punir.codeEmprunt=emprunt.codeEmprunt
    and livre.ISBN=exemplaire.ISBN
    and exemplaire.codeBar=emprunt.codeBar
    and (nomEtu LIKE ?
    or prenomEtu LIKE ?
    or libellePun LIKE ? 
    or titreLiv like ?);');
    $statement->bindValue(':title',"%$search%");
}else{
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
  $records_per_page = 6;
  $statement = $pdo->prepare
  ('select etudiant.nomEtu,etudiant.prenomEtu,filiere.libelleFi, 
    punition.libellePun,emprunt.codeBar,livre.titreLiv,emprunt.dateDebut,emprunt.dateFin
    from etudiant,filiere,punition,punir,emprunt,livre,exemplaire
    WHERE etudiant.codeFi=filiere.codeFi
    and punition.codePun=punir.codePun
    and punir.CNE=etudiant.CNE
    and punir.codeEmprunt=emprunt.codeEmprunt
    and livre.ISBN=exemplaire.ISBN
    and exemplaire.codeBar=emprunt.codeBar
    LIMIT :current_page, :record_per_page;');
}
    $statement->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $statement->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $statement->execute();
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $num_contacts = $pdo->query('SELECT COUNT(*) FROM etudiant')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="container">   
            <div class="head">
              <h2>Punitions (dépassement de 48 heures)</h2><br> 
            </div>
            <form>
            <div class="cont" style="margin-top: 20px;margin-bottom:15px;">
              <input type="text" class="search" name="search" id="ser"
               placeholder="Rechercher par type de punition, filière, étudiant"
               value="<?php echo $search; ?>">
              <button type="submit" class="btnsearch">
                <i class="fas fa-search">
                </i>
              </button>
            </div>
            </form>
            <div class="form-inline">
      <form method="post" action="../PDF/FICHIERS/PDFP.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-left:5px" >
              <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
               PDF
              </button>
            </form>
            <form  method="post" action="../Excel/excelPunition.php">
                <button type="submit" id="pdf" name="excelPi" style="text-align: center;font-size:large;margin-left: 5px;" >
                <i style="color:#1DB954;" class="fas fa-file-excel"></i>
                  EXCEL
              </button>
            </form>  
            </div>
      <table>
        <thead>
            <tr>              
                <td>Etudiant</td>
                <td>filière</td>
                <td>Punition</td>
                <td>livre</td>
                <td>Exemplaire</td>
                <td>Date début</td>
                <td>Date fin</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $contact):?>
            <tr>
                <td>
                    <?php echo  $contact['nomEtu']." ".$contact['prenomEtu'] ?>
                </td>
                <td><?= $contact['libelleFi'] ?></td>
                <td><?= $contact['libellePun'] ?></td>
                <td><?= $contact['titreLiv'] ?></td>
                <td><?= $contact['codeBar'] ?></td>
                <td><?= $contact['dateDebut'] ?></td>
                <td><?= $contact['dateFin'] ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>  
        </div>        
    </div>
<?=template_footer()?>
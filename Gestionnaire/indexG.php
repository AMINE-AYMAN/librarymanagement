<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$search = $_GET['search']??'';
$records_per_page =0;
$page = 0;

if($search){
    $statement = $pdo->prepare('SELECT * FROM Gestionnaire WHERE 
    (CBGest LIKE :title 
    or emailG like :title
    or cinG like :title
    or nomG like :title 
    or prenomG like :title ) ORDER BY dateinscripG DESC ');
    $statement->bindValue(':title',"%$search%");
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);  
}else{
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = 6;
    $statement = $pdo->prepare('SELECT * FROM Gestionnaire ORDER BY CBGEst LIMIT :current_page, :record_per_page;');
}
    $statement->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $statement->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $statement->execute();
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $num_contacts = $pdo->query('SELECT COUNT(*) FROM gestionnaire')->fetchColumn();

?>
<?=template_header('Read')?>

    <div class="container">   
            <div class="head">
              <h2>Gestionnaires</h2><br>
            <a class="create" href="createG.php">Ajouter un gestionnaire</a>
            </div>
            <form>
            <div class="cont" style="margin-top: 15px;margin-bottom:15px;">
              <input type="text" class="search" name="search"
               placeholder="Rechercher par code-barres, email, nom, prénom, cin"
               value="<?php echo $search; ?>">
              <button type="submit" class="btnsearch">
                <i class="fas fa-search">
                </i>
              </button>
            </div>
            </form>
            <div class="form-inline">
            <form  method="post" action="../PDF/FICHIERS/PDFG.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-right:5px" >
              <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
               PDF
              </button>
              </form>
              <form  method="post" action="../Excel/excelGestionnaire.php">
                <button type="submit" id="pdf" name="excelGe" style="text-align: center;font-size:large" >
                <i style="color:#1DB954;" class="fas fa-file-excel"></i>
                  EXCEL
              </button>
            </form>    
        </div>
            <div style="overflow-x: auto;overflow-y:auto;">
    <table>
        <thead>
            <tr>           
                <td>Code-barres</td>
                <td>Cin</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Email</td>
                <td>Telephone</td>
                <td>Mot de passe</td>
                <td>Date d'inscription</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact):
                
                $array[] = $contact['CBGest'];
                
                ?>
            <tr>
                
                <td>
                <svg id='<?php echo "barcode".$contact['CBGest']; ?>'>
                </td>
                <td><?=$contact['cinG']?></td>
                <td><?=$contact['nomG']?></td>
                <td><?=$contact['prenomG']?></td>
                <td><?=$contact['emailG']?></td>
                <td><?=$contact['telephoneG']?></td>
                <td><?=$contact['mdpG']?></td> 
                <td><?=$contact['dateinscripG']?></td>
                <td class="actions">
                    <a href="updateG.php?CBGest=<?=$contact['CBGest']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteG.php?CBGest=<?=$contact['CBGest']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="9">
              <?php
                global $val1;
                $stmt1 = $pdo->prepare('select count(*) as nombre from gestionnaire');
                $stmt1 -> execute();
                $emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach($emprunts1 as $emprunts){
                  $val1 = $emprunts['nombre'];
                }
                ?>
                Le nombre total des gestionnaires est <?php echo $val1; ?>
              </td>
            </tr>
        </tbody>
    </table>
    
    </div>
    <center>
      <div class="pagination">
      <p style="color: black;">
		<?php if ($page > 1): ?>
		<a href="indexG.php?page=<?=$page-1?>" class="ar"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
     <?php echo $page*$records_per_page ?> gestionnaires sur <?php echo $num_contacts ?>
		<a href="indexG.php?page=<?=$page+1?>" class="ar"> <i class="fas fa-angle-double-right fa-sm"></i></a> </p>
		<?php endif; ?>
	  </div>
    </center>
    </div> 
<script type="text/javascript">
    
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }

  jsonvalue = '<?php echo json_encode($array) ?>';
  values = arrayjsonbarcode(jsonvalue);

  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "codabar",
      lineColor: "#000",
      width: 1,
      height: 15,
      displayValue: true
      }
    );
  }
</script>


<?=template_footer()?>
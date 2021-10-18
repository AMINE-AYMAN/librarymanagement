<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$search = $_GET['search']??'';
$records_per_page =0;
$page = 0;

if($search){
    $statement = $pdo->prepare
    ('SELECT l.ISBN,l.titreLiv,a.nomAut,a.prenomAut,d.libelleDis,l.nbExemplaire,l.coteL,l.type,l.description 
    FROM auteur a, rediger r, livre l,discipline d  
      WHERE a.codeAut=r.codeAut
      and r.ISBN=l.ISBN
      and d.codeDis=l.codeDis
      and (l.ISBN like :title
      or d.libelleDis like :title
      or a.nomAut like :title
      or a.prenomAut like :title
      or l.coteL like :title
      or l.titreLiv like :title) ');
    $statement->bindValue(':title',"%$search%");
}else{
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
  $records_per_page = 6;
  $statement = $pdo->prepare
  ('SELECT l.ISBN,l.titreLiv,a.nomAut,a.prenomAut,d.libelleDis,l.nbExemplaire,l.coteL,l.type,l.description 
  FROM auteur a, rediger r, livre l,discipline d  
    WHERE a.codeAut=r.codeAut
    and r.ISBN=l.ISBN
    and d.codeDis=l.codeDis
    order by l.ISBN
    LIMIT :current_page, :record_per_page;');
}
    $statement->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $statement->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $statement->execute();
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
    $num_contacts = $pdo->query('SELECT COUNT(*) FROM livre')->fetchColumn();
    
?>
<?=template_header('Read')?>

    <div class="container">   
            <div class="head">
              <h2>Livres</h2><br>
              
              <a class="create" href="createL.php">Ajouter un livre</a>
            </div>
            <form>
            <div class="cont" style="margin-top: 20px;margin-bottom:15px;">

              <input type="text" class="search" name="search"
               placeholder="Rechercher par ISBN, auteur, discipline, titre, cote"
               value="<?php echo $search; ?>">
              <button type="submit" class="btnsearch">
                <i class="fas fa-search">
                </i>
              </button>
            </div>
            </form>
            <div class="form-inline">
            <form  method="post" action="../PDF/FICHIERS/PDFL.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-right:5px" >
              <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
               PDF
              </button>
              </form>
              <form  method="post" action="../Excel/excelLivres.php">
                <button type="submit" id="pdf" name="excelLi" style="text-align: center;font-size:large" >
                <i style="color:#1DB954;" class="fas fa-file-excel"></i>
                  EXCEL
              </button>
            </form>    
        </div>
            <div style="overflow-x: auto;overflow-y:auto;">
    <table>
        <thead>
            <tr>              
                <td>ISBN</td>
                <td>Titre</td>
                <td>Auteur</td>
                <td>Discipline</td>
                <td>Cote</td>
                <td>Type</td>
                <td>Déscription</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact):
                
                $array[] = $contact['ISBN'];
                
                ?>
            <tr>
                <td>
                  <svg id='<?php echo "barcode".$contact['ISBN']; ?>'>
                </td>
                <td><?=$contact['titreLiv']?></td>
                <td><?php echo $contact['nomAut']." ".$contact['prenomAut'] ?></td>
                <td><?=$contact['libelleDis']?></td>
                <td><?=$contact['coteL']?></td>
                <td><?=$contact['type']?></td>
                <td><?=$contact['description']?></td>
                <td class="actions">
                    <a href="updateL.php?ISBN=<?=$contact['ISBN']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteL.php?ISBN=<?=$contact['ISBN']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="8">
              <?php
                global $val1;
                $stmt1 = $pdo->prepare('select count(*) as nombre from livre');
                $stmt1 -> execute();
                $emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach($emprunts1 as $emprunts){
                  $val1 = $emprunts['nombre'];
                }
                ?>
                Le nombre total des livres est <?php echo $val1; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <center>
      <div class="pagination">
      <p style="color: black;">
		<?php if ($page > 1): ?>
		<a href="indexL.php?page=<?=$page-1?>" class="ar"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
     <?php echo $page*$records_per_page ?> livres sur <?php echo $num_contacts ?>
		<a href="indexL.php?page=<?=$page+1?>" class="ar"> <i class="fas fa-angle-double-right fa-sm"></i></a> </p>
		<?php endif; ?>
	  </div>
    </center>
    </div> 
<script type="text/javascript">
    
  //convert json to JS array data.
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }

  //convert PHP array to json data.
  jsonvalue = '<?php echo json_encode($array) ?>';
  values = arrayjsonbarcode(jsonvalue);

  //generate barcodes using values data.
  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "EAN13",
      lineColor: "#000",
      width: 1,
      height: 15,
      displayValue: true
      }
    );
  }

</script>
<?=template_footer()?>
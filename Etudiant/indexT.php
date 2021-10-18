<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$search = $_GET['search']??'';
$records_per_page =0;
$page = 0;

if($search){
    $statement = $pdo->prepare
    ('    select et.CBR,et.nomEtu,et.prenomEtu,et.CNE,f.libelleFi,et.CNI
        from etudiant et,filiere f
        where et.codeFi = f.codeFi
        and (et.CBR like :title
        or et.nomEtu like :title
        or et.prenomEtu like :title
        or et.CNE like :title
        or et.CNI like :title
        or f.libelleFi like :title);');
    $statement->bindValue(':title',"%$search%");
}else{
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
  $records_per_page = 6;
  $statement = $pdo->prepare
  ('    select et.CBR,et.nomEtu,et.prenomEtu,et.CNE,et.CNI,f.libelleFi
    from etudiant et,filiere f
    where et.codeFi = f.codeFi
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
              <h2>Etudiants</h2><br>    
              <a class="create" href="createT.php">Ajouter un étudiant</a>
            </div>
            <form>
            <div class="cont" style="margin-top: 20px;margin-bottom:15px;">

              <input type="text" class="search" name="search" id="ser"
               placeholder="Rechercher par étudiant, CIN, CNE, filière"
               value="<?php echo $search; ?>">
              <button type="submit" class="btnsearch">
                <i class="fas fa-search">
                </i>
              </button>
            </div>
            </form>
            <div class="form-inline">
              <form  method="post" action="../PDF/FICHIERS/PDFET.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-right:5px" >
                <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
                PDF
              </button>
              </form>
              <form  method="post" action="../Excel/exceletudiant.php">
                <button type="submit" id="pdf" name="excelEtu" style="text-align: center;font-size:large" >
                <i style="color:#1DB954;" class="fas fa-file-excel"></i>
                  EXCEL
                </button>
              </form>    
            </div>
  <div style="overflow-x:auto;overflow-y:auto;">
    <table>
        <thead>
            <tr>      
                <td>Code-barres</td>        
                <td>Etudiant</td>
                <td>CNE</td>
                <td>CNI</td>
                <td>Filière</td>
                <td>Actions</td>            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact):
              $array[] = $contact['CBR'];
              ?>
            <tr>
                <td>
                  <svg id='<?php echo "barcode".$contact['CBR']; ?>'>
                </td>
                <td>
                    <?php echo $contact['nomEtu']." ".$contact['prenomEtu'] ?>
                </td>
                <td><?=$contact['CNE']?></td>
                <td><?=$contact['CNI']?></td>
                <td><?=$contact['libelleFi']?></td>
                
                <td class="actions">
                    <a href="updateT.php?CNE=<?=$contact['CNE']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteT.php?CNE=<?=$contact['CNE']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
               
            </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="8">
              <?php
                global $val1;
                $stmt1 = $pdo->prepare('select count(*) as nombre from etudiant');
                $stmt1 -> execute();
                $emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach($emprunts1 as $emprunts){
                  $val1 = $emprunts['nombre'];
                }
              ?>
                Le nombre total des étudiants est <?php echo $val1; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <center>
      <div class="pagination">
      <p style="color: black;">
		<?php if ($page > 1): ?>
		<a href="indexT.php?page=<?=$page-1?>" class="ar"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
     <?php echo $page*$records_per_page ?> étudiants sur <?php echo $num_contacts ?>
		<a href="indexT.php?page=<?=$page+1?>" class="ar"> <i class="fas fa-angle-double-right fa-sm"></i></a> </p>
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

  //generate barcodes using values data.
  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "CODE128",
      lineColor: "#000",
      width: 1,
      height: 15,
      displayValue: true
      }
    );
  }

</script>
<?=template_footer()?>
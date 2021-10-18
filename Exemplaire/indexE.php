<?php

include '../functions.php';
$pdo = pdo_connect_mysql();
$search2 = $_GET['search2']??'';
$records_per_page =0;
$page = 0;

if($search2){
    $statement2 = $pdo->prepare
    (' select e.codeBar,e.ISBN,l.titreLiv,ed.anneeEdi,e.etatEx,e.inv
    from exemplaire e,livre l,edition ed
    where e.ISBN=l.ISBN
    and e.codeEdi = ed.codeEdi 
    and (e.codeBar like :title
    or e.ISBN like :title
    or l.titreLiv like :title
    or ed.anneeEdi like :title
    or e.etatEx like :title
    or e.inv like :title
    )');
    $statement2->bindValue(':title',"%$search2%");
}else{
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
  $records_per_page = 6;
  $statement2 = $pdo->prepare
  ('select e.codeBar,e.ISBN,l.titreLiv,ed.anneeEdi,e.etatEx,e.inv
  from exemplaire e,livre l,edition ed
  where e.ISBN=l.ISBN
  and e.codeEdi = ed.codeEdi
    order by e.codeBar
    LIMIT :current_page, :record_per_page;;');
}
    $statement2->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $statement2->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $statement2->execute();
    $contacts2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
    $num_contacts = $pdo->query('SELECT COUNT(*) FROM exemplaire')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="container">   
            <div class="head">
              <h2>Exemplaires</h2><br> 
              <a class="create" href="createE.php">Ajouter un exemplaire</a>
            </div>
            <form>
              <div class="cont" style="margin-top: 20px;margin-bottom:15px;">
              <input type="text" class="search" name="search2"
               placeholder="Rechercher par code-barres, ISBN, titre livre, édition, inv"
               value="<?php echo $search2; ?>">
              <button type="submit" class="btnsearch">
                <i class="fas fa-search">
                </i>
              </button>
            </div>
            </form>
            <div class="form-inline">
            <form  method="post" action="../PDF/FICHIERS/PDFEX.php">
              Exporter : 
              <button type="submit" id="pdf" name="generate_pdf" style="text-align: center;font-size:large;margin-right:5px" >
              <i style="color: rgb(250, 49, 49);" class="fas fa-file-pdf"></i>
               PDF
              </button>
              </form>
              <form  method="post" action="../Excel/excelExemplaires.php">
                <button type="submit" id="pdf" name="excelEx" style="text-align: center;font-size:large" >
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
                <td>ISBN</td>
                <td>Titre livre</td>
                <td>Année édition</td>
                <td>Etat exemplaire</td>
                <td>Inv</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts2 as $contact2):
                
                $array1[] = $contact2['codeBar'];
                $array2[] = $contact2['ISBN'];
                ?>
            <tr>
                <td>
                  <svg id='<?php echo "barcode1".$contact2['codeBar']; ?>'>
                </td>
                <td><svg id='<?php echo "isbn".$contact2['ISBN']; ?>'></td>
                <td><?=$contact2['titreLiv']?></td>
                <td><?=$contact2['anneeEdi']?></td>
                <td><?php  
                    if($contact2['etatEx'] == 1){
                      echo "Disponible";
                    }else{
                      echo "Non disponible";
                    }
                ?></td>
                <td><?=$contact2['inv']?></td>
                <td class="actions">
                    <a href="updateE.php?codeBar=<?=$contact2['codeBar']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteE.php?codeBar=<?=$contact2['codeBar']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            
            <?php endforeach; ?>
            <tr>
              <td colspan="6">
              <?php
                global $val1;
                $stmt1 = $pdo->prepare('select count(*) as nombre from exemplaire');
                $stmt1 -> execute();
                $emprunts1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach($emprunts1 as $emprunts){
                  $val1 = $emprunts['nombre'];
                }
                ?>
                Le nombre total des exemplaires est <?php echo $val1; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <center>
      <div class="pagination">
      <p style="color: black;">
		<?php if ($page > 1): ?>
		<a href="indexE.php?page=<?=$page-1?>" class="ar"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
     <?php echo $page*$records_per_page ?> éxemplaires sur <?php echo $num_contacts ?>
		<a href="indexE.php?page=<?=$page+1?>" class="ar"> <i class="fas fa-angle-double-right fa-sm"></i></a> </p>
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

  jsonvalue1 = '<?php echo json_encode($array1) ?>';
  values1 = arrayjsonbarcode(jsonvalue1);

  //generate barcodes using values data.
  for (var i = 0; i < values1.length; i++) {
    JsBarcode("#barcode1" + values1[i], values1[i].toString(), {
      format: "CODE128B",
      lineColor: "#000",
      width: 1,
      height: 15,
      displayValue: true
      }
    );
  }
  
  jsonvalue2 = '<?php echo json_encode($array2) ?>';
  values2 = arrayjsonbarcode(jsonvalue2);

  //generate barcodes using values data.
  for (var i = 0; i < values2.length; i++) {
    JsBarcode("#isbn" + values2[i], values2[i].toString(), {
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
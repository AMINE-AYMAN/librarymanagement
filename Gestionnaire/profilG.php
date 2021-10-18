<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
    $statement = $pdo->prepare('SELECT * FROM Gestionnaire WHERE CBGest LIKE :title  ORDER BY dateinscripG DESC');
    $statement->bindValue(':title', $_SESSION["code"]);
    $statement->execute();
    $contacts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?=template_header('Create')?>


<div class="content update">
<h2 style="color: black;">Informations personnelles : </h2>
<form action="indexG.php" method="post">
<div class="wrap">
<?php foreach ($contacts as $contact)
    $arra[] = $contact['CBGest'];
?>
    <div class="row1">
        <label > <strong> code-Barres :</strong> </label>
        <label for=""><svg id='<?php echo "barcode".$contact['CBGest']; ?>'></label>
        <label for="id"> <strong> CIN : </strong> </label>
        <label for=""><?=$contact['cinG']?></label>
        <label for="name"> <strong> Nom gestionnaire : </strong> </label>
        <label for=""><?=$contact['nomG']?></label>
        <label for="name"> <strong> Prenom gestionnaire : </strong> </label>
        <label for=""><?=$contact['prenomG']?></label>
    </div>
    <div class="row2">
        <label for="id"> <strong> Email : </strong> </label>
        <label for=""><?=$contact['emailG']?></label>
        <label for="id"> <strong> Telephone : </strong> </label>
        <label for=""><?=$contact['telephoneG']?></label>
        <label for="name"> <strong> Mot de passe : </strong> </label>
        <label for=""><?=$contact['mdpG']?></label>
        <label for="name"> <strong> Date inscription : </strong> </label>
        <label for=""><?=$contact['dateinscripG']?></label>
    </div>
    <input type="submit" value="Retour à la liste des gestionnaires " class="crt" style="letter-spacing: 1px;"> 
</div>
</form>
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
  jsonvalue = '<?php echo json_encode($arra) ?>';
  values = arrayjsonbarcode(jsonvalue);

  //generate barcodes using values data.
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
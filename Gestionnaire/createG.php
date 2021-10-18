<?php
include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = ''; 
// Check if POST data is not empty
if (!empty($_POST)) {
    $number = rand(1,100);
    $code = $number.date('is');
    $cin = isset($_POST['cin']) && !empty($_POST['cin']) && $_POST['cin'] != 'auto' ? $_POST['cin'] : NULL;
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $tele = isset($_POST['tele']) ? $_POST['tele'] : '';
    $mdp = isset($_POST['mdpp']) ? $_POST['mdpp'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('INSERT INTO Gestionnaire VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$code,$cin, $nom, $prenom, $email, $tele, $mdp, $created]);
    header("Location:indexG.php");
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2 style="color: black;">Ajouter gestionnaire : </h2>
    <form action="createG.php" method="post">
    <div class="wrap">
        <div class="row1">
            <label for="id">CIN</label>
            <input type="text" name="cin" placeholder="Q11111"  id="cin">
            <label for="name">Nom </label>
            <input type="text" name="nom" placeholder="John" id="nom">
            <label for="email">Prénom </label>
            <input type="text" name="prenom" placeholder="doe" id="prenom">
        </div>
       
        <div class="row2">
            <label for="title">Email</label>
            <input type="text" name="email" placeholder="fake.fake@fake.com" id="email">
            <label for="title">Telephone</label>
            <input type="text" name="tele" placeholder="06060606" id="tele">
            <label for="tel">Mot de passe </label>
            <input type="password" name="mdp"  id="mdp">
            <label for="created">Confirmer mot de passe </label>
            <input type="password" name="mdpp"  id="mdpp">
        </div>
        <input type="submit" value="Ajouter" class="crt" style="letter-spacing: 1px;"> 
    </div>
    </form>
    <?php if ($msg): ?>
    <p style="color: black;"><?=$msg?></p>
    <?php endif; ?>
</div>
<script type="text/javascript">
  //convert json to JS array data.
  <?php 
        $connection=mysqli_connect('localhost','root','','biblio');
        $sql="SELECT * FROM Gestionnaire";
        $result=mysqli_query($connection,$sql);
        $arrayBarcodes=array();
        while($row=mysqli_fetch_row($result))
        {
            $arrayBarcodes[]=(string)$row[2];
        };
        echo (string)$row[2]  ;
    ?>
  function arrayjsonbarcode(j) {
    json = JSON.parse(j);
    arr = [];
    for (var x in json) {
      arr.push(json[x]);
    }
    return arr;
  }
  //convert PHP array to json data.
  jsonvalue = '<?php echo json_encode($arrayBarcodes) ?>';
  values = arrayjsonbarcode(jsonvalue);
  //generate barcodes using values data.
  for (var i = 0; i < values.length; i++) {
    JsBarcode("#barcode" + values[i], values[i].toString(), {
      format: "codabar",
      lineColor: "#000",
      width: 2,
      height: 30,
      displayValue: true
      }
    );
  }
</script>

<?=template_footer()?>
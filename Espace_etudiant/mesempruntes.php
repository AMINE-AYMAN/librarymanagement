<?php include('header.php');
  $cne = $_SESSION["CNE"];

  if(isset($_GET['sort'])){
    $sql = "select emprunt.codeEmprunt,exemplaire.ISBN,livre.titreLiv,discipline.libelleDis, emprunt.dateDebut, 
    emprunt.dateFin from emprunt, etudiant, exemplaire,livre,discipline where emprunt.CNE=etudiant.CNE and 
   emprunt.codeBar=exemplaire.codeBar and exemplaire.ISBN=livre.ISBN and livre.codeDis=discipline.codeDis 
   and etudiant.CNE LIKE'%{$cne}%' order by emprunt.dateDebut";
    $result = mysqli_query($conn, $sql);    
}
  if(isset($_GET['m'])){
    $sql = "select emprunt.codeEmprunt,exemplaire.ISBN,livre.titreLiv,discipline.libelleDis, emprunt.dateDebut, 
    emprunt.dateFin from emprunt, etudiant, exemplaire,livre,discipline where emprunt.CNE=etudiant.CNE and 
   emprunt.codeBar=exemplaire.codeBar and exemplaire.ISBN=livre.ISBN and livre.codeDis=discipline.codeDis 
   and etudiant.CNE LIKE'%{$cne}%' and month(dateDebut)=month(CURRENT_DATE())";
   $result = mysqli_query($conn, $sql);
  }
  elseif(isset($_GET['s'])){
    $sql = "select emprunt.codeEmprunt,exemplaire.ISBN,livre.titreLiv,discipline.libelleDis, emprunt.dateDebut, 
    emprunt.dateFin from emprunt, etudiant, exemplaire,livre,discipline where emprunt.CNE=etudiant.CNE and 
   emprunt.codeBar=exemplaire.codeBar and exemplaire.ISBN=livre.ISBN and livre.codeDis=discipline.codeDis 
   and etudiant.CNE LIKE'%{$cne}%' and (day(dateDebut)-day(CURRENT_DATE))<=7";
   $result = mysqli_query($conn, $sql);
  }
  else{
       $sql = "select emprunt.codeEmprunt,exemplaire.ISBN,livre.titreLiv,discipline.libelleDis, emprunt.dateDebut, 
   emprunt.dateFin from emprunt, etudiant, exemplaire,livre,discipline where emprunt.CNE=etudiant.CNE and 
  emprunt.codeBar=exemplaire.codeBar and exemplaire.ISBN=livre.ISBN and livre.codeDis=discipline.codeDis 
  and etudiant.CNE LIKE'%{$cne}%'";
  $result = mysqli_query($conn, $sql);
  }
?>

    <div class="container">  
    <form action="" method="get">
        <div class="search_cat">
            <ul>
                <li><a name="mois" href="mesempruntes.php?m">Ce mois</a></li>
                <li><a name="semain" href="mesempruntes.php?s">Cette semaine</a></li>
            </ul>
        </div>
        </form>
               
        <div class="cont" style="margin-top: 20px;margin-bottom:15px;">
        </div>
        <form action="" method="get">
       <div class="form_txt">
           <div class="rech">
               <h2>Mes emprunts : </h2>
               <button name="sort" style="cursor:pointer;"><i class="fas fa-sort">trier par date</i></button>
               
           </div>
       </div>
       </form>
        <div style="overflow-x: auto;overflow-y:auto;">
<table>
    <thead>
        <tr>              
            <td>Code Emprunt</td>
            <td>ISBN livre</td>
            <td>Titre livre</td>
            <td>Categorie</td>
            <td>Date debut</td>
            <td>Date fin</td>
            <td>voir les details</td>
        </tr>
    </thead>
    <tbody>
    <?php
    if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
            echo"<tr><td>".$row["codeEmprunt"]."</td><td>".$row["ISBN"]."</td><td>".$row["titreLiv"]."</td><td>".$row["libelleDis"]."</td><td>".$row["dateDebut"]."</td><td>".$row["dateFin"]."</td><td><a href=\"mesempruntes.php?code=".$row["codeEmprunt"]."&titre='".$row['titreLiv']."'&dd='".$row['dateDebut']."'&cat='".$row['libelleDis']."'\"><i class='fas fa-info'></i></a></td></tr>";
            }
    }else{
        echo "<h3 id='er'> Vous n'avez aucun emprunte. </h3>";
    }
       
    ?>
    <tr><td colspan="8"><?php echo "Le nombres des empruntes est : ", mysqli_num_rows($result); ?></td></tr>
    </tbody>
    </table>
    
  </div>
</div> 


 <script>
       <?php
       if($_GET['code'])
       {
       ?>
       swal({
  title: "Votre Emprunte numero : "+<?php echo $_GET['code']; ?>,
  text: "fait le : "+<?php echo $_GET['dd']; ?>+"\n Titre : "+<?php echo $_GET['titre'] ?>+
  "\n Categorie : "+<?php echo $_GET['cat'] ?>,
  button: "ok",
});
       <?php
       } 
       ?>
   </script>
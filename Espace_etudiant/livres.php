<?php include('header.php'); 
$chaine="";
$msg="";
$isbn="";
if(isset($_GET['search']))
{ 
    $isbn = $_GET['inputsearch'];
    $chaine = strval($isbn);    
    $sql = "select livre.ISBN,livre.titreLiv,auteur.nomAut,auteur.prenomAut,discipline.libelleDis,exemplaire.codeBar from exemplaire,livre,rediger,auteur,discipline where exemplaire.ISBN=livre.ISBN and livre.ISBN=rediger.ISBN and auteur.codeAut=rediger.codeAut and livre.codeDis=discipline.codeDis and (auteur.nomAut LIKE'%{$chaine}%' or exemplaire.ISBN LIKE '%{$isbn}%' or discipline.libelleDis LIKE'%{$chaine}%' or livre.titreLiv LIKE'{$chaine}') and etatEx = 0";
    $result = mysqli_query($conn, $sql);
    
}
else
{
    $sql = "select livre.ISBN,livre.titreLiv,auteur.nomAut,auteur.prenomAut,discipline.libelleDis,exemplaire.codeBar from exemplaire,livre,rediger,auteur,discipline where exemplaire.ISBN=livre.ISBN and livre.ISBN=rediger.ISBN and auteur.codeAut=rediger.codeAut and livre.codeDis=discipline.codeDis and etatEx = 0";
    $result = mysqli_query($conn, $sql);
}
if(isset($_GET['sort'])){
    $sql = "select livre.ISBN,livre.titreLiv,auteur.nomAut,auteur.prenomAut,discipline.libelleDis,exemplaire.codeBar from exemplaire,livre,rediger,auteur,discipline where exemplaire.ISBN=livre.ISBN and livre.ISBN=rediger.ISBN and auteur.codeAut=rediger.codeAut and livre.codeDis=discipline.codeDis and etatEx = 0 order by livre.titreLiv asc";
    $result = mysqli_query($conn, $sql);    
}
?>
<div class="container">  
        
        <div class="search_cat">
            <ul>
                <li><a href="livres.php?inputsearch=Informatique&search=">Informatique</a></li>
                <li><a href="livres.php?inputsearch=Mathématiques&search=">Mathématiques</a></li>
                <li><a href="livres.php?inputsearch=Géologie&search=">Géologie</a></li>
                <li><a href="livres.php?inputsearch=Physique&search=">Physique</a></li>
                <li><a href="livres.php?inputsearch=Chimie&search=">Chimie</a></li>
            </ul>
        </div>
               <form method="get" action="">
        <div class="cont" style="margin-top: 20px;margin-bottom:15px;">
        </div>
        
       <div class="form_txt">
           <div class="rech">
               <h2>Livres disponible : &nbsp; <?php echo $isbn;?></h2>
               <h3 id="er"> <?php echo $msg; ?> </h3>
               <button name="sort" style="cursor:pointer;"><i class="fas fa-sort">&nbsp;&nbsp;trié par ordre alphabétique</i></button>
               
           </div>
       </div>
       </form>
        <div style="overflow-x: auto;overflow-y:auto;">
<table>
    <thead>
        <tr>              
            <td>ISBN</td>
            <td>Titre</td>
            <td>Nom Auteur</td>
            <td>Prénom Auteur</td>
            <td>Discipline</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
    <?php
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo"<tr><td>".$row["ISBN"]."</td><td>".$row["titreLiv"]."</td><td>".$row["nomAut"]."</td><td>".$row["prenomAut"]."</td><td>".$row["libelleDis"]."</td><td><a href=\"emprunte.php?codebar=".$row["codeBar"]."\" class='edit'><i class='fas fa-folder-plus'></i></a></td></tr>";
            
        }
        
    }else
    {
           echo '<h3 id="er"> il ya aucun resultat. </h3>';
    }
    
    ?>
     <tr><td colspan="8"><?php echo "Le nombres des livres est : ", mysqli_num_rows($result); ?></td></tr>
    
    </tbody>
    </table>
  </div>
</div> 
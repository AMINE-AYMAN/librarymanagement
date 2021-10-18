<?php 
include('header.php'); 

if(isset($_GET['btv'])){
    header('location: livres.php');
}
if(isset($_GET['search']))
{ 
    $rec = "insert into rechercheparjour VALUES()";
    mysqli_query($conn, $rec);
    header('location: livres.php?inputsearch='.$_GET['inputsearch'].'&search=');
}
?><form action="" method="get">
<div class="main">
       <div class="main_txt">
           <h1>Bibliotheque fs eljadida ucd</h1>
           <h3>Rechercher un ou plusieurs livres</h3>
       </div>
       
       <div class="main_search">
           
           <div class="bar_search">
               <center>
               <input type="text" name="inputsearch" id="txt" placeholder="ISBN, Auteur, Catégorie, Titre..." required>
               <button class="icon" name="search"><a href="resultatlivre.html"><i class="fas fa-search"></i></a></button>
               </center>
            </div>
        
           <div class="desc_search">
               <h4><span>Recherche par :</span> ISBN, titre, mot clé, auteur, catégorie ...</h4>
           </div>
           <div class="btn_search">
               <a id="btv" href="livres.php">Liste des livres</a>
               <input type="reset" id="bta" value="Annuler">
               
           </div>
        
       </div>
    
    </div>
</form>
    <div class="head_emp">
        <ul>
            <li class="activ"><a href="#" >Choisir votre catégorie préféré..</a></li>
        </ul>
    </div>
    
    <div class="container1" id="c"> 
        <div class="main_con">
            <a href="livres.php?inputsearch=Informatique&search=">
             <div class="bloc_cont">
           <img src="images/pexels-stas-knop-3760323.jpg" class="img" alt="">
           <div class="mask">
             <h2>Informatique</h2>
            </div>
        </div>
          </a>
          <a href="livres.php?inputsearch=Mathématiques&search=">
        <div class="bloc_cont">
            <img src="images/pexels-ugurlu-photographer-336407.jpg" class="img" alt="">
            <div class="mask">
                <h2>Mathématiques</h2>
               </div>
        </div>
    </a>
    <a href="livres.php?inputsearch=Géologie&search=">
        <div class="bloc_cont">
            <img src="images/pexels-pixabay-267586.jpg" class="img" alt="">
            <div class="mask">
                <h2>Géologie</h2>
               </div>
        </div>
        </div>
    </a>
        <div class="main_con">
        <a href="livres.php?inputsearch=Physique&search=">
            <div class="bloc_cont">
          <img src="images/pexels-lumn-327882.jpg" class="img" alt="">
          <div class="mask">
            <h2>Physique</h2>
           </div>
       </div>
    </a>
    <a href="livres.php?inputsearch=Chimie&search=">
       <div class="bloc_cont">
           <img src="images/pexels-pixabay-415071.jpg" class="img" alt="">
           <div class="mask">
               <h2>Chimie</h2>
              </div>
       </div>
    </a>
    <a href="livres.php?inputsearch=Mathématiques&search=">
       <div class="bloc_cont">
           <img src="images/pexels-victor-448835.jpg" class="img" alt="">
           <div class="mask">
               <h2>PHYSIQUE</h2>
              </div>
       </div>
       </div>
    </a>
    </div>
    

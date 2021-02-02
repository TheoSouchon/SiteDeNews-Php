<!DOCTYPE html>
<head lang="fr">


    <meta content="text/html" name="viewport" charset= UTF-8" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Site blog</title>
    <link rel="stylesheet" href="vues/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="vues/css/DetailArticle.css">
</head>

<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fa fa-home"></i>
          Accueil
          <span class="sr-only">(current)</span>
          </a>
      </li>
        <?php

        if($role=="Visiteur"){
            echo "
                  <li class='nav-item active'>
        <a class='nav-link' href='index.php?action=connection'>
          <i class='fa fa-fw fa-user'></i>
          Se connecter
          <span class='sr-only'>(current)</span>
          </a>
      </li>
      
      <li class='nav-item active'>
        <a class='nav-link' href='index.php?action=connection'>
          <i class='fa fa-pencil fa-fw'></i>
          Poster un article
          <span class='sr-only'>(current)</span>
          </a>
      </li>
            ";
        }
        else{

            echo "
                  <li class='nav-item active'>
        <a class='nav-link' href='index.php?action=Deconnexion'>
          <i class='fa fa-fw fa-user'></i>
          Se deconnecter
          <span class='sr-only'>(current)</span>
          </a>
      </li>
      
      <li class='nav-item active'>
        <a class='nav-link' href='index.php?action=creerArt'>
          <i class='fa fa-pencil fa-fw'></i>
          Poster un article
          <span class='sr-only'>(current)</span>
          </a>
      </li>
        ";}
        ?>
      <form class="form-inline my-2 my-lg-0">
      <input class="inputdate" id='dateofarticle' name='DateCherche' type="date" placeholder="Rechercher par date" aria-label="Search">
          <button type='submit'  value='chercher' name='action'><i class="fa fa-search"></i></button>
    </form>
    </ul>
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="nav-link" href="">
          <i class="fa fa-newspaper-o">
          </i>
            <?php if(isset($nbArticle)){echo "Articles : $nbArticle";}else{ if(isset($nbArt)){ echo "Articles : $nbArt";}}?>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="">
          <i class="fa fa-comment-o">
          </i>
          <?php if(isset($nbcoms)){echo "Commentaires : $nbcoms";}else{ if(isset($nbCom)){ echo "Commentaires : $nbCom";}} ?>
        </a>
      </li>
    </ul>
  </div>
</nav>
<div class="contient_articles">
<?php

    if (isset($News)) {
    if(!empty($News)) {
    foreach ($News as $value) {

    $testeart=Validation::CouperTexte($value->Texte,500);
        $T= html_entity_decode($testeart);
        if($role=="Admin"){

            echo "
 <button class=pull-right><a href='index.php?action=SupprimerArt&Id_Art=$value->idArt' id='bouttonsup'>Supprimer l'article</a></button>
    <a href='index.php?action=cliquernew&Id_Art=$value->idArt'>
   
  
		<h2 class='titre'>$value->Titre</h2>
		<h4><p class = 'auteur'>Auteur :  $value->Auteur</p></h4>
	<p class='contenu_article'>$T</p>
	<div class ='date'>Posté le : $value->DatePub</div><br>
</a>
<hr>
<br>
    ";
        }
        else{
            echo "
    <a href='index.php?action=cliquernew&Id_Art=$value->idArt'>
		<h2 class='titre'>$value->Titre</h2>
		<h4><p class = 'auteur'>Auteur :  $value->Auteur</p></h4>
	<p class='contenu_article'>$T</p>
	<div class ='date'>Posté le : $value->DatePub</div><br>
</a>
<hr>
<br>
    ";
        }

    }
    }
    else {
    echo"Aucun article pour la date choisie";
    }

    }
    else  {
    echo'pb';
    }

?>


<div class="pagination">

<?php
if(!isset($_GET['DateCherche'])) {
    if ($currentPage > 1 and $nb_pages > 1) {
        $s = $currentPage - 1;
        $page = "index.php?page=" . $s . "";

        echo "<li class='page-item'><a class='page-link' href='$page' tabindex='-1'>Précedent</a></li>";
    }
    if ($nb_pages > 1) {
        if($currentPage!=1){
            echo "<li class='page-item'><a class='page-link' href='index.php?page=1'>1</a></li>";
        }



        echo '  ' ."<li class='page-item active'><a class='page-link' href=''>$currentPage<span class='sr-only'>(current)</span></a></li>". ' ';



        if ($currentPage < $nb_pages) {
            $pagefinale = "index.php?page=" . $nb_pages . "";
            echo "<li class='page-item'><a class='page-link' href='$pagefinale'>$nb_pages</a></li>";
            $dd = $currentPage + 1;
            $suivant = "index.php?page=" . $dd . "";
            echo "<li class='page-item'><a class='page-link' href='$suivant'>Suivant</a></li>";
        } else {
            if ($nb_pages == 1) {
                echo "1 page";
            }
        }
    }
}
else {
    $date=$_GET['DateCherche'];
    if ($currentPage > 1 and $nb_pages > 1) {
        $s = $currentPage - 1;
        $page = "index.php?DateCherche=" . $date . "&action=chercher&page=".$s;


        echo "<li class='page-item'><a class='page-link' href='$page' tabindex='-1'>Précedent</a></li>";
    }
    if ($nb_pages > 1) {
        if($currentPage!=1){
            $pagea = "index.php?DateCherche=" . $date . "&action=chercher&page=1";
            echo "<li class='page-item'><a class='page-link' href='$pagea'>1</a></li>";
        }



        echo '  ' ."<li class='page-item active'><a class='page-link' href=''>$currentPage<span class='sr-only'>(current)</span></a></li>". ' ';



        if ($currentPage < $nb_pages) {

            $pagefinale = "index.php?DateCherche=" . $date . "&action=chercher&page=".$nb_pages;
            echo "<li class='page-item'><a class='page-link' href='$pagefinale'>$nb_pages</a></li>";
            $dd = $currentPage + 1;
            $suivant = "index.php?DateCherche=" . $date . "&action=chercher&page=".$dd;
            echo "<li class='page-item'><a class='page-link' href='$suivant'>Suivant</a></li>";
        } else {
            if ($nb_pages == 1) {
                echo "1 page";
            }
        }
    }


}



?>


</div>
</div>




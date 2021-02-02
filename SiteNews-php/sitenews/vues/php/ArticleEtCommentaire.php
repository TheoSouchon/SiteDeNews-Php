
<!DOCTYPE html>
<html lang="fr">
<head lang="fr">
    <meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Site blog</title>
    <link rel="stylesheet" href="vues/css/PageAccueil.css">
    <link rel="stylesheet" href="vues/css/DetailArticle.css">
    <link rel="stylesheet" href="vues/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="vues/css/DetailArticle.css">
    <script type="text/javascript" src="vues/js/VerifCommentaire.js"></script>
</head>

<body >
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
                    <?php if(isset($nbArt)){ echo "Articles : $nbArt";}?>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fa fa-comment-o">
                    </i>
                    <?php if(isset($nbCom)){ echo "Commentaires : $nbCom";} ?>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="contient_articles_pageentier">
    <?php
    header("Content-Type: text/html; charset=utf-8");
    if(isset($art)) {
$texte= html_entity_decode($art->Texte);
        echo "
    <a href='index.php?action=cliquernew&Id_Art=$art->idArt'>	
		<h2 class='titre'>$art->Titre</h2>
		<h4><p class = 'auteur'>Auteur :  $art->Auteur</p></h4>
	<p class='contenu_article'>$texte</p>
	<div class ='date'>Posté le : $art->DatePub</div><br>
</a>
    ";
    }
    else {
        echo'pb';
    }
    ?>

    <?php



    $pseudo=$login;
echo "<hr>
        <h1>Poster un commentaires</h1>
    <form method='post' name='test' onsubmit='return verif_champ(document.test.MessageCommentaire.value)&&verif_champ(document.test.PseudoPersonne.value);'>
        <div class='form-group'>
            <label for='exampleFormControlInput1'>Pseudo :</label><br>";

                if($login=""){
                    echo "<input name='PseudoPersonne' class='inputPseudo' type='text' class='form-control' placeholder='Entrez votre pseudo' >";
                }elseif($role=="Visiteur"){
                    echo "<input name='PseudoPersonne' class='inputPseudo' type='text' class='form-control' value='$pseudo' >";
                }else{
                  echo  "<input name='PseudoPersonne' class='inputPseudo' type='text' class='form-control' value='$pseudo' readonly>";
                }

                echo"
        </div>

        <div class='form-group'>
            <label for='exampleFormControlTextarea1'>Commentaire :</label>
            <textarea name='MessageCommentaire'  class='texteCommentaire' class='form-control'  id='exampleFormControlTextarea1' rows='3' placeholder='Mettez ce que vous avez sur le coeur'></textarea>
        </div>
        <button type='submit'  value='PosterCommentaire' name='action'  class='btn btn-success'>Poster</button>
    </form>
     <br>
     <br>
"

?>



    <?php

    if(isset($tab)) {
        foreach ($tab as $value) {
            $texte=Validation::prepTailleTexte($value->Texte,50);
            echo "
    <div class='wrapper'>
        <div class='card radius shadowDepth1'>
            <div class='card__image border-tlr-radius'>
                <div class='card__content card__padding'>
                    <div class='card__meta'>
                        <a href=''>$value->Pseudo</a>
                        
                    </div>
                    <article class='card__article'>
                        <p>$texte</p>
                    </article>
                </div>
            </div>
        </div>
    </div>
    ";
        }
    }
    else {
    echo'pb';}

    ?>
</div>
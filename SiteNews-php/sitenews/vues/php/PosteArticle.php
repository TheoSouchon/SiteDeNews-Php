<!DOCTYPE html>
<html>
<head lang="fr" >
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Site blog</title>
    <link rel="stylesheet" href="vues/css/PosteArticle.css">
    <link rel="stylesheet" href="vues/css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="vues/css/PosteArticleBB.css">
    <script src="js.js"></script>
    <script type="text/javascript" src="js.js"></script>
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

<div id="contact-form">
    <div>
        <h1>Poster un nouvel article</h1>
        <h4></h4>
    </div>

    <form method="post">
        <div>
            <label>
                <span class="required">Donnez un titre à votre article : </span>
                <input id="textearticle" name="TitreArticle" value="" placeholder="Ecrivez le titre de votre article" tabindex="2" required="required" />
            </label>
        </div>

        <div>
            <label for="message">
                <span class="required">Contenu de votre article :</span>
                <p>&nbsp;</p>
                <textarea name="TexteArticle" id="message" placeholder="Ecrivez votre article ici" tabindex="5" required="required"></textarea>
            </label>
        </div>
        <div>
            <button type="submit" name="action" value="AjoutArt" >Poster l'article</button>
        </div>
    </form>

</div>
</body>


</html>
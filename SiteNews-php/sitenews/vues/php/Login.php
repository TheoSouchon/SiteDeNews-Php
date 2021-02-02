<!DOCTYPE html>
<html lang="fr">
<head lang="fr">
    <meta content="text/html; charset=UTF-8"  name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Se connecter</title>
    <link rel="stylesheet" href="vues/css/navbar.css">
    <link rel="stylesheet" href="vues/css/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="vues/css/DetailArticle.css">
    <script type="text/javascript" src="vues/js/VerifCommentaire.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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


    <div class="card card-container">

        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form method="post" name="formulaireconnexion" class="form-signin" onsubmit='return verif_champ(document.formulaireconnexion.login.value)&&verif_champ(document.formulaireconnexion.motDePasse.value);'>
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" NAME="login" id="inputEmail" class="form-control" placeholder="Identifiant"  autofocus>
            <input type="password" NAME="motDePasse" id="inputPassword" class="form-control" placeholder="Mot de passe">
            <div id="remember" class="checkbox">

            </div>
            <button type="submit" name="action" value="SeConnecter" class="btn btn-success">Se connecter</button>
        </form><!-- /form -->
        <a href="#" class="forgot-password">
            Mot de passe oublié ?
        </a>
        <?php
        if (isset($CodeConnection)) {
            if($CodeConnection==0) {
                echo"Identifiant ou mot de passe incorrect";
            }
        }
        ?>
    </div>

</body>
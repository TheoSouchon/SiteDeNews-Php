    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'erreur</title>
        <link href="vues/css/Erreur.css" rel="stylesheet">

    </head>

<body>
<div id="clouds">
    <div class="cloud x1"></div>
    <div class="cloud x1_5"></div>
    <div class="cloud x2"></div>
    <div class="cloud x3"></div>
    <div class="cloud x4"></div>
    <div class="cloud x5"></div>
</div>
<div class='c'>
    <div class='_404'>Erreur</div>
    <hr>
    <?php
    if(!isset($codeErreur)){
        $codeErreur="Une erreure s'est produite";
    }
    echo "<div class='_1'>$codeErreur</div>"
    ?>
    <div class='_2'> </div>
    <a class='btn' href='index.php'>Revenir à l'accueil</a>
</div>


</body>

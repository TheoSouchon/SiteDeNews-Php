<?php
require ("Connection.php");

// liste des modules a inclure
$dConfig['includes']=array('Validation.php');

//BD
$user= 'root';
$pass='';
$dsn='mysql:host=localhost;dbname=projetphp;charset=utf8';
$con=new Connection($dsn,$user,$pass);

//Vues pour UserControl
$vues['PageAccueil']='vues/php/PageAccueil.php';
$vues['erreur']='vues/php/Erreur.php';
$vues['DetailArt']='vues/php/ArticleEtCommentaire.php';
$vues['login']='vues/php/Login.php';
$vues['PosteArticle']='vues/php/PosteArticle.php';


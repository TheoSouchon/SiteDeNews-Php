<?php

class UserControl
{
    function __construct() {

        global $vues;
        try {
            $action = $_REQUEST['action'] ?? NULL;
            switch ($action) {
                case NULL: //Cas où c'est un visiteur (première visite)
                    $this->casNull();
                    break;

                case "cliquernew" :
                    $this->casCliquerNew();
                    break;

                case "chercher" :
                    $this->casChercher();
                    break;

                case "connection" : //page connection
                    $this->casConnexion();
                    break;

                case "SeConnecter" : //action de se connecter (depuis la page connexion)
                    $this->casSeConnecter();
                    break;

                case "PosterCommentaire":
                    $this->casPosterCommentaire();
                    break;

                default:
                    $this->casDefault();
                    break;
            }
        }
        catch (PDOException $e)
		{
            $codeErreur = $e;
            require_once($vues['erreur']);
        }
		catch (Exception $e2)
		{
            $codeErreur = $e2;
            require ($vues['erreur']);
        }
	}

	/*
	 * Fonctions appelées du constructeur de UserControl
	 * ==============================================
	 * @function casNull()
	 * @function casCliquerNew()
	 * @function casChercher()
	 * @function casConnexion()
	 * @function casSeConnecter()
	 * @function casPosterCommentaire()
	 * @function casDefault()
	 */

	function casNull() {
        global $vues;
        $nbCom=$this->GetNbrCookie();
        $nbArt=$this->NbNews();
        $currentPage=Validation::prepPageActuelle();
        $parPage=2;
        $nb_pages=ceil($nbArt/$parPage);
        $premier = ($currentPage * $parPage) - $parPage;
        $News=$this->ArtPagination($premier,$parPage);
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        require_once($vues['PageAccueil']);
    }


    function casCliquerNew() {
        global $vues;
        $nbArt=$this->NbNews();
        $nbCom=$this->GetNbrCookie();
        $art=$this->cliquerNews();
        $tab=$this->cliquerNews_Com();
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        require_once($vues['DetailArt']);
    }

    function casChercher() {
        global $vues;
        $nbArt=$this->NbNews();
        $nbArticle=$this->NbNews();
        $nbCom=$this->GetNbrCookie();
        $nbArt=$this->NbNewsDate();
        $currentPage=Validation::prepPageActuelle();
        $parPage=1;
        $nb_pages=ceil($nbArt/$parPage);
        $premier = ($currentPage * $parPage) - $parPage;
        $News=$this->rechercheNewsPage($premier,$parPage);
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        require_once($vues['PageAccueil']);
    }

    function casConnexion() {
        global $vues;
        $role=ModelAdministrator::isAdmin();
        $nbArt=$this->NbNews();
        $nbCom=$this->GetNbrCookie();
        require_once($vues['login']);
    }

    function casSeConnecter() {
        global $vues;
        $nbArt=$this->NbNews();
        $nbCom=$this->GetNbrCookie();
        $CodeConnection=$this->VerifCompte();
        $role=ModelAdministrator::isAdmin();
        if($CodeConnection==0) {
            require_once($vues['login']);
        }
        else {
            header("location: index.php");
        }
    }

    function casPosterCommentaire() {
        $nbArt=$this->NbNews();
        $nbCom=$this->GetNbrCookie();
        $role=ModelAdministrator::isAdmin();
        $this->ajoutCommentaire();
        header("location:".  $_SERVER['HTTP_REFERER']);
    }

    function casDefault() {
        global $vues;
        $codeErreur = "Erreur dans l'URL";
        require($vues['erreur']);
    }

    /*
     * Fonctions appelées de celles présentes dans le constructeur (celles plus haut)
     * ==============================================================================
     * @cliquerNews()
     * @cliquerNews_Com()
     * @VerifCompte()
     * @ajoutCommentaire()
     * @NbNews()
     * @NbNewsDate()
     * @ArtPagination($premierArt,$artParPage)
     *      @param $premierArt : premier article de la page actuelle
     *      @param $premierArt : nombre d'article par page à afficher
     * @rechercheNewsPage(int $premiereNews,int $NbNews)
     *      @param $premiereNews : premier actuelle de la page actuelle pour la date cherché
     *      @param $NbNews : nombre d'article par page à afficher
     */

    function cliquerNews() {
        $model=new modelArticle();
        $idArt=$_GET['Id_Art'];
        return $model->getDetailsArt($idArt);
    }

    function cliquerNews_Com() {
        $model=new modeleCommentaire();
        $idArt=$_GET['Id_Art'];
        return $model->getCommArt($idArt);
    }

    function VerifCompte() {
        $model=new modelAdministrator();
        $login=$_POST['login'];
        $mdp=$_POST['motDePasse'];
        if(isset($login) && isset($mdp)){
            $login=Validation::Nettoyer_string($login);
            $mdp=Validation::Nettoyer_string($mdp);
        }
        $codeCon=$model->getCodeVerifCompte($login,$mdp);
        if($codeCon==1) {
            $_SESSION['login']=$login;
            $_SESSION['role']="Admin";
        }
        return $codeCon;
    }

    function ajoutCommentaire() {
        $model=new modeleCommentaire();
        $texte=$_POST['MessageCommentaire'];
        $pseudo=$_POST['PseudoPersonne'];
        $idart=$_GET['Id_Art'];
        $model->setNewCom($texte,$pseudo,$idart);

    }

    function GetNbrCookie(){
        $model=new modeleCommentaire();
        return $model->getNbrCookie();
    }

    function NbNews() {
        $model=new modelArticle();
        return $model->getAllnews();
    }

    function ArtPagination(int $premierArt, int $artParPage) {
        $model=new modelArticle();
        return $model->getArtPage($premierArt,$artParPage);
    }

    function NbNewsDate() {
        $model=new modelArticle();
        $date=$_GET['DateCherche'];
        return $model->getNbNewsDate($date);
    }

    function rechercheNewsPage(int $premiereNews,int $NbNews) {
        $model=new modelArticle();
        $date=$_GET['DateCherche'];
        return $model->DateNewsPage($premiereNews,$NbNews,$date);
    }
}
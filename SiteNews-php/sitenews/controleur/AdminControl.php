<?php


class AdminControl
{
    function __construct() {

        global $vues;
        try {
            $action = $_REQUEST['action'] ?? NULL;
            switch ($action) {
                case NULL: //Cas où c'est un admin (sur la page d'accueil)
                    $this->casNull();
                    break;

                case "cliquernew" :
                    $this->casCliquerNew();
                    break;

                case "chercher" :
                    $this->casChercher();
                    break;

                case "creerArt":
                    $this->casCreerArt();
                    break;

                case "AjoutArt":
                    $this->casAjoutArt();
                    break;

                case "PosterCommentaire":
                    $this->casPosterCommentaire();
                    break;

                case"Deconnexion":
                    $this->casDeconnexion();
                    break;
                case "SupprimerArt":
                    $this->casSuppArticle();
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
            $codeErreur[] = "$e2";
            require ($vues['erreur']);
        }
    }

    /*
	 * Fonctions appelées du constructeur de UserControl
	 * ==============================================
	 * @function casNull()
	 * @function casCliquerNew()
	 * @function casChercher()
	 * @function casCreerArt()
	 * @function casAjoutArt()
	 * @function casPosterCommentaire()
     * @function casDeconnexion()
	 * @function casDefault()
	 */

    function casNull() {
        global $vues;
        $nbArt=$this->NbNews();
        $nbCom=$this->Nbcoms();
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
        $nbCom=$this->Nbcoms();
        $art=$this->cliquerNews();
        $tab=$this->cliquerNews_Com();
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        require_once($vues['DetailArt']);
    }

    function casChercher() {
        global $vues;
        $nbCom=$this->GetNbrCookie();
        $nbcoms=$this->NbNews();
        $nbCom=$this->Nbcoms();
        $nbArt=$this->NbNewsDate();
        $currentPage=Validation::prepPageActuelle();
        $parPage=1;
        $nb_pages=ceil($nbArt/$parPage);
        $premier = ($currentPage * $parPage) - $parPage;
        //$News=$this->rechercheNews();
        $News=$this->rechercheNewsPage($premier,$parPage);
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        require_once($vues['PageAccueil']);

    }

    function casCreerArt() {
        global $vues;
        $role=ModelAdministrator::isAdmin();
        $nbArt=$this->NbNews();
        $nbCom=$this->Nbcoms();
        require_once($vues['PosteArticle']);
    }

    function casAjoutArt() {
        global $vues;

        $nbCom=$this->Nbcoms();
        $this->ajoutArticle();
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

    function casPosterCommentaire() {
        $role=ModelAdministrator::isAdmin();
        $nbCom=$this->Nbcoms();
        $nbArt=$this->NbNews();
        $this->ajoutCommentaire();
        header("location:".  $_SERVER['HTTP_REFERER']);
    }

    function casDeconnexion() {
        $role=ModelAdministrator::isAdmin();
        $nbCom=$this->Nbcoms();
        $nbArt=$this->NbNews();
        $this->deconnexion();
        $News=$this->RecupNews();
        header("location: index.php");
    }

    function casDefault() {
        global $vues;
        require($vues['erreur']);
    }

    function casSuppArticle(){
        $role=ModelAdministrator::isAdmin();
        $login=ModelAdministrator::isLogin();
        $this->suppArtetComentaire();
        header("location: index.php");
    }


    /*
     * Fonctions appelées de celles présentes dans le constructeur (celles plus haut)
     * ==============================================================================
     * @RecupNews()
     * @cliquerNews()
     * @cliquerNews_Com()
     * @ajoutArticle()
     * @ajoutCommentaire()
     * @deconnexion()
     * @NbNews()
     * @NbNewsDate()
     * @rechercheNewsPage()
     * @ArtPagination($premierArt,$artParPage)
     *      @param $premierArt : premier article de la page actuelle
     *      @param $premierArt : nombre d'article par page à afficher
     * @rechercheNewsPage(int $premiereNews,int $NbNews)
     *      @param $premiereNews : premier actuelle de la page actuelle pour la date cherché
     *      @param $NbNews : nombre d'article par page à afficher
     */

    function suppArtetComentaire()
    {
        $idArt=$_GET['Id_Art'];
        $model = new modelArticle();
        $model->SupprimerNewsetCom($idArt);
    }

    function GetNbrCookie(){
        $model=new modeleCommentaire();
        return $model->getNbrCookie();
    }

    function RecupNews() {
        $model=new ModelArticle();
        return $model->Allnews();
    }

    function cliquerNews() {
        $model=new ModelArticle();
        $idArt=$_GET['Id_Art'];
        return $model->getDetailsArt($idArt);
    }

    function cliquerNews_Com() {
        $model=new ModeleCommentaire();
        $idArt=$_GET['Id_Art'];
        return $model->getCommArt($idArt);
    }

    function ajoutArticle() {
        $model=new ModelArticle();
        $Titre=$_POST['TitreArticle'];
        $auteur=$_SESSION['login'];
        $Text=$this->bbcode($_POST['TexteArticle']);
        $model->setNewArt($Titre,$auteur,$Text);
    }

    function bbcode($string):string{
        $tags = 'b|u|i|size|color|centre|quote|url|img';
        while (preg_match_all('`\[('.$tags.')=?(.*?)\](.+?)\[/\1\]`', $string, $matches)) foreach ($matches[0] as $key => $match) {
            list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]);
            switch ($tag) {
                case 'b': $replacement = "&lt;strong&gt;$innertext&lt;/strong&gt;"; break;
                case 'u': $replacement = "&lt;span style=\"text-decoration: underline;\"&gt;$innertext&lt;/span&gt;"; break;
                case 'i': $replacement = "&lt;em>$innertext&lt;/em&gt;"; break;
                case 'size': $replacement = "&lt;span style=\"font-size: $param;\"&gt;$innertext&lt;/span&gt;"; break;
                case 'color': $replacement = "&lt;span style=\"color: $param;\"&gt;$innertext&lt;/span&gt;"; break;
                case 'centre': $replacement = "&lt;div class=\"centered\"&gt;$innertext&lt;/div&gt;"; break;
                case 'quote': $replacement = "&lt;blockquote&gt;$innertext&lt;/blockquote&gt;" . $param? "&lt;cite&gt;$param&lt;/cite&gt;" : ''; break;
                case 'url': $replacement = '&lt;a href="' . ($param? $param : $innertext) . "\"&gt;$innertext&lt;/a&gt;"; break;
                case 'img':
                    list($width, $height) = preg_split('`[Xx]`', $param);
                    $replacement = "&lt;img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/&gt;';
                    break;
                case 'youtube':
                    $videourl = parse_url($innertext);
                    parse_str($videourl['query'], $videoquery);
                    if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '&lt;embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344">&lt;/embed&gt;';
                    if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '&lt;embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"&gt;&lt;/embed&gt;';
                    break;
            }
            $string = str_replace($match, $replacement, $string);
        }
        return $string;

    }


    function ajoutCommentaire() {
        $model=new ModeleCommentaire();
        $texte=$_POST['MessageCommentaire'];
        $pseudo=$_POST['PseudoPersonne'];
        $idart=$_GET['Id_Art'];
        $model->setNewCom($texte,$pseudo,$idart);
    }

    function deconnexion() {
        $model=new ModelAdministrator();
        $model->seDeconnecter();
    }


    function NbNews() {
        $model=new modelArticle();
        return $model->getAllnews();
    }

    function Nbcoms(){
        $model = new modeleCommentaire();
        return$model->getNbrCookie();
    }

    function ArtPagination($premierArt,$artParPage) {
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
<?php

class modelArticle
{
    public function setNewArt(string $Titre,string $auteur,string $text) {
        global $con;
        $Titre=Validation::Nettoyer_string($Titre);
        $auteur=Validation::Nettoyer_string($auteur);
        $text=Validation::Nettoyer_string($text);
        $gtwUser= new GatewayArticle($con);
        $newId=$gtwUser->CheckLastIdArt()+1;
        $gtwUser->InsertArtBD($Titre,$auteur,$text,$newId);
    }

    public function getDetailsArt(int $idart) {
        global $con;
        $idart=Validation::Nettoyer_int($idart);
        $gtwUser= new GatewayArticle($con);
        return $gtwUser->DetailsArticle($idart);
    }

    public function Allnews() {
        global $con;
        $gtwUser= new GatewayArticle($con);
        return $gtwUser->rechercheTousLesArticles();
    }

    public function getAllnews() {
        global $con;
        $gtwUser= new GatewayArticle($con);
        return $gtwUser->getnbart();
    }

    public function getArtPage(int $premierArt,int $artParPage) {
        global $con;
        $premierArt=Validation::Nettoyer_int($premierArt);
        $artParPage=Validation::Nettoyer_int($artParPage);
        $gtwArt=new GatewayArticle($con);
        return $gtwArt->ArtdePage($premierArt,$artParPage);
    }

    public function getNbNewsDate(string $date) {
        global $con;
        $date=Validation::Nettoyer_string($date);
        $gtwUser= new GatewayArticle($con);
        return $gtwUser->getnbartDate($date);
    }

    public function SupprimerNewsetCom(int $id){
        global $con;
        $id=Validation::Nettoyer_int($id);
        $gtwArt=new gatewayArticle($con);
        return $gtwArt->SupprimerArticleEtCommentaires($id);
    }

    public function DateNewsPage(int $premiereNews,int $NbNews,string $date) {
        global $con;
        $premiereNews=Validation::Nettoyer_int($premiereNews);
        $NbNews=Validation::Nettoyer_int($NbNews);
        $date=Validation::Nettoyer_string($date);
        $gtwUser= new GatewayArticle($con);
        return $gtwUser->rechercheParDatePage($premiereNews,$NbNews,$date);
    }
}
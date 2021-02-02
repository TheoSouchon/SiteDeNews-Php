<?php

class modeleCommentaire
{

    public function setNewCom(string $texte,string $pseudo,string $idArt) {
        global $con;
        $texte=Validation::Nettoyer_string($texte);
        $pseudo=Validation::Nettoyer_string($pseudo);
        $idArt=Validation::Nettoyer_string($idArt);
        $_SESSION['login']=$pseudo;
        $gtwUser= new gatewayCommentaire($con);
        $gtwUser->InsertComBD($texte,$pseudo,$idArt);
        $this->augementerCookie();
    }



    public function getCommArt(int $idart) {
        global $con;
        $idart=Validation::Nettoyer_int($idart);
        $gtwUser= new gatewayCommentaire($con);
        return $gtwUser->DetailsArticle_Coms($idart);
    }

    public function augementerCookie(){
        setcookie('nbrmsg',$this->getNbrCookie()+1,time()+365*24*3600);
    }

    public function getNbrCookie():int{
        if(!isset($_COOKIE['nbrmsg'])){
            setcookie('nbrmsg', '0',time()+300000);
        }
        $nbCokkie=Validation::Nettoyer_int($_COOKIE['nbrmsg']);
        return intval($nbCokkie);
    }
}
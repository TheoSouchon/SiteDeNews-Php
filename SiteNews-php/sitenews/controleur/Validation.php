<?php


class Validation
{

    static function Nettoyer_string($string){
        return filter_var($string,FILTER_SANITIZE_STRING);
    }

    static function Nettoyer_int($string){
        return filter_var($string,FILTER_SANITIZE_NUMBER_INT);
    }

    static function prepSession(){
        if(session_status() == PHP_SESSION_NONE) {
            session_start();

            if(!isset($_SESSION['login']))
            {
                $_SESSION['login']="";
            }

            if(!isset($_SESSION['role']))
            {
                $_SESSION['role']="Visiteur";
            }
        }
    }

    static function prepTailleTexte(string $texte,int $occurence) :string
    {
        $NouvelleChaine="";


        for ($i = $occurence; $i < (strlen($texte)) ; $i=$i+$occurence) {
            $deb = $i - $occurence;
            $NouvelleChaine = $NouvelleChaine . ($des = substr($texte, $deb, $occurence) . '<br>');

            $nbrmax=$i;
        }
        if(strlen($texte)%$occurence!=0){
            $NouvelleChaine = $NouvelleChaine. $ds = substr($texte,-(strlen($texte)%$occurence));

        }

        if(strlen($texte)%$occurence==0){
            $NouvelleChaine = $NouvelleChaine. $ds = substr($texte,-($occurence));
        }

        return $NouvelleChaine;
    }

    static function CouperTexte(string $texte,int $nbr) :string
    {
           $Chaine=substr($texte,0,$nbr)."<strong> ...</strong>";
           return $Chaine;
    }

    static function prepPageActuelle(){
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }
        return $currentPage;
    }

}
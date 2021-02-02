<?php

class modelAdministrator
{
    public function getCodeVerifCompte(string $login, string $mdp) {
        global $con;
        $gtwUser= new GatewayAdmin($con);
        $login=Validation::Nettoyer_string($login);
        $mdp=Validation::Nettoyer_string($mdp);
        return $gtwUser->CheckVerifCompte($login,$mdp);
    }

    public function seDeconnecter() {
        session_unset();
        session_destroy();
        $_SESSION = array();
        Validation::prepSession();
    }

    public static function isAdmin() {
        if(isset($_SESSION['role'])) {
            $status=Validation::Nettoyer_string($_SESSION['role']);
            if($status=="Admin"){
                return "Admin";
            }
            else return "Visiteur";
        }
        else return "Visiteur";
    }

    public static function isLogin() {
            if(isset($_SESSION['login'])) {
                $login=Validation::Nettoyer_string($_SESSION['login']);
                return $login;

            }
            return null;
    }
}
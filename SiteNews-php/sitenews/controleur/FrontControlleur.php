<?php

class FrontControlleur
{

    /*
     * Les actions de la vue dépendent du role de l'utilisateur
     * Toutes les actions ne sont pas atteignable par défaut, cela dépend du role
     */

    function __construct() {
        global $vues;
        try {
            Validation::prepSession();
            $Status=ModelAdministrator::isAdmin();

            switch ($Status)
            {
                case NULL:
                    $codeErreur = "Erreur sur le rôle";
                    require($vues['erreur']);
                    break;

                case "Admin":
                    $admin=new AdminControl();
                    break;

                case "Visiteur":
                    $visiteur=new UserControl();
                    break;

                default:
                    echo"le role est ni null, ni admin, ni user";
                    break;
            }
        }
        catch (PDOException $e) {
            $codeErreur = $e;
            require($vues['erreur']);
        }

    }

}
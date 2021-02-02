<?php

class GatewayAdmin
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function CheckVerifCompte(string $login, string $mdp) {
        $query = "SELECT mdp FROM administrator WHERE login=:login";
        $this->con->executeQuery($query, array(':login' => array($login, PDO::PARAM_STR)));
        $res = $this->con->getResults();
        foreach ($res as $row) {
            $mdp2 = $row['mdp'];
        }
        if(isset($mdp2)) {
            if(password_verify($mdp,$mdp2)){
                return 1;
            }
        }
        else return 0;
    }

}
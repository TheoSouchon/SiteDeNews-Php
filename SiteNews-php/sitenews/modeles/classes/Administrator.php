<?php


class Administrator
{
    public $login;
    public $mdp;

    public function __construct($pseudo,$motDePasse) {
        $this->login=$pseudo;
        $this->mdp=$motDePasse;
    }



}
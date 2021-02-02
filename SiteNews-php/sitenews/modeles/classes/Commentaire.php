<?php


class Commentaire
{
    public $Pseudo;
    public $Texte;
    public $idArt;

    public function __construct(string $login, string $text,int $idarticleAttach) {
        $this->Texte=$login;
        $this->Pseudo=$text;
        $this->idArt=$idarticleAttach;
    }
}
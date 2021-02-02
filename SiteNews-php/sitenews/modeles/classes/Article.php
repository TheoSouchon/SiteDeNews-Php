<?php


class Article
{
    public $Titre;
    public $Auteur;
    public $DatePub;
    public $Texte;
    public $idArt;

    public function __construct(string $Intitule, string $Source, string $DatePublication,string $Paragraphs,int $idarticle) {
        $this->Titre=$Intitule;
        $this->Auteur=$Source;
        $this->DatePub=$DatePublication;
        $this->Texte=$Paragraphs;
        $this->idArt=$idarticle;
    }
}
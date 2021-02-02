<?php


class gatewayArticle
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function CheckLastIdArt(){
        $query = "SELECT max(id) FROM article";
        $this->con->executeQuery($query);
        $res = $this->con->getResults();
        foreach ($res as $row) {
            $maxId = $row['max(id)'];
        }

        if(isset($maxId)) {
            return $maxId;
        }
        else return 0; //Si il y a pas d'article c'est donc le premier (indice 0)
    }

    public function InsertArtBD(string $titre,string $auteur,string $texte,int $idArt) {
        $DatePub = date("Y-m-d");

        $query = "INSERT INTO ARTICLE VALUES(:titre,:DatePub,:texte,:idArt,:auteur)";

        $this->con->executeQuery($query,array(
            ":titre"=>array($titre,PDO::PARAM_STR),
            ":DatePub" => array($DatePub, PDO::PARAM_STR),
            ":texte" => array($texte, PDO::PARAM_STR),
            ":idArt" => array($idArt, PDO::PARAM_INT),
            ":auteur"=>array($auteur,PDO::PARAM_STR)
        ));
    }

    public function DetailsArticle(int $idArt) {
        $tabN = array();
        $query = "select * from article where id=:idArt";
        $this->con->executeQuery($query, array(':idArt' => array($idArt, PDO::PARAM_STR)));
        $res = $this->con->getResults();

        foreach ($res as $row) {
            $tabN[] = new Article($row['Titre'], $row['AuteurAttach'], $row['DatePub'], $row['Texte'], $row['id']);
        }
        return $tabN[0];
    }

    public function rechercheTousLesArticles(): array
    {
        $tabN = array();
        $query = "select * from article order by DatePub DESC";
        $this->con->executeQuery($query);
        $res = $this->con->getResults();
        foreach ($res as $row) {
            $tabN[] = new Article($row['Titre'], $row['AuteurAttach'], $row['DatePub'], $row['Texte'], $row['id']);
        }
        return $tabN;
    }

    public function getnbart() {
        $tabN = array();
        $query = "select COUNT(*) from article";
        $this->con->executeQuery($query);
        $res = $this->con->getResults();

        foreach ($res as $row) {
            $tabN[] = $row['COUNT(*)'];
        }
        return $tabN[0];
    }

    public function ArtdePage(int $premiereNews,int $NbNews) {
            $tabN=array();
            $this->con->executeQuery("SELECT * FROM article ORDER BY DatePub DESC LIMIT :first, :last",array(
                ":first"=>array($premiereNews,PDO::PARAM_INT),
                ":last" => array($NbNews, PDO::PARAM_INT)
            ));
            $res=$this->con->getResults();
            Foreach ($res as $row) {
                $tabN[] = new Article($row['Titre'], $row['AuteurAttach'], $row['DatePub'], $row['Texte'], $row['id']);
            }
            return $tabN;
    }

    public function getnbartDate(string $date) {
        $tabN = array();
        $query = "select COUNT(*) from article where DatePub=:date";
        $this->con->executeQuery($query, array(':date' => array($date, PDO::PARAM_STR)));
        $res = $this->con->getResults();

        foreach ($res as $row) {
            $tabN[] = $row['COUNT(*)'];
        }
        return $tabN[0];
    }

    public function rechercheParDatePage(int $premiereNews,int $NbNews,string $date) {
        $tabN = array();
        $query = "select * from article where DatePub=:date ORDER BY DatePub DESC LIMIT :first, :last";
        $this->con->executeQuery($query, array(
            ":first"=>array($premiereNews,PDO::PARAM_INT),
            ":last" => array($NbNews, PDO::PARAM_INT),
            ':date' => array($date, PDO::PARAM_STR)
        ));
        $res = $this->con->getResults();

        foreach ($res as $row) {
            $tabN[] = new Article($row['Titre'], $row['AuteurAttach'], $row['DatePub'], $row['Texte'], $row['id']);
        }

        return $tabN;
    }

    public function SupprimerArticleEtCommentaires(int $id){
        $query2 = "DELETE from commentaire where ArticleAttache=:id";
        $this->con->executeQuery($query2, array(
            ":id"=>array($id,PDO::PARAM_INT),
        ));

        $query = "DELETE from article where id=:id";
        $this->con->executeQuery($query, array(
            ":id"=>array($id,PDO::PARAM_INT),
        ));

    }
}


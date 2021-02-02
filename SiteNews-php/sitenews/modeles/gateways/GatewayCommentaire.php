<?php
class gatewayCommentaire
{
    private $con;

    public function __construct(Connection $con)
    {
        $this->con = $con;
    }

    public function DetailsArticle_Coms(int $idArt) {
        $tabN = array();
        $query = "select * from commentaire where ArticleAttache=:idArt";
        $this->con->executeQuery($query, array(':idArt' => array($idArt, PDO::PARAM_STR)));
        $res = $this->con->getResults();

        foreach ($res as $row) {
            $tabN[] = new Commentaire($row['Texte'],$row['Pseudo'],$row['ArticleAttache']);
        }
        return $tabN;
    }

    public function InsertComBD($texte,$pseudo,$idArt) {
        if($_SESSION['role']!="admin"){
            $_SESSION['login']=$pseudo;
        }
        $query = "INSERT INTO COMMENTAIRE VALUES(:texte,:pseudo,:idArt)";
        $this->con->executeQuery($query,array(
            ":texte"=>array($texte,PDO::PARAM_STR),
            ":pseudo" => array($pseudo, PDO::PARAM_STR),
            ":idArt" => array($idArt, PDO::PARAM_INT)
        ));


    }
}


<?php
//Ce script renvoie le titre d'un exemplaire à partir de son identifiant en paramètre
//Il permet l'affichage sur l'application mobile lors d'une restitution.
require_once("myPDO.include.php");

if(isset($_GET['livre'])&&(!empty($_GET['livre']))){

  try{


    $reqt=myPDO::getInstance()->prepare(<<<SQL
      SELECT o.OUVRAGE_TITRE AS titre
      FROM OUVRAGE o , EXEMPLAIRE e
      WHERE o.OUVRAGE_ID = e.OUVRAGE_ID
      AND EXEMP_ID = {$_GET['livre']}
      ;
SQL
    ) ;
    $reqt->execute();
    $titre = $reqt->fetch();

$titre = $titre['titre'];
$array = array($titre);
$json =json_encode($array);
echo $json;

}

catch(Exception $e){

    }
  }

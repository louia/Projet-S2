<?php
//Ce script renvoie le nom et prénom de l'usager ainsi que le titre de l'exemplaire pour un emprunt.
//Il permet l'affichage sur la verion mobile.
require_once("myPDO.include.php");

if(isset($_GET['livre'])&&(!empty($_GET['livre']))){

  if(isset($_GET['user'])&&(!empty($_GET['user']))){


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

  $reqnp=myPDO::getInstance()->prepare(<<<SQL
  SELECT USAGER_NOM AS nom,
         USAGER_PRENOM AS prnm
  FROM USAGER
  WHERE USAGER_ID = {$_GET['user']}
  ;
SQL
  ) ;
$reqnp->execute();
$nom = $reqnp->fetch();


$nom = $nom['nom']." ".$nom['prnm'];
$titre = $titre['titre'];
$array = array($nom,$titre);
$json =json_encode($array);
echo $json;

}

catch(Exception $e){

    }
  }
}

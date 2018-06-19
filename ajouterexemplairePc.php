<?php
//Ce script gère l'ajout d'un exemplaire via le site internet
require_once("myPDO.include.php");
require_once("Entity.class.php");
require_once("Ouvrage.class.php");



$titre = '"'.$_GET['titre'].'"';
$auteur = $_GET['auteur'];
$isbn10 = $_GET['isbn10'];  
 $isbn13 = $_GET['isbn13'];
$date = $_GET['date'];


      $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM OUVRAGE
      WHERE OUVRAGE_TITRE = {$titre}
SQL
);


    $res = $stmt->execute();
    
          $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ouvrage');
          $ouvrage= $stmt->fetch();
          
          $creationexemplaire =  myPDO::getInstance()->prepare(<<<SQL
            INSERT INTO EXEMPLAIRE(OUVRAGE_ID)
            VALUES ({$ouvrage->getOuvrageId()})
SQL
);

          $creationexemplaire->execute();
          $resultat="L'ouvrage a été crée et un exemplaire a été ajouté!";
         echo $resultat;


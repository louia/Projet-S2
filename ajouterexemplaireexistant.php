<?php 
//Ce script gère l'ajout d'un exemplaire lorsqu'un même exemplaire existe déjà
require_once 'myPDO.include.php';
try{
 $creationexemplaire =  myPDO::getInstance()->prepare(<<<SQL
            INSERT INTO EXEMPLAIRE(OUVRAGE_ID)
            VALUES ({$_GET['id']})
SQL
);
          $creationexemplaire->execute();
          $resultat="Exemplaire ajouté!";
         echo $resultat;
} 
catch (Exception $e) {
    
}
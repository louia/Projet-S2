<?php 
//Ce script  à servi de base pour la version pc et mobile
require_once("myPDO.include.php");
require_once("Entity.class.php");
require_once("Ouvrage.class.php");

//Récupération des infos concernant le l'isbn passé en paramètre
$json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);

//Passage du format Json au format array
$tableau = json_decode($json,true);

if(strlen($tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'])==13){
    $isbn13 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
}
else {
    $isbn10 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
}

if(strlen($tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'])==13){
    $isbn13 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
}
else {
    $isbn10 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
}

if(isset($_GET['isbn']) && !empty($_GET['isbn']) ){
  try {
//Requete qui recupère toutes les informations concernant un ouvrage à partir de l'ISBN 10 ou 13
      $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM OUVRAGE
      WHERE OUVRAGE_ISBN_10 = {$isbn10}
      OR OUVRAGE_ISBN_13 = {$isbn13}
SQL
);
    $res = $stmt->execute();    

   
//Instructions si la requète ne renvoie rien
        if ($stmt->rowCount() == 0) {
          header('Location: ' . "../bibliotheque/ajouterouvrage.php?isbn=".$isbn10);
          exit;
            }
        else{
          
          $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ouvrage');
          $ouvrage= $stmt->fetch();      
//Requète qui insère un exemplaire correspondant à un ouvrage
          $creationexemplaire =  myPDO::getInstance()->prepare(<<<SQL
            INSERT INTO EXEMPLAIRE(OUVRAGE_ID)
            VALUES ({$ouvrage->getOuvrageId()})
SQL
);        
          $creationexemplaire->execute();
          echo "Un exemplaire de l'ouvrage a bien &eacute;t&eacute; cr&eacute;e.";



        }
  }
  catch(Exception $e){

  }
}


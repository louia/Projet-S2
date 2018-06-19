<?php 
//Ce script gère l'ajout d'un exemplaire via l'application mobile
require_once("myPDO.include.php");
require_once("Entity.class.php");
require_once("Ouvrage.class.php");


$json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);

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



$titre = $tableau['items'][0]['volumeInfo']['title'];

if(isset( $tableau['items'][0]['volumeInfo']['authors'][0])) {
  $auteur = $tableau['items'][0]['volumeInfo']['authors'][0];
}
else {
  $auteur = "(auteur non renseigné)";
}
if(isset( $tableau['items'][0]['volumeInfo']['publishedDate'])) {
  $date = substr($tableau['items'][0]['volumeInfo']['publishedDate'],0,10);

}
else {
  $date = null;
}





if(isset($_GET['isbn']) && !empty($_GET['isbn']) ){
  try {

      $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM OUVRAGE
      WHERE OUVRAGE_ISBN_10 = {$isbn10}
      OR OUVRAGE_ISBN_13 = {$isbn13}
SQL
);
    $res = $stmt->execute();    

   

        if ($stmt->rowCount() == 0) {
          header('Location: ' . "creerouvrage.php?titre={$titre}&auteur={$auteur}&date={$date}&isbn10={$isbn10}&isbn13={$isbn13}");
          exit;
            }
        else{
          
          $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ouvrage');
          $ouvrage= $stmt->fetch();      
          $creationexemplaire =  myPDO::getInstance()->prepare(<<<SQL
            INSERT INTO EXEMPLAIRE(OUVRAGE_ID)
            VALUES ({$ouvrage->getOuvrageId()})
SQL
);        
          $creationexemplaire->execute();
          $json =json_encode("Exemplaire ajouté");
          echo $json;


        }
  }
  catch(Exception $e){

  }
}


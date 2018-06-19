<?php 

require_once("myPDO.include.php");

  try {
    $titre = '"'.$_GET['titre'].'"';
    $auteur = '"'.$_GET['auteur'].'"';
    $isbn10 = '"'.$_GET['isbn10'].'"';
    $isbn13 = '"'.$_GET['isbn13'].'"';
    
    $creationouvrage =  myPDO::getInstance()->prepare(<<<SQL
    INSERT INTO OUVRAGE(OUVRAGE_TITRE, OUVRAGE_AUTEUR, DATE_PUBLI,OUVRAGE_ISBN_10,OUVRAGE_ISBN_13) 
    VALUES ({$titre},{$auteur},STR_TO_DATE({$_GET['date']},'%Y-%m-%d'),{$isbn10},{$isbn13})
SQL
);        
        $creationouvrage->execute();
        header('Location: ' . "ajouterexemplaireApp.php?isbn={$_GET['isbn10']}");
          exit;
  }
  catch(Exception $e){

    
}
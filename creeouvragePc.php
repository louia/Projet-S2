<?php

require_once("myPDO.include.php");

  try {
    $titre = '"'.$_GET['titre'].'"';
    $auteur = '"'.$_GET['auteur'].'"';
    $isbn10 = '"'.$_GET['isbn10'].'"';
    $isbn13 = '"'.$_GET['isbn13'].'"';
    $date = "'" . $_GET['date'] . "'";
    $creationouvrage =  myPDO::getInstance()->prepare(<<<SQL
    INSERT INTO OUVRAGE(OUVRAGE_TITRE, OUVRAGE_AUTEUR, DATE_PUBLI,OUVRAGE_ISBN_10,OUVRAGE_ISBN_13)
    VALUES ({$titre},{$auteur},STR_TO_DATE({$date},'%Y-%m-%d'),{$isbn10},{$isbn13})
SQL
);
// isbn 13 enlever
        $creationouvrage->execute();

          header('Location: ' . "ajouterexemplairePc.php?auteur={$_GET['auteur']}&date={$_GET['date']}&isbn10={$_GET['isbn10']}&isbn13={$_GET['isbn13']}&titre={$_GET['titre']}");
            exit;
  }
  catch(Exception $e){


}

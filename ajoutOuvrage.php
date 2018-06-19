<?php
require_once("myPDO.include.php");

if(isset($_GET['isbn'])&&(!empty($_GET['isbn']))){

  if(isset($_GET['auteur'])&&(!empty($_GET['auteur']))){

    if(isset($_GET['titre'])&&(!empty($_GET['titre']))){

      if(isset($_GET['date'])&&(!empty($_GET['date']))){

  try{
    $isbn = null;
    if (strlen($_GET['isbn'])==10) {
      $isbn = "OUVRAGE_ISBN_10";
    }
    else if (strlen($_GET['isbn'])==13) {
      $isbn = "OUVRAGE_ISBN_13";
    }
    $stmt = myPDO::getInstance()->prepare(<<<SQL
      INSERT INTO OUVRAGE(OUVRAGE_TITRE,OUVRAGE_AUTEUR,DATE_PUBLI,{$isbn})
      VALUES({$_GET['titre']},{$_GET['auteur']},{$_GET['date']},{$_GET['isbn']})
      ;
SQL
    );
    $stmt->execute();
  echo "ok";
  }

catch(Exception $e){

        }
      }
    }
  }
}

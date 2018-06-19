<?php
//Ce script gère l'ajout d'un usager à partir des informations entrées sur le site
require_once('myPDO.include.php');

try {

  $nom = '"'.$_GET['nomusager'].'"';
  $prenom = '"'.$_GET['prenomusager'].'"';
  $sexe = '"'.$_GET['sexeusager'].'"';
  $type = '"'.$_GET['typeusager'].'"';
  $date = "'" . $_GET['datenaisusager'] . "'";

  $creationusager =  myPDO::getInstance()->prepare(<<<SQL
  INSERT INTO USAGER(USAGER_NOM, USAGER_PRENOM, USAGER_DATENAIS, USAGER_SX, USAGER_TYPE)
  VALUES ({$nom},{$prenom},STR_TO_DATE({$date}, '%Y-%m-%d'),{$sexe},{$type})
SQL
);
      $creationusager->execute();
      echo "Usager bien enregistré";
}

catch(Exception $e){
  echo $e;

}

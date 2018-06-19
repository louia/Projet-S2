<?php
//Ce script permet d'effectuer un emprunt sur le site internet.
//La seule différence par rapport à la version emprunt.php est le format de retour qui n'est pas du JSON
require_once("myPDO.include.php");

if(isset($_GET['livre'])&&(!empty($_GET['livre']))){
  if(isset($_GET['user'])&&(!empty($_GET['user']))){
  try{
    $a=myPDO::getInstance()->prepare(<<<SQL
      SELECT USAGER_NB_EMPRUNT as nb
      FROM USAGER
      WHERE USAGER_ID = {$_GET['user']}
      ;
SQL
    ) ;

    $a->execute();
    $nbemp = $a->fetch();

    $b=myPDO::getInstance()->prepare(<<<SQL
      SELECT EXEMP_ETAT as etat
      FROM EXEMPLAIRE
      WHERE EXEMP_ID = {$_GET['livre']}
      ;
SQL
    ) ;

    $b->execute();

    $etat = $b->fetch();


    $c=myPDO::getInstance()->prepare(<<<SQL

      SELECT EMP_DATE_MAX_RETOUR as date,
             EMP_DATE_RETOUR as dt
      FROM EMPRUNT
      WHERE USAGER_ID = {$_GET['user']}
      ;

SQL

    ) ;

    $c->execute();

    $retard = $c->fetch();



    $d=myPDO::getInstance()->prepare(<<<SQL
      SELECT CURDATE() as a;
      ;
SQL

    ) ;

    $d->execute();

    $date= $d->fetch();

if($nbemp['nb']>=2){

  $a="Impossible d'emprunter ! Tu as déja trop d'emprunt";



}

elseif ($etat['etat'] == "EMPRUNTE") {

  $a = "Impossible d'emprunter ! Cet exemplaire a deja été emprunté !";



}

elseif (($retard['date'] < $date['a'])&&($retard['dt']==null)&&($retard!=false)) {

  $a="Rends d'abord ton autre livre";



}

else {

$stmt = myPDO::getInstance()->prepare(<<<SQL

  INSERT INTO EMPRUNT(USAGER_ID,EXEMP_ID,EMP_DATE,EMP_DATE_MAX_RETOUR)
  VALUES({$_GET['user']},{$_GET['livre']},CURDATE(),DATE_ADD(CURDATE(), INTERVAL 15 DAY))
  ;

  UPDATE USAGER
  SET USAGER_NB_EMPRUNT = USAGER_NB_EMPRUNT+1
  WHERE USAGER_ID = {$_GET['user']}
  ;

  UPDATE EXEMPLAIRE
  SET EXEMP_ETAT = "EMPRUNTE"
  WHERE EXEMP_ID = {$_GET['livre']}
  ;

SQL

) ;

$stmt->execute();

 $a="Emprunt bien enregistré";





}

echo $a;

}



catch(Exception $e){
  echo $e;


    }

  }

}

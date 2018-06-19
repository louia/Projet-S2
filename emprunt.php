<?php
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
  $array = array("Impossible d'emprunter ! Tu as déja trop d'emprunt.");
  $json =json_encode($array);
}
elseif ($etat['etat'] == "EMPRUNTE") {
  $array = array("Impossible d'emprunter ! Cet exemplaire a deja été emprunté !");
  $json =json_encode($array);
}
elseif (($retard['date'] < $date['a'])&&($retard['dt']==null)&&($retard!=false)) {
  $array = array("Tu as un emprunt en retard il faut rendre ton autre livre.");
  $json =json_encode($array);
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
$array = array("L'emprunt a bien été enregistré.");
$json =json_encode($array);

}
echo $json;
}

catch(Exception $e){

    }
  }
}

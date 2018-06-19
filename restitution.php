<?php
//Ce script gère la restitution d'un exemplaire pour la version mobile (Format JSON)
require_once("myPDO.include.php");

if(isset($_GET['livre'])&&(!empty($_GET['livre']))){

  try{

        $b=myPDO::getInstance()->prepare(<<<SQL
          SELECT EXEMP_ETAT as etat
          FROM EXEMPLAIRE
          WHERE EXEMP_ID = {$_GET['livre']}
          ;
SQL
        ) ;
        $b->execute();
        $etat = $b->fetch();
if($etat['etat'] == "DISPONIBLE"){
  $array = array("Ce livre n'est pas emprunté, impossible de le rendre.");
  $json =json_encode($array);
}
else {
    $req = myPDO::getInstance()->prepare(<<<SQL
      SELECT MAX(EMP_DATE),MAX(EMP_ID)
      FROM EMPRUNT
      WHERE EXEMP_ID = {$_GET['livre']}
      ;
SQL
    );
    $req->execute();
    $rep = $req->fetch();
    $date = $rep['MAX(EMP_DATE)'];
    $id = $rep['MAX(EMP_ID)'];

    $req1 = myPDO::getInstance()->prepare(<<<SQL
      SELECT USAGER_ID
      FROM EMPRUNT
      WHERE EXEMP_ID = {$_GET['livre']}
      AND EMP_DATE = STR_TO_DATE('{$date}', '%Y-%m-%d')
      ;
SQL
    );
    $req1->execute();
    $rep1 = $req1->fetch();
    $user = $rep1['USAGER_ID'];

    $stmt = myPDO::getInstance()->prepare(<<<SQL
      UPDATE EMPRUNT
      SET EMP_DATE_RETOUR = CURDATE()
      WHERE EXEMP_ID = {$_GET['livre']}
      AND EMP_DATE = STR_TO_DATE('{$date}', '%Y-%m-%d')
      AND EMP_ID = {$id}
      ;

      UPDATE USAGER
      SET USAGER_NB_EMPRUNT = USAGER_NB_EMPRUNT-1
      WHERE USAGER_ID = {$user}
      ;

      UPDATE EXEMPLAIRE
      SET EXEMP_ETAT = 'DISPONIBLE'
      WHERE EXEMP_ID = {$_GET['livre']}
      ;
SQL
    ) ;

    $stmt->execute();

    $array = array("Le livre a bien été rendu.");
    $json =json_encode($array);
}
    echo $json;
  }

catch(Exception $e){

      }

    }

<?php
//Ce script renvoie un tableau récapitulatif des emprunts en retards ainsi que leurs informations.
require_once('webpage.class.php');
require_once('myPDO.include.php');
$html = new WebPage();
$html-> setTitle("Retard");
$stmt = myPDO::getInstance()->prepare(<<<SQL
 SELECT USAGER_ID AS usager ,
        EXEMP_ID  AS exemplaire ,
        EMP_DATE_MAX_RETOUR
 FROM EMPRUNT
 WHERE EMP_DATE_MAX_RETOUR < CURDATE()
 AND EMP_DATE_RETOUR IS NULL
 ;
SQL
);
$stmt->execute();
$retard = $stmt->fetchall();
$date = myPDO::getInstance()->prepare(<<<SQL
 SELECT CURDATE()-EMP_DATE_MAX_RETOUR
 FROM EMPRUNT
 WHERE EMP_DATE_MAX_RETOUR < CURDATE()
 AND EMP_DATE_RETOUR IS NULL
 ;
SQL
);
$date->execute();
$curdate = $date->fetch();

$html->appendContent("<br><br><br><table class='table'>");
$html->appendContent("<tr>");
$html->appendContent("<th>Nom</th><th>Prénom</th><th>Date de retour prévue</th><th>Retard</th></tr>");
foreach($retard as $key=>$value){
  $req = myPDO::getInstance()->prepare(<<<SQL
   SELECT USAGER_NOM AS nom,
          USAGER_PRENOM AS prnm
   FROM USAGER
   WHERE USAGER_ID = {$retard[$key]['usager']}
   ;
SQL
  );
  $req->execute();
  $user = $req->fetch();
    $html->appendContent("<tr>");
    $html->appendContent("<td>{$user['nom']}</td><td>{$user['prnm']}</td><td>{$value['EMP_DATE_MAX_RETOUR']}</td><td>{$curdate['CURDATE()-EMP_DATE_MAX_RETOUR']} jours</td></tr>");

}
$html->appendContent("</table>");
echo $html->toHTML();

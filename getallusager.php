<?php
//Ce script renvoie un tableau récapitulatif de tous les usagers contenus dans la base de donnée.
//Il contient entre autre le nom , le prénom , le nb d'emprunts ...
require_once('webpage.class.php');
require_once('myPDO.include.php');
$html = new WebPage();
$html-> setTitle("Exemplaires");
$stmt = myPDO::getInstance()->prepare(<<<SQL
 SELECT u.USAGER_NOM as nom,
        u.USAGER_PRENOM as prnm,
        u. USAGER_NB_EMPRUNT as nbemp,
        u.USAGER_ID as id
 FROM USAGER u
 ORDER BY nom
 ;
SQL
);
$stmt->execute();
$exemp = $stmt->fetchall();
$html->appendContent("<table class='table table-hover' id='myTableUsager'>");
$html->appendContent("<tr>");
$html->appendContent("<th>ID</th><th>Nom</th><th>Prénom</th><th>Nombre d'emprunts</th><th>Emprunts en cours</th></tr>");
$i =0;
foreach($exemp as $key=>$result){
      $req = myPDO::getInstance()->prepare(<<<SQL
     SELECT OUVRAGE_TITRE
       FROM OUVRAGE o, EXEMPLAIRE e , EMPRUNT f
       WHERE o.OUVRAGE_ID = e.OUVRAGE_ID
       AND e.EXEMP_ID = f.EXEMP_ID
  		AND f.USAGER_ID = {$result['id']}
        AND f.EMP_DATE_RETOUR IS NULL
       ;
SQL
      );
      $req->execute();
      $emp = $req->fetchall();
      $abc = "";
foreach($emp as $y=>$value){
      foreach($value as $x=>$z){
          $abc .= "".$z."<br>";
      }
    }
       $html->appendContent("<tr>");
    $html->appendContent("<td>{$result['id']}</td><td>{$result['nom']}</td><td>{$result['prnm']}</td><td>{$result['nbemp']} </td><td>{$abc}</tr>");
  }
$html->appendContent("</table>");

echo $html->toHTML();

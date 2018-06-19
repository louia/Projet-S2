<?php
//Ce script renvoie un tableau récapitulatif de tous les exemplaires contenus dans la base de donnée.
//Il contient entre autre le titre , l'auteur , l'identifiant ...
require_once('webpage.class.php');
require_once('myPDO.include.php');
$html = new WebPage();
$html-> setTitle("Exemplaires");
$stmt = myPDO::getInstance()->prepare(<<<SQL
 SELECT o.OUVRAGE_TITRE as titre,
        o.OUVRAGE_AUTEUR as auteur,
        o. DATE_PUBLI as date,
        o.OUVRAGE_ISBN_10 as isbn,
        e.EXEMP_ETAT as etat,
        e.exemp_id as id
 FROM EXEMPLAIRE e , OUVRAGE o
 WHERE e.OUVRAGE_ID = o.OUVRAGE_ID
 ORDER BY titre
 ;
SQL
);
$stmt->execute();
$exemp = $stmt->fetchall();
$html->appendContent("<table class='table table-hover' id='myTable'>");
$html->appendContent("<tr>");
$html->appendContent("<th>ID</th><th>Titre</th><th>Auteur</th><th>Date de publication</th><th>ISBN 10</th><th>Disponibilité</th></tr>");
$i =0;
foreach($exemp as $key=>$result){
  if($result['etat']== "EMPRUNTE"){
      $req = myPDO::getInstance()->prepare(<<<SQL
       SELECT EMP_DATE_MAX_RETOUR as d
       FROM EMPRUNT
       WHERE EXEMP_ID = {$result['id']}
       AND EMP_DATE_RETOUR IS NULL
       ;
SQL
      );
      $req->execute();
      $emp = $req->fetch();
    $dispo = "Emprunté  : date de retour prévue le {$emp['d']}";
  }
  else{$dispo = "Disponible";}
    $html->appendContent("<tr>");
    $html->appendContent("<td>{$result['id']}</td><td>{$result['titre']}</td><td>{$result['auteur']}</td><td>{$result['date']} </td><td>{$result['isbn']} </td><td class='dispo' id='{$i}'>{$dispo}</td></tr>");
    $i=$i+1;
}
$html->appendContent("</table>");
$html->appendContent("<script type='text/javascript'>
var str = document.getElementsByClassName('dispo');

for (i = 0; i < str.length; i++) {
  document.getElementById(i).style.color = 'white';
  if (str[i].innerHTML=='Disponible') {
    document.getElementById(i).style.backgroundColor = 'green';
  }
  else {
    document.getElementById(i).style.backgroundColor = 'red';
  }
}

    </script>");
echo $html->toHTML();

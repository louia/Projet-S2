<?php
//Ce script gère l'ajout d'un ouvrage à partir del'API google books et notamment l'ISBN
require_once 'webpage.class.php';
require_once 'myPDO.class.php';
require_once 'Ouvrage.class.php';

$json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);

$tableau = json_decode($json,true);

if(strlen($tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'])==13){
  $isbn13 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
}
else {
  $isbn10 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier'];
}

if(strlen($tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'])==13){
  $isbn13 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
}
else {
  $isbn10 = $tableau['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'];
}



$title = $tableau['items'][0]['volumeInfo']['title'];

if(isset( $tableau['items'][0]['volumeInfo']['authors'][0])) {
  $auteur = $tableau['items'][0]['volumeInfo']['authors'][0];
}
else {
  $auteur = "(valeur à spécifier)";
}
if(isset( $tableau['items'][0]['volumeInfo']['publishedDate'])) {
  $date = substr($tableau['items'][0]['volumeInfo']['publishedDate'],0,10);

}
else {
  $date = "(valeur à spécifier au format AAAA-MM-JJ)";
}


$titre = '"'.$title.'"';
      $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM OUVRAGE
      WHERE OUVRAGE_TITRE = {$titre}
SQL
);
    $res = $stmt->execute();


        if ($stmt->rowCount() != 0) {
            
          $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ouvrage');
          $ouvrage= $stmt->fetch();
                 $page =<<<HTML
  <h2>Créer un ouvrage </h2>

  <!-- <div style="height:25px;"> -->
  <p>L'ouvrage existe déja voulez-vous ajoutez un exemplaire de celui-ci ?</p>
    <form  method="GET" >

        <div class="col-sm-9">
          <input type="text" style="display:none;" id="idouvrageex" name="idouvrageex" class="form-control" value="{$ouvrage->getOuvrageId()}"  hidden>
        </div>
        <div class="col-sm-12">
          <button id="exemplaireexistant" type="button" class="btn btn-primary">Créer l'exemplaire</button>
        </div>
      </div>
    </form>
HTML;
            
        }
        
        
        else{
            $page =<<<HTML
  <h2>Créer un ouvrage </h2>

  <!-- <div style="height:25px;"> -->
  <p>Veuillez remplir les champs suivant pour créer ce nouvel ouvrage.</p>
    <form  method="GET">
<!-- action="creeouvragePc.php" -->
      <div class="form-group row">

        <div class="col-sm-3">
          <p> Titre </p>
        </div>
        <div class="col-sm-9">
          <input id="titre" type="text" name="titre" class="form-control" value="{$title}" required>
        </div>

        <div class="col-sm-3">
          <p> Auteur </p>
        </div>
        <div class="col-sm-9">
          <input id="auteur"type="text" name="auteur" class="form-control" value="{$auteur}"  required>
        </div>

        <div class="col-sm-3">
          <p> Date de publication </p>
        </div>
        <div class="col-sm-9">
          <input id="date" type="date" name="date" class="form-control" value="{$date}" placeholder="AAAA-MM-JJ"  required>
        </div>
        <div class="col-sm-3">
          <p> N°ISBN 10 </p>
        </div>
        <div class="col-sm-9">
          <input type="text" id="isbn10" name="isbn10" class="form-control" value="{$isbn10}" pattern="[0-9]{10}" required>
        </div>
        <div class="col-sm-3">
          <p> N°ISBN 13 </p>
        </div>
        <div class="col-sm-9">
          <input type="text" id="isbn13" name="isbn13" class="form-control" value="{$isbn13}" pattern="[0-9]{13}" required>
        </div>
        <div class="col-sm-12">
          <button id="emprunt" type="button" class="btn btn-primary">Créer l'ouvrage</button>
        </div>
      </div>
    </form>
HTML;
        }


echo $page;

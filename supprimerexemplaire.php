<?php
//Ce script gère la supression d'un exemplaire.
require_once("myPDO.include.php");

if(isset($_GET['ex'])&&(!empty($_GET['ex']))){
  try{

    $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM EXEMPLAIRE
      WHERE EXEMP_ID = {$_GET['ex']}
SQL
    );
    $stmt->execute();

if($stmt->rowCount() == 0){
	echo "L'exemplaire n'existe pas dans la base de donnée.";
}

else{

    $stmt = myPDO::getInstance()->prepare(<<<SQL
      DELETE FROM EXEMPLAIRE 
      WHERE EXEMP_ID = {$_GET['ex']}
SQL
    );
    $stmt->execute();
    echo "<p>L'exemplaire a bien été supprimé</p>";
	}
  }

catch(Exception $e){

      
  }
}
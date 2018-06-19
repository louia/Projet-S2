<?php
//Ce script gère la supression d'un usager.
require_once("myPDO.include.php");

if(isset($_GET['usagerid'])&&(!empty($_GET['usagerid']))){
  try{

    $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM USAGER
      WHERE USAGER_ID = {$_GET['usagerid']}
SQL
    );
    $stmt->execute();

if($stmt->rowCount() == 0){
	echo "L'usager n'existe pas dans la base de donnée.";
}

else{

    $stmt = myPDO::getInstance()->prepare(<<<SQL
      DELETE FROM USAGER
      WHERE USAGER_ID = {$_GET['usagerid']}
SQL
    );
    $stmt->execute();
    echo "<p>L'usager a bien été supprimé</p>";
	}
  }

catch(Exception $e){

      
  }
}
<?php
//Ce script gère la génération d'un QR code individuel pour les usagers à partir de leur identifiant.
   include('qrcode/qrlib.php');
   require_once 'myPDO.include.php';
    require_once 'webpage.class.php';


  if(isset($_GET['user'])&&(!empty($_GET['user']))){
   try{
     $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT USAGER_ID AS code
      FROM USAGER
      WHERE USAGER_ID = {$_GET['user']}
      ;
SQL
     );
     $stmt->execute();
     $user = $stmt->fetch();
     if($user['code'] == null){
         $p = new WebPage("Erreur");
         $p->appendCss(<<<CSS
         p {
             text-align: center;
             display : flex;
             font-size : 30px
         }
CSS
    );
         $p->appendContent("<p>Cet ID n'existe pas, veuillez réessayer.</p>");
         echo $p->toHTML();
     }
     else{
     QRcode::png($user['code']);
     }
   }
   catch(Exception $e){
     echo $e;
   }
}


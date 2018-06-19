<?php
//Ce script gère la génération d'un QR code individuel pour les exemplaires à partir de leur identifiant.
   include('qrcode/qrlib.php');
   require_once 'myPDO.include.php';
    require_once 'webpage.class.php';


  if(isset($_GET['livre'])&&(!empty($_GET['livre']))){
   try{
     $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT EXEMP_ID AS code
      FROM EXEMPLAIRE
      WHERE EXEMP_ID = {$_GET['livre']}
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

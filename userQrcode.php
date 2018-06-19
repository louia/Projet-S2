<?php
// Ce script génère les QR codes de tous les usagers présents dans la base de donnée.
   include('qrcode/qrlib.php');
   require_once('myPDO.include.php');
   require_once('webpage.class.php');

   try{
     $p = new WebPage() ;
     $p->setTitle('IMPRESSION USAGERS') ;
     $p->appendCss(<<<CSS
    div {
     display:inline-block;
     margin: 25px;
    }
CSS
    );

     $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM USAGER
SQL
     );
     $stmt->execute();
     $user = $stmt->fetchall();
     //$p->appendContent("<ul>");
     foreach ($user as $key => $value) {
       $code = $value['USAGER_NOM']."_".$value['USAGER_PRENOM']."_".$value['USAGER_ID'];
       $req = myPDO::getInstance()->prepare(<<<SQL
       UPDATE USAGER
       SET USAGER_QRCODE = "{$value['USAGER_ID']}"
       WHERE USAGER_ID = {$value['USAGER_ID']}
       ;
SQL
       );
       $req->execute();
       $id= $value['USAGER_ID'];
       $p->appendContent("<div>");
       $p->appendContent("<img src= 'generationUserQrcode.php?user={$id}' alt='x' />" );
       $p->appendContent("<br>");
       $p->appendContent("<span>");
       $p->appendContent("{$code}");
       $p->appendContent("</span>");
       $p->appendContent("</div>");
     }
     $p->appendContent("</ul>");
     echo $p->toHTML() ;
   }
   catch(Exception $e){
     echo $e;
   }

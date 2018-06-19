<?php
// Ce script génère les QR codes de tous les exemplaires présents dans la base de donnée.
   include('qrcode/qrlib.php');
   require_once('myPDO.include.php');
   require_once('webpage.class.php');

   try{
     $p = new WebPage() ;
     $p->setTitle('IMPRESSION EXEMPLAIRE') ;
     $p->appendCss(<<<CSS
    div {
     display:inline-block;
     margin: 25px;
    }
CSS
    );
     $stmt = myPDO::getInstance()->prepare(<<<SQL
      SELECT *
      FROM EXEMPLAIRE
SQL
     );
     $stmt->execute();
     $exemp = $stmt->fetchall();
     foreach ($exemp as $key => $value) {
       $reqOuv = myPDO::getInstance()->prepare(<<<SQL
       SELECT o.OUVRAGE_TITRE AS titre
       FROM OUVRAGE o , EXEMPLAIRE e
       WHERE o.OUVRAGE_ID = e.OUVRAGE_ID
       AND e.EXEMP_ID = {$value['EXEMP_ID']}
       ;
SQL
    );
    $reqOuv->execute();
    $titre = $reqOuv->fetch();
       $code = $titre['titre']."_".$value['EXEMP_ID'];
       $req = myPDO::getInstance()->prepare(<<<SQL
       UPDATE EXEMPLAIRE
       SET EXEMP_QRCODE = "{$value['EXEMP_ID']}"
       WHERE EXEMP_ID = {$value['EXEMP_ID']}
       ;
SQL
       );
       $req->execute();
       $id= $value['EXEMP_ID'];
       $p->appendContent("<div>");
       $p->appendContent("<img src= 'generationExempQrcode.php?livre={$id}' alt='x' />" );
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

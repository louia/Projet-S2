<?php
//Ce script renvoie le titre d'un exemaplaire à partir d'un isbn passé en paramètre (ou scan du code barre ).
//Il permet l'affichage sur l'application mobile.
require_once("myPDO.include.php");

if(isset($_GET['isbn'])&&(!empty($_GET['isbn']))){

  try{
    $json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);
  $array = json_decode($json,true);
    if($array['totalItems']== 0 ){
      echo "L&apos;ISBN ,&apos,est pas valide";
    }
    else {
    $result = $array['items']['0']['volumeInfo']['title'];
    $json =json_encode($result);
    echo $json;
  }
  }

catch(Exception $e){

      }

    }

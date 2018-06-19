<?php
//Ce script renvoie les informations concernant un exemplaire à partir d'un isbn passé en paramètre.
//Il permet l'affichage sur l'application web.
if(isset($_GET['isbn'])&&(!empty($_GET['isbn']))){

  try{
    $json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);
  $array = json_decode($json,true);
    if($array['totalItems']== 0 ){
      echo "L'&apos;ISBN n&apos;existe pas.";
    }
    else {
    $result ="Titre : " . $array['items']['0']['volumeInfo']['title'] . "<br>";
    $result .="Auteur : " . $array['items']['0']['volumeInfo']['authors'][0]. "<br>";
    $result .="Date de publication : " . $array['items']['0']['volumeInfo']['publishedDate'];
    $json =json_encode($result);
    echo $result;
    //echo $json;
  }
  }

catch(Exception $e){

      }

    }

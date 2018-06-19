<?php

if(isset($_GET['isbn'])&&(!empty($_GET['isbn']))){

  try{
    $json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=ISBN:'.$_GET['isbn']);
  $array = json_decode($json,true);
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
  $auteur = "(Valeur à spécifier)";
}
if(isset( $tableau['items'][0]['volumeInfo']['publishedDate'])) {
  $date = substr($tableau['items'][0]['volumeInfo']['publishedDate'],0,10);

}
else {
  $date = "(Valeur à spécifier au format AAAA-MM-JJ)";
}



    if($array['totalItems']== 0 ){
      echo "L&apos;ISBN n&apos;existe pas.";
    }
    else {
   $result =<<<HTML
    <div class="col-sm-12">
    
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <div style="height:55px;"></div>
    
            <div class="tab-content">


                <!---------------------------------------------------------->

                <div class="tab-pane active" id="Informations ouvrage" role="tabpanel">
                    <h1>Créer un ouvrage </h1>
                    
                  

                    <section class="row text-center placeholders">
                            <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                                <form action="creerouvrage.php" method="GET">
        
                                    <div class="form-group row">

                                        <div class="col-sm-3">
                                            <p> Titre </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="titre" class="form-control" value="{$title}" required>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <p> Auteur </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="auteur" class="form-control" value="{$auteur}" required>
                                        </div>

                                        <div class="col-sm-3">
                                            <p> Date de publication </p>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="date" class="form-control" value="{$date}" placeholder="AAAA-MM-JJ" required>
                                        </div>
                                     <input type="text" name="isbn10" class="form-control" value="{$isbn10}" hidden>
                                     <input type="text" name="isbn13" class="form-control" value="{$isbn13}" hidden>

                                    </div>
                                    <div>
                                        <button id="emprunt" type="submit" class="btn btn-primary">Créer l'ouvrage</button>
                                    </div>
                                </form>
                            </div>
                        </section>


                </div>



        </main>
    </div>
HTML;


    $json =json_encode($result);
    echo $result;
    //echo $json;
  }
  }

catch(Exception $e){

      }

    }

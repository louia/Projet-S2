<?php
//Script permettant de paramétrer la connexion à la base de donnée.
require_once 'myPDO.class.php' ;

myPDO::setConfiguration('mysql:host=localhost;dbname=id3500862_biblio;charset=utf8', 'id3500862_biblio', 'azerty01') ;

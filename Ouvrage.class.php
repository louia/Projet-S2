<?php
//CLasse OUvrage
require_once('myPDO.include.php');
require_once('Entity.class.php');
class Ouvrage extends Entity {

 protected $OUVRAGE_ID = null;

    public function getOuvrageId() {
      return $this->OUVRAGE_ID;
    }

}
 ?>
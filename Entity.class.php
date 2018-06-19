<?php
// Classe Entity qui sert de base à nos autres classes.
abstract class Entity {
    /// Identifiant
    protected $id = null ;


    /// Constructeur non accessible
    private function __construct() {

    }

    /// Accesseur sur id
    public function getId() {
      return $this->id;
    }

}

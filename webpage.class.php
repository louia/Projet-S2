<?php

class WebPage {
    /**
     * @var string Texte compris entre <head> et </head>
     */
    private $head  = null ;
    /**
     * @var string Texte compris entre <title> et </title>
     */
    private $title = null ;
    /**
     * @var string Texte compris entre <body> et </body>
     */
    private $body  = null ;

    private $js = null;

    /**
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title=null) {

    }

    /**
     * Retourner le contenu de $this->body
     *
     * @return string
     */
    public function body() {
      return $this->body;
    }

    /**
     * Retourner le contenu de $this->head
     *
     * @return string
     */
    public function head() {
      return $this->head;
    }

    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web
     * @see http://php.net/manual/en/function.htmlentities.php
     * @param string $string La chaîne à protéger
     *
     * @return string La chaîne protégée
     */
    public static function escapeString($string) {
     return htmlentities($string,ENT_QUOTES | ENT_HTML5, "UTF-8");
    }

    /**
     * Affecter le titre de la page
     * @param string $title Le titre
     */
    public function setTitle($title) {
      $this->title = "<title>".$title."</title>";
    }

    /**
     * Ajouter un contenu dans head
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendToHead($content) {
      $this->head .= $content;
    }

    /**
     * Ajouter un contenu CSS dans head
     * @param string $css Le contenu CSS à ajouter
     *
     * @return void
     */
    public function appendCss($css) {
      $this->head .= "<style>".$css."</style>";
    }

    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param string $url L'URL du script CSS
     *
     * @return void
     */
    public function appendCssUrl($url) {
        $this->head .= "<link rel='stylesheet' href='{$url}' />";
    }

    /**
     * Ajouter un contenu JavaScript dans head
     * @param string $js Le contenu JavaScript à ajouter
     *
     * @return void
     */
    public function appendJs($js) {
        $this->head .= "<script>".$js."</script>";
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsUrl($url) {
      $this->head .= "<script type='text/javascript' src='{$url}'></script>";
    }

    public function setBody($url) {
      $this->js = $url;
    }
    public function js() {
      return $this->js;
    }

    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendContent($content) {
      $this->body .= $content;
    }

    /**
     * Produire la page Web complète
     *
     * @return string
     * @throws Exception si title n'est pas défini
     */
    public function toHTML() {
        return <<<EOL
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      {$this->title}
      {$this->head()}
    </head>
    <body onload="{$this->js()}">
    {$this->body()}
    </body>
  </html>
EOL;

    }
}

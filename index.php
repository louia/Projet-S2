<?php
require_once 'webpage.class.php';
require_once 'myPDO.class.php';

$html = new WebPage('Biblioth');
$html->appendToHead('<link rel="icon" type="image/png" href="img/favicon.png" />');
$html->appendCssUrl('css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.css');
$html->appendCssUrl('css/font-awesome-4.7.0/css/font-awesome.min.css');
$html->appendCssUrl('css/style-paneladmin.css');
$html->appendCssUrl('css/style.css');
$html->appendCssUrl('css/animation.css');
$html->appendJsUrl('js/oXHR.js');


$html->appendToHead('<meta name="viewport" content="width=device-width, user-scalable=yes" />');
$html->appendToHead("<title>Bibliothéq'air</title>");
$html->setBody("requestExemplaire(); requestRetard();");

$page =<<<HTML
<header>
    <div class="text">
        <h1>Gestionnaire de bibliothéque</h1>
    </div>
    <div class="mouse_wave">
			<span class="scroll_arrows one"></span>
			<span class="scroll_arrows two"></span>
			<span class="scroll_arrows three"></span>
</div>
</header>
HTML;
$page .=<<<HTML
<div class="block">
    <div class="col-sm-12">
        <div id="menuToggle">
            <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar" id="dim" >
                <input type="checkbox" id="ham" />
                <span></span>
                <span></span>
                <span></span>

                <ul class="nav nav-pills flex-column" id="menu" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#emprunterexemplaire" role="tab" aria-controls="Emprunter exemplaire">Emprunter un exemplaire</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rendreexemplaire" role="tab" aria-controls="Rendre exemplaire">Rendre exemplaire</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ajouterexemplaire" role="tab" aria-controls="Ajouter exemplaire">Ajouter exemplaire</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#supprimerexemplaire" role="tab" aria-controls="Supprimer exemplaire">Supprimer exemplaire</a></li>
                    <li class="nav-item"><a id="refreshex"  class="nav-link" data-toggle="tab" href="#recapexemplaire" role="tab" aria-controls="Récapitulatif des exemplaires">R&eacute;capitulatif des exemplaires</a></li>
                    <li class="nav-item"><a id="refreshusagers"class="nav-link" data-toggle="tab" href="#recapitulatifdesusagers" role="tab" aria-controls="Récapitulatif des usagers">Récapitulatif des usagers</a></li>
                    <li class="nav-item"><a id="refreshretard" class="nav-link" data-toggle="tab" href="#retards" role="tab" aria-controls="Retards">Retards</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ajouterusager" role="tab" aria-controls="Ajouter usager">Ajouter usager</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#supprimerusager" role="tab" aria-controls="Supprimer usager">Supprimer usager</a></li>
                   <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#userqrcode" role="tab" aria-controls="Supprimer usager">Générer QR Codes usagers</a></li>
                     <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#exemplaireqrcode" role="tab" aria-controls="Supprimer usager">Générer QR Codes exemplaires</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <!-- <div style="height:px;"></div> -->

        <div class="tab-content">

            <!---------------------------------------------------------->

            <div class="tab-pane active" id="emprunterexemplaire" role="tabpanel">
              <div style="height:25px;"></div>

                <h1>Emprunter exemplaire </h1>

                <div style="height:25px;"></div>

                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form method="GET">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p> Numéro exemplaire </p>
                                </div>
                                <div class="col-sm-6">
                                    <input id='livreid' type="text" name="livre" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 123456">
                                </div>

                                <div class="col-sm-6">
                                    <p> Numéro usager </p>
                                </div>
                                <div class="col-sm-6">
                                    <input id='numusager' type="text" name="user" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 123456">
                                </div>

                            </div>
                            <div>
                                <!-- <button id="rechercheLivre" type="button" class="btn btn-primary"   value="Rechercher" />Rechercher</button> -->
                                <button id="validerEmprunt" type="button" class="btn btn-danger" onclick="requestEmprunterLivre(info);">Emprunter</button>
                                <button id="effacerEmprunt" type="reset" class="btn btn-info"   value="Effacer" />Recommencer</button>
                            </div>
                        </form>
                        <div id="reponseEmprunterLivre">

                        </div>
                    </div>
                </section>
            </div>

            <!--------------------------------------------------------->

            <div class="tab-pane" id="rendreexemplaire" role="tabpanel">
              <div style="height:25px;"></div>

                <h1>Rendre exemplaire </h1>

                <div style="height:25px;"></div>

                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form  method="post">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p> Numéro exemplaire </p>
                                </div>
                                <div class="col-sm-6">
                                    <input id="rendreid" type="text" name="exemplaire" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 123456">
                                </div>

                            </div>
                            <div>
                              <button id="rechercheRendre" type="button" class="btn btn-primary"   value="Rechercher" />Rechercher</button>
                              <button id="validerRendre" type="button" class="btn btn-danger" onclick="requestRendreLivre(info);">Rendre</button>
                              <button id="effacerRendre" type="reset" class="btn btn-info"   value="Effacer" />Recommencer</button>
                             </div>
                        </form>
                        <div id="reponseRendreLivre">

                        </div>
                    </div>
                </section>
            </div>

            <!---------------------------------------------------------->

            <div class="tab-pane" id="ajouterexemplaire" role="tabpanel">
              <div style="height:25px;"></div>

                <h1>Ajouter exemplaire </h1>

                <div style="height:25px;"></div>

                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form method="GET">

                            <div class="form-group row">
                              <div class="col-sm-6">
                                  <p>Saisir numéro ISBN</p>
                              </div>
                                <div class="col-sm-6">
                                    <input id="isbnn" type="text" name="isbn" class="form-control" required placeholder="Exemple : 1234567890" pattern="[0-9]{13}|[0-9]{10}">
                                </div>
                            </div>
                            <div>
                                <button id="recherche" type="button" class="btn btn-primary"   value="Rechercher" />Rechercher</button>
                                <input id="validerisbn"type="button" class="btn btn-danger" onclick="requestEmprunt(info);" value="Ajouter" />
                                <button id="effacer" type="reset" class="btn btn-info"   value="Effacer" />Recommencer</button>

                                <!-- <button type="button" class="btn btn-primary" onclick="request(info);">Rechercher</button> -->

                                <!-- <button id="rend" type="submit" class="btn btn-primary" onclick="javascript: form.action='/ex3';">Envoyer</button> -->
                            </div>
                        </form>
                        <div id="reponse">

                        </div>
                    </div>
                </section>

            </div>

            <!---------------------------------------------------------->

            <div class="tab-pane" id="supprimerexemplaire" role="tabpanel">
              <div style="height:25px;"></div>

                <h1>Supprimer exemplaire </h1>

                <div style="height:25px;"></div>

                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form method="get">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p>Numéro exemplaire</p>
                                </div>
                                <div class="col-sm-6">
                                    <input id="supprimerid" type="text" name="livre" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 123456">
                                </div>

                            </div>
                            <div>
                              <button id="rechercheSupprimer" type="button" class="btn btn-primary"   value="Rechercher" />Rechercher</button>
                              <button id="validerSupprimer" type="button" class="btn btn-danger" onclick="requestSupprimerLivre(info);">Supprimer</button>
                              <button id="effacerSupprimer" type="reset" class="btn btn-info"   value="Effacer" />Recommencer</button>
                            </div>
                        </form>
                        <div id="reponseSupprimerLivre">

                        </div>
                    </div>
                </section>
            </div>

            <!---------------------------------------------------------->

            <div class="tab-pane" id="recapexemplaire" role="tabpanel">
                <h1>Récapitulatif des exemplaires </h1>
                <!-- PROBLEME A CORRIGER AVEC BOOTSTRAP SVP, NIVEAU DESIGN -->
                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form  method="get">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p>Rechercher</p>
                                </div>
                                <div class="col-sm-6">
                                  <input type="text" id="inputRecherche" class="form-control" onkeyup="rechercheLivre()" placeholder="Recherche par titre" title="Type in a name">
                                 </div>
                            </div>
                            <div>
                            </div>
                        </form>

                    </div>
                </section>
                <div id="recap">

                </div>
            </div>

            <!---------------------------------------------------------->

            <div class="tab-pane" id="recapitulatifdesusagers" role="tabpanel">
                <h1>Récapitulatif des usagers </h1>
                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form  method="get">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p>Rechercher</p>
                                </div>
                                <div class="col-sm-6">
                                  <input type="text" id="inputRechercheUsager" class="form-control" onkeyup="rechercheUsager()" placeholder="Recherche par nom" title="Type in a name">
                                 </div>
                            </div>
                            <div>
                            </div>
                        </form>

                    </div>
                </section>
                <div id="recapUsager">

                </div>
            </div>
            <!---------------------------------------------------------->

            <div class="tab-pane" id="retards" role="tabpanel">
                <h1>Retards </h1>
                <div id="retard">

                </div>
            </div>

            <!---------------------------------------------------------->

            <div class="tab-pane" id="ajouterusager" role="tabpanel">
              <div style="height:25px;"></div>

                <h1>Ajouter usager</h1>

                   <div style="height:25px;"></div>

                <section class="row text-center placeholders">
                    <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                        <form  method="get">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <p>Nom de l&apos;usager</p>
                                </div>
                                <div class="col-sm-6">
                                    <input  type="text" name="nomusager" id="usagernom" class="form-control" required pattern="[A-Za-zéèç]+" placeholder="Exemple : POE">
                                </div>

                                <div class="col-sm-6">
                                    <p>Prénom de l&apos;usager</p>
                                </div>
                                <div class="col-sm-6">
                                    <input  type="text" name="prenomusager" id="usagerprenom" class="form-control" required pattern="[A-Za-zéèç]+" placeholder="Exemple : John">
                                </div>

                                <div class="col-sm-6">
                                    <p>Date de naissance de l&apos;usager</p>
                                </div>
                                <div class="col-sm-6">
                                    <input  type="date" name="datenaisusager" id="usagerdatenais" class="form-control" required pattern="(0[1-9]|[1-2][0-9]|3[01])/(0[1-9]|1[0-2])/(19[0-9]{2}|200[0-9]|201[0-3])" placeholder="JJ/MM/AAAA">
                                </div>

                                <div class="col-sm-6">
                                    <p>Sexe de l&apos;usager</p>
                                </div>
                                <div class="col-sm-3">
                                  <select name="sexeusager" id="sexeusager" class="form-control">
                                    <option value="F">Féminin</option>
                                    <option value="M">Masculin</option>
                                  </select>
                                </div>

                                <div class="col-sm-6">
                                    <p>Type d&apos;usager</p>
                                </div>
                                <div class="col-sm-3">
                                  <select name="typeusager" id="typeusager" class="form-control">
                                    <option value="Eleve">&Eacute;l&egrave;ve</option>
                                    <option value="Prof">Professeur</option>
                                    <option value="Gest">Gestionnaire</option>
                                  </select>
                                </div>

                            </div>

                            <div>
                                <button id="ajouterusagerbut" type="button" class="btn btn-primary">Ajouter</button>
                                <button id="recommencerusager" type="reset" class="btn btn-danger">Effacer</button>
                            </div>
                        </form>
                    </div>
                </section>
				<div id="reponseUsager">
                </div>
              </div>

                <!---------------------------------------------------------->

                <div class="tab-pane" id="supprimerusager" role="tabpanel">
                  <div style="height:25px;"></div>

                    <h1>Supprimer usager</h1>

                    <div style="height:25px;"></div>

                    <section class="row text-center placeholders">
                        <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                            <form  method="get">
                              <!-- action="supprimerusager.php" -->
                                <div class="form-group row">

                                    <div class="col-sm-6">
                                        <p>Id de l&apos;usager</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="champsuprid" type="text" name="usagerid" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 24">
                                    </div>

                                </div>
                                <div>
                                  <button id="btnsuprusager" type="button" class="btn btn-danger">Supprimer</button>
                                  <button id="btnrecommencerusager" type="reset" class="btn btn-warning">Recommencer</button>

                                </div>
                            </form>
                            <div id="reponseSupprimerUsager">

                            </div>
                        </div>
                    </section>
                </div>
                                <!---------------------------------------------------------->

                <div class="tab-pane" id="userqrcode" role="tabpanel">
                  <div style="height:25px;"></div>

                    <h1>Générer QR Codes usagers</h1>

                    <div style="height:25px;"></div>

                    <section class="row text-center placeholders">
                        <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">
                            <form  method="get" action="generationUserQrcode.php" target="_blank">
                                <div class="form-group row">

                                    <div class="col-sm-6">
                                        <p>Id de l&apos;usager</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="champqrcodeusid" type="text" name="user" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 24">
                                    </div>

                                </div>
                                <div id="btnqrcodeusager">
                                  <button id="btnusqrcode" type="submit" class="btn btn-danger">Envoyer</button>
                                  <button id="btnrecommencerusqrcode" type="reset" class="btn btn-warning">Recommencer</button>

                                </div>
                            </form>

                        </div>
                    </section>
                    <div class="button-anim">
                      <a href="userQrcode.php" target="_blank" id="aqrcodeusager"><button>Générer tous les QR Codes</button></a>
                    </div>
                </div>
                                <!---------------------------------------------------------->

                <div class="tab-pane" id="exemplaireqrcode" role="tabpanel">
                  <div style="height:25px;"></div>

                    <h1>Générer QR Codes exemplairess</h1>

                    <div style="height:25px;"></div>

                    <section class="row text-center placeholders">
                        <div class="offset-sm-2 col-sm-8 offset-sm-2 placeholder">

                            <form  method="get" action="generationExempQrcode.php" target="_blank">
                                <div class="form-group row">

                                    <div class="col-sm-6">
                                        <p>Id de l&apos;exemplaire</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <input id="champqrcodeexid" type="text" name="livre" class="form-control" required pattern="[0-9]+" placeholder="Exemple : 24">
                                    </div>

                                </div>
                                <div id="btnqrcodeusager">
                                  <button id="btnexqrcode" type="submit" class="btn btn-danger">Envoyer</button>
                                  <button id="btnrecommencerexqrcode" type="reset" class="btn btn-warning">Recommencer</button>

                                </div>
                            </form>

                        </div>
                    </section>
                    <div class="button-anim">
                      <a href="exemplaireQrcode.php" target="_blank" id="aqrcodeusager"><button>Générer tous les QR Codes</button></a>
                    </div>
                </div>
        </main>
    </div>
</div>
<script type='text/javascript' src='js/req.js'></script>

HTML;

$html->appendContent($page);



$html->appendJsUrl('https://code.jquery.com/jquery-3.1.1.slim.min.js');
$html->appendJsUrl('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js');
$html->appendJsUrl('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js');

$html->appendContent('<script type="text/javascript">
    jQuery(function() {
        jQuery("#classe").change(function() {
            this.form.submit();
        });
    });
</script>');

echo $html->toHTML();

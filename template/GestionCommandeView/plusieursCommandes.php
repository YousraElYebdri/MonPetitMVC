<?php
include_once PATH_VIEW . "header.html";
echo "<p>Nombre de clients trouvés: ".count($commandes)."</p>";

foreach($commandes as $commande){
    echo $commande->getId() . " -- Date: ".$commande->getDateCde()." -- N°: ".($commande->getNoFacture() ? $commande->getNoFacture(): 'Non facturée')." -- Id Client: ".$commande->getIdClient(). "<br>" ;
}
include_once PATH_VIEW . "footer.html";



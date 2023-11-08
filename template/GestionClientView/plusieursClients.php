<?php
Include_once PATH_VIEW ."header.html";
echo "<p>Nombre de clients trouvés: ".count($clients)."</p>";

foreach($clients as $client){
    echo $client->getId() . " " . $client->getTitreCli(). " " 
            . $client->getNomCli() . " " . $client->getPrenomCli() . " " 
            . $client->getAdresseRue1Cli() . " " 
            . $client->getAdresseRue2Cli() . " " 
            . $client->getCpCli() . " " 
            . $client->getTelCli() . "<br>";
}
Include_once PATH_VIEW . "footer.html";
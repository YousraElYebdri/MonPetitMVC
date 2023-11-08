<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\GestionClientModel;
use ReflectionClass;
use App\Exceptions\AppException;
use Tools\MyTwig;

class GestionClientController {

    public function chercheUn(array $params) {
        $modele = new GestionClientModel();
        // on recupere tous les id des clients
        $ids = $modele->findInds();
        //on place les ids trouvés dans le tableau des parametres a envoyer a la vue
        $params['lesIds'] = $ids;
        //on test si l'id du client a cher chercher a ete passee dans l'url
        if (array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
            $unClient = $modele->find($id);
            if ($unClient) { // Pour vérifier le fait que l'on récupère bien un client.
                $params['unClient'] = $unClient;
            } else {
                $params['message'] = "Client" . $id . "inconnu";
            }
        }
        $r = new ReflectionClass($this); //Pour créer un objet de type client
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClient.html.twig";
        MyTwig::afficheVue($vue, $params);
    }

    public function chercheTous(array $params) {
        $modele = new GestionClientModel();
        $clients = $modele->findAll();
        if ($clients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.html.twig";
            MyTwig::afficheVue($vue, array('clients'=> $clients));
        } else {
            throw new AppException("Aucun client à afficher");
        }
    }

    public function creerClient(array $params) {
        $vue = "GestionClientView\\creeClient.html.twig";
        MyTwig::afficheVue($vue, array());
    }

    public function enregisterClient(array $params) {
        try {
            //création de l'objet client à partir des données du formulaire 
            $client = new Client($params);
            $modele = new GestionClintModel();
            $modele->enregistreClient($client);
        } catch (Exception) {
            throw new AppException("Erreur à l'enregistrement d'un nouveau client");
        }
    }

}

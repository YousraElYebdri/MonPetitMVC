<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\GestionClientModel;
use ReflectionClass;
use App\Exceptions\AppException;
use Tools\MyTwig;
use Tools\Repository;
use App\Entity\Client;
use App\Repository\ClientRepository;

class GestionClientController {

    public function chercheUn(array $params) {
        $repository = Repository::getRepository("Client");
        // on recupere tous les id des clients
        $ids = $repository->findIds();
        //on place les ids trouvés dans le tableau des parametres a envoyer a la vue
        $params['lesIds'] = $ids;
        //on test si l'id du client a cher chercher a ete passee dans l'url
        if (array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
            $unClient = $repository->find($id);
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

    public function chercheTous(): void {
        $repository = Repository::getRepository("App\Entity\Client");
        $clients = $repository->findAll();
        if ($clients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/plusieursClients.html.twig";
            MyTwig::afficheVue($vue, array('clients' => $clients));
        } else {
            throw new AppException("Aucun client à afficher");
        }
    }
    
    public function chercheUnAjax(array $params): void {
        $repository = Repository::getRepository("App\Entity\Client");
        $ids = $repository->findIds();
        $params['lesIds'] = $ids;
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClientAjax.html.twig";
        MyTwig::afficheVue($vue, $params);
        
    }
    
    public function creerClient(array $params): void {

      if (empty($params)) {    
            $vue = "GestionClientView\\creeClient.html.twig";
            MyTwig::afficheVue($vue, array());
        } else {
            try {
                //$params = $this->verificationSaisieClient($params);
                // creation de l'obejt client a partir des données du formulaire
                $client = new Client($params);
                $repository = Repository::getRepository("App\Entity\Client");
                $repository->insert($client);
                $this->chercheTous();
            } catch (Exception) {
                throw new AppException("Erreur a l'enregistrement d'un nouveau client");
            }
        }
    }
    
    public function nbClients(array $params) : void {
        
        $repository = Repository::getRepository("App\Entity\Client");
        $nbClients = $repository->countRows();
        echo "nombre de clients : " . $nbClients;
    }

    private function verificationSaisie(array $params) : array {
//        try{
//          $client = 
//        } catch (Exception $ex) {
//
//        }
    }
    
    public function statsClients(array $params) : void {
        $ClientRepository = Repository::getRepository("App\Entity\Client");
        $statsClients = $ClientRepository->statistiquesTousClients();
        if ($statsClients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) . "/statsClients.html.twig";
            MyTwig::afficheVue($vue, array('statsclients' => $statsClients));
        } else {
            throw new AppException("Aucun client à afficher");
        }
        
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

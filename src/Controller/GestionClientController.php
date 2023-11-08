<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\GestionClientModel;
use ReflectionClass;
use App\Exceptions\AppException;
use Tools\MyTwig;


class GestionClientController {

    public function chercheUn(array $params){
        $modele = new GestionClientModel();
        $id = filter_var(intval($params["id"]),FILTER_VALIDATE_INT);
        $unClient = $modele->find($id);
        if($unClient){ // Pour vérifier le fait que l'on récupère bien un client.
            $r = new ReflectionClass($this); //Pour créer un objet de type client
            $vue = str_replace('Controller', 'View', $r->getShortName()). "/unClient.html.twig";
            MyTwig::afficheVue($vue, array('unClient' => $unClient));
        }else{
            throw new AppException("Client " .$id ." inconnu");
        }
    }
    
    public function chercheTous(){
        $modele = new GestionClientModel();
        $clients = $modele->findAll();
          if($clients){
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller','View',$r->getShortName()). "/plusieursClients.php";
        }
        else {
            throw new AppException("Aucun client à afficher");
        }
    }
    
    public function creerClient(array $params){
        $vue = "GestionClientView\\creeClient.html.twig";
        MyTwig::afficheVue($vue, array());
    }
    
    public function enregisterClient(array $params){
        try{
            //création de l'objet client à partir des données du formulaire 
            $client = new Client($params);
            $modele=new GestionClintModel();
            $modele->enregistreClient($client);
        } catch (Exception) {
            throw new AppException("Erreur à l'enregistrement d'un nouveau client");
        }
    }
    
}

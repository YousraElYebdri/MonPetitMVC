<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\GestionClientModel;
use ReflectionClass;
use App\Exceptions\AppException;


class GestionClientController {

    public function chercheUn(array $params){
        $modele = new GestionClientModel();
        $id = filter_var(intval($params["id"]),FILTER_VALIDATE_INT);
        $unClient = $modele->find($id);
        if($unClient){ // Pour vérifier le fait que l'on récupère bien un client.
            $r = new ReflectionClass($this); //Pour créer un objet de type client
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()). "/unClient.php";
        }else{
            throw new AppException("Client " .$id ." inconnu");
        }
    }
    
    public function chercherTous(){
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
    
    
}

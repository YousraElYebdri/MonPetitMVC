<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\GestionClientModel;
use ReflectionClass;
use App\Exceptions\AppException;


class GestionClientController {

    public function chercherUn(array $params){
        $modele = new GestionClientModel();
        $id = filter_var(intval($params["id"]),FILTER_VALIDATE_INT);
        $unClient = $modele->find($id);
        if($unClient){
            $r = new ReflectionClass($this);
            include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()). "/unClient.php";
        }else{
            throw new AppException("Client " .$id ." inconnu");
        }
    }
    
    
}

<?php
declare(strict_types=1);

namespace App\Model;
use App\Entity\Client;
use Tools\Connexion;
use Exception;
use App\Exceptions\AppException;
use PDO;
class GestionClientModel {
    
    public function find(int $id): Client{
        try{
            $unObjetPdo = Connexion::getConnexion();
            $sql = "SELECT * FROM CLIENT where id=:id";
            $ligne = $unObjetPdo->prepare($sql);
            $ligne->bindValue(':id', $id, PDO::PARAM_INT);
            $ligne->execute();
            return $ligne->fetchObject(Client::class); // Permet de récuperer en ligne les valeur de la base
        } catch (Exception $ex) {
            throw new AppException("Erreur inattendue");
        }
    }
    
    public function findAll(): Array{
        try{
            $unObjetPdo = Connexion::getConnexion();
            $lignes = $unObjetPdo->query("SELECT * FROM CLIENT");
            return $lignes->fetchAll(PDO::FETCH_CLASS, Client::class);
        } catch (Exception $ex) {
            throw new AppException("Erreur d'application");
        }
        
    }
    
}

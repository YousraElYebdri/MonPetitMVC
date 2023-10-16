<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Commande;
use PDO;
use App\Exceptions\AppException;
use Tools\Connexion;

class GestionCommandeModel {

    public function find(int $id) {
        try {
            $unObjetPdo = Connexion::getConnexion();
            $sql = "SELECT * FROM COMMANDE where id=:id";
            $ligne = $unObjetPdo->prepare($sql);
            $ligne->bindValue(':id', $id, PDO::PARAM_INT);
            $ligne->execute();
            return $ligne->fetchObject(Commande::class); // Permet de récuperer en ligne les valeur de la base
        } catch (Exception $ex) {
            throw new AppException("Erreur inattendue");
        }
    }

    public function findAll() {
        try {
            $unObjetPdo = Connexion::getConnexion();
            $lignes = $unObjetPdo->query("SELECT * FROM COMMANDE");
            return $lignes->fetchAll(PDO::FETCH_CLASS, Commande::class);
        } catch (Exception $ex) {
            throw new AppException("Erreur d'application");
        }
    }
}

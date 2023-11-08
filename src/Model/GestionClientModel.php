<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Client;
use Tools\Connexion;
use Exception;
use App\Exceptions\AppException;
use PDO;

class GestionClientModel {

    public function find(int $id): Client {
        try {
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
    
    public function findInds(){
        try {
            $unObjetPdo = Connexion::getConnexion();
            $sql = "SELECT id FROM CLIENT";
            $lignes = $unObjetPdo->query($sql);
            // on vas configur"er le mode objet pour la lisibillité du code
            if ($lignes->rowCount() > 0){
                //$lignes -> setFetchMode();
                $t = $lignes->fetchAll(PDO::FETCH_ASSOC);
                return $t;
            }else {
                throw new AppException('Aucun client trouvé');
            }
        } catch (PDOException) {
            throw new AppException("Erreur technique inattendue");
        }
    }
    public function findAll(): Array {
        try {
            $unObjetPdo = Connexion::getConnexion();
            $lignes = $unObjetPdo->query("SELECT * FROM CLIENT");
            return $lignes->fetchAll(PDO::FETCH_CLASS, Client::class);
        } catch (PDOException) {
            throw new AppException("Erreur d'application");
        }
    }

    public function enregistreClient(Client $client) {
        try {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "insert into client(titreCli, nomCli, prenomCli, adresseRue1Cli, adresseRue2Cli, cpCli, villeCli, telCli)"
                ."values(:titreCli, :nomCli, :prenomCli, :adresseReuCli, :adresseCliRue2Cli, :cpCli, :villeCli, :telCli)";
        $s = $unObjetPdo->prepare($sql);
        $s->bindValue(':titreCli',$client->getTitreCli(), PDO::PARAM_STR);
        $s->bindValue(':nomCli',$client->getNomCli(), PDO::PARAM_STR);
        $s->bindValue(':prenomCli',$client->getPrenomCli(), PDO::PARAM_STR);
        $s->bindValue(':adresseRue1Cli',$client->getAdresseRue1Cli(), PDO::PARAM_STR);
        $s->bindValue(':adresseRue2Cli', ($client->getAdresseRue2Cli() == "") ?(null) : ($client->getAdresseRue2Cli()), PDO::PARAM_STR);
        $s->bindValue(':cpCli',$client->getCpCli(), PDO::PARAM_STR);
        $s->bindValue(':villeCli',$client->getVilleCli(), PDO::PARAM_STR);
        $s->bindValue(':telCli',$client->getTelCli(), PDO::PARAM_STR);
        $s->execute();
        } catch (PDOException) {
            throw new AppException("erreur technique inattendue");
        }
    }

}

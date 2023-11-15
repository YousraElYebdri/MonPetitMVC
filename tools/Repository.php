<?php

declare (strict_types=1);

namespace Tools;

use PDO;

abstract class Repository {

    private string $classeNameLong;
    private string $classeNameSpace;
    private string $table;
    private PDO $connexion;

    private function __construct(string $entity) {
        $tablo = explode("\\", $entity);
        $this->table = array_pop($tablo);
        $this->classeNameSpace = implode("\\", $tablo);
        $this->classeNameLong = $entity;
        $this->connexion = Connexion::getConnexion();
    }

    public static function getRepository(string $entity): Repository {
        $repositoryName = str_replace('Entity', 'Repository', $entity) . 'Repository';
        $repository = new $repositoryName($entity);
        return $repository;
    }

    public function find(int $id): ?object {
        try {
            $sql = "SELECT * FROM  " . $this->table . " where id=:id";
            $ligne = $this->connexion->prepare($sql);

            $ligne->bindValue(':id', $id, PDO::PARAM_INT);
            $ligne->execute();
            return $ligne->fetchObject($this->classeNameLong); // Permet de récuperer en ligne les valeur de la base
        } catch (PDOException) {
            throw new AppException("Erreur inattendue");
        }
    }

    public function findAll(): array {
        $sql = "select * from " . $this->table;
        $lignes = $this->connexion->query($sql);
        $lignes->setFetchMode(PDO::FETCH_CLASS, $this->classeNameLong, null);
        return $lignes->fetchAll();
    }

    public function findIds(): array {
        try {
            $sql = "SELECT id FROM " . $this->table;
            $lignes = $this->connexion->query($sql);
            // on vas configur"er le mode objet pour la lisibillité du code
            if ($lignes->rowCount() > 0) {
                //$lignes -> setFetchMode();
                $t = $lignes->fetchAll(PDO::FETCH_ASSOC);
                return $t;
            } else {
                throw new AppException('Aucun client trouvé');
            }
        } catch (PDOException) {
            throw new AppException("Erreur technique inattendue");
        }
    }

    public function insert(object $objet): void {
        //conversion d'un objet en tableau
        $attributs = (array) $objet;
        array_shift($attributs);
        $colonnes = "(";
        $colonnesParams = "(";
        $parametres = array();
        foreach ($attributs as $cle => $valeur) {
            $cle = str_replace("\0", "", $cle);
            $c = str_replace($this->classeNameLong, "", $cle);
            $p = ":" . $c;
            if ($c != "id") {
                $colonnes .= $c . " ,";
                $colonnesParams.= " ? ,";
                $parametres[] = $valeur;
            }
        }
        $cols = substr($colonnes, 0, -1);
        $colsParams = substr($colonnesParams, 0, -1);
        $sql = "insert into " . $this->table . " " . $cols . ") values " . $colsParams . ")";
        $unObjetPDO = connexion::getConnexion();
        $req = $unObjetPDO->prepare($sql);
        $req->execute($parametres);
    }
    
    public function countRows() : int {
      return  count($this->findAll());
    }
    
    public function executeSQL (string $sql) : ?array {
        $resultat = $this->connexion->query($sql);
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }
}

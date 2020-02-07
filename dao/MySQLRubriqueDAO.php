<?php
require_once("ConnexionBdd.php");
require_once dirname(__DIR__).'/domain/Rubrique.php'; 
require_once ('RubriqueDAO.php');


class MySQLRubriqueDAO implements RubriqueDAO{
    private $tab=array();
    private $cnx;   

    public function __construct($cnx=null){
        $this->cnx=ConnexionBdd::getConnexion();
        return $this->cnx;
    }

        // Insert Rubrique $r
        public function insert(Rubrique $r){
            try {      
                $this->cnx->beginTransaction();
                $requete = "INSERT INTO rubrique(libelle) VALUES(:libelle)"; 
                $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array('libelle'=>$r->getLibelle()));  
                $lastId=$this->cnx->lastInsertId();
                $this->cnx->commit();
                return $lastId;
                
            } catch (PDOException $e) {
                echo($e->getMessage()."\n");
                echo ((int)$e->getCode()."\n");
                $this->cnx->rollback();
                return null;
            }
        }

        //Delete Rubrique $r
        public function delete(Rubrique $r){
            try {      
                $this->cnx->beginTransaction();
                $requete = "DELETE FROM rubrique WHERE id_rubrique=:idRubrique"; 
                $bdh=$this->cnx->prepare($requete);
                $bdh->execute(array('idRubrique'=>$r->getId()));
                $this->cnx->commit();
                return $bdh->rowCount();
                
            } catch (PDOException $e) {
                echo($e->getMessage()."\n");
                echo ((int)$e->getCode()."\n");
                $this->cnx->rollback();
                return null;
            }
        }

        // Update Rubrique $r
        public function update(Rubrique $r){
            try {      
                $this->cnx->beginTransaction();
                $requete = "UPDATE rubrique SET libelle=:libelle WHERE id_rubrique=:idRubrique"; 
                $bdh=$this->cnx->prepare($requete);
                $bdh->execute(array('idRubrique'=>$r->getId(),'libelle'=>$r->getLibelle()));  
                $this->cnx->commit();
                return $bdh->rowCount();
                
            } catch (PDOException $e) {
                echo($e->getMessage()."\n");
                echo ((int)$e->getCode()."\n");
                $this->cnx->rollback();
                return null;
            }  
        }

        public function getAll(){
        try {
            // requête select ->objets
            // si les champs de la classe coincident avec ceux de la table 
            $stmt = $this->cnx->query('SELECT libelle,id_rubrique FROM rubrique');
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Rubrique');
            $data = $stmt->fetchAll();
            return $data;
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            return null;
        }
    }
}

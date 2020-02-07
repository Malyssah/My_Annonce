<?php
require_once ("ConnexionBdd.php");
require_once dirname(__DIR__).'/domain/Annonce.php'; 
require_once ('AnnonceDAO.php');
require_once ("BDDException.php");

class MySQLAnnonceDAO implements AnnonceDAO{
    private $cnx;

    public function __construct($cnx=null){
        $this->cnx=ConnexionBdd::getConnexion();
        return $this->cnx;
    }
    //Insert Annonce $a
    public function insert(Annonce $a){
        try {      
            $this->cnx->beginTransaction();
            $requete = "INSERT INTO annonce(ID_RUBRIQUE,ID_UTILISATEUR,ENTETE,CORPS,DATE_DEPOT,DATE_VALIDITE)
            VALUES(:idRubrique,:idRedacteur,:entete,:corps,:depot,:validite)";  
            $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array(
                'idRedacteur'=>$a->getUtilisateur()->getId(),
                'idRubrique'=>$a->getRubrique()->getId(),
                'entete'=>$a->getEntete(),
                'corps'=>$a->getCorps(),
                'depot'=>$a->getDate(),
                'validite'=>$a->getValide()
            ));  
            $this->cnx->commit();
            $lastId=$this->cnx->lastInsertId();
            return $lastId;
                
        } catch (PDOException $e) {
            throw new BDDException("Erreur: Insertion annulée",10001);
            $this->cnx->rollback();
            return null;
        }
    }

    //Delete Annonce $a
    public function delete(Annonce $a){
        try {      
            $this->cnx->beginTransaction();
            $requete = "DELETE FROM annonce WHERE id_annonce=:idAnnonce"; 
            $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array('idAnnonce'=>$a->getId()));
            $this->cnx->commit();
            return $bdh->rowCount();
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }
    }

//Update Annonce $a
    public function update(Annonce $a){
        try {      
            $this->cnx->beginTransaction();
            $requete = "UPDATE annonce SET entete=:entete,corps=:corps WHERE id_annonce=:idAnnonce"; 
            $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array('idAnnonce'=>$a->getId(),'entete'=>$a->getEntete(),'corps'=>$a->getCorps()));  
            $this->cnx->commit();
            return $bdh->rowCount();
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }  
    }

    // getBy Rubrique $ru
    public function getByCategory(Rubrique $ru){
        try {
            require_once '../dao/MySQLUtilisateurDAO.php';
    require_once '../domain/Utilisateur.php';
            $this->cnx->beginTransaction();
            $requete ="SELECT id_annonce,id_rubrique,id_utilisateur,entete,corps,date_depot,date_validite
            FROM annonce WHERE id_rubrique=:idRubrique";
            $bdh=$this->cnx->prepare($requete);
            $bdh->setFetchMode(PDO::FETCH_ASSOC);
            $bdh->execute(array('idRubrique'=>$ru->getId()));  
            $data = $bdh->fetchAll();
            $a=array();//tableau d'annonce
            foreach($data as $j){
                $u=new Utilisateur('','','','','','',$j['id_utilisateur']); //pour récupérer l'id utilisateur
                $a[]=new Annonce($j['entete'],$j['corps'],$j['date_depot'],$j['date_validite'],$ru,$u,$j['id_annonce']); // creation nouvelle annonce
            }
            $this->cnx->commit();
            return $a;
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }
    }

    //getBy Utilisateur $u
    public function getByUser(Utilisateur $u){
        try {
           
            $this->cnx->beginTransaction();
            $requete ="SELECT id_annonce,id_rubrique,id_utilisateur,entete,corps,date_depot,date_validite
            FROM annonce WHERE id_utilisateur=:idUtilisateur";
            $bdh=$this->cnx->prepare($requete);
           $bdh->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Annonce');
            $bdh->execute(array('idUtilisateur'=>$u->getId()));
            $data = $bdh->fetchAll();
            $this->cnx->commit();
            return $data;
            
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }
    }

    // //Delete Périmé
    public function deletePerime(){
        try {
            $stmt = $this->cnx->query('SELECT id_annonce,id_rubrique,id_utilisateur,entete,corps,date_emission,date_validite
            FROM annonce WHERE date_validite<NOW()');
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Annonce');
            $data = $stmt->fetchAll();
            foreach($data as $j){
                $d=$this->delete($j->getId()); 
            }
            return count($data);
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            return null;
        }   
    }


    //update rubrique
    public function updateRubrique($id,$idRubrique){
        try {      
            $this->cnx->beginTransaction();
            $requete = "UPDATE annonce SET id_rubrique=:idRubrique WHERE id_annonce=:idAnnonce"; 
            $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array('idAnnonce'=>$id,'idRubrique'=>$idRubrique));  
            $this->cnx->commit();
            return $bdh->rowCount();
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }  
    }


    // get by ID
    public function getByIdAnnonce(int $id){
        try {
           
            $this->cnx->beginTransaction();
            $requete ="SELECT id_annonce,id_rubrique,id_utilisateur,entete,corps,date_depot,date_validite
            FROM annonce WHERE id_annonce=:idAnnonce";
            $bdh=$this->cnx->prepare($requete);
            $bdh->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Annonce');
            $bdh->execute(array('idAnnonce'=>$id));
            $data = $bdh->fetch();
            $this->cnx->commit();
            return $data;
            
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            $this->cnx->rollback();
            return null;
        }
    }
}



<?php

/**
 * Modif 28/11/19
 * échange :  le nom contre l'email pour l'identification
 * rajout : email lors de l'insert 
 * rajout : username lors de l'insert
 */

require_once ("ConnexionBdd.php");
require_once dirname(__DIR__).'/domain/Utilisateur.php'; 
require_once ('UtilisateurDAO.php');

class MySQLUtilisateurDAO implements UtilisateurDAO{
    private $cnx;

    public function __construct($cnx=null){
        $this->cnx=ConnexionBdd::getConnexion();
        return $this->cnx;
    }

    //Insert Utilisateur $u
    //doit retourner l'utilisateur inséré avec son Id
    public function insert(Utilisateur $u){
        try {      
            $this->cnx->beginTransaction();
            $requete = "INSERT INTO utilisateur(nom,prenom,email,username,mdp) VALUES(:nom, :prenom, :email, :username, :mdp)"; 
            $bdh=$this->cnx->prepare($requete);
            $bdh->execute(array('nom'=>$u->getNom(),'prenom'=>$u->getPrenom(),'email'=>$u->getEmail(),'username'=>$u->getUsername(),'mdp'=>sha1($u->getPass())));  
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

    //Connexion Utilisateur $u
    //doit retourner l'utilisateur identifié avec son Id
    public function identifier(utilisateur $u){
        try {
            $this->cnx->beginTransaction();
            $requete ="SELECT id_utilisateur,nom,prenom,email,username,mdp
            FROM utilisateur WHERE username=:username AND email=:email AND mdp=:mdp";
            $bdh=$this->cnx->prepare($requete);
            $bdh->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Utilisateur');
            $bdh->execute(array('username'=>$u->getUsername(),'email'=>$u->getEmail(),'mdp'=>sha1($u->getPass())));
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

    public function getAll(){
        try {
            // requête select ->objets
            // si les champs de la classe coincident avec ceux de la table 
            $stmt = $this->cnx->query('SELECT id_utilisateur,nom FROM utilisateur');
            $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Utilisateur');
            $data = $stmt->fetchAll();
            return $data;
            
        } catch (PDOException $e) {
            echo($e->getMessage()."\n");
            echo ((int)$e->getCode()."\n");
            return null;
        }
    }
}



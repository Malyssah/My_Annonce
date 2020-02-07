<?php


class Utilisateur{
    private $id_utilisateur; //int
    private $email; //string
    private $nom; //string
    private $prenom; //string
    private $username; //string
    private $mdp; //int
    private $admin;
    
    //construct
    public function __construct($nom='',$prenom='', $email='', $username='', $mdp='',$admin="", $id_utilisateur=-1){
        $this->id_utilisateur=$id_utilisateur;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->email=$email;
        $this->username=$username;
        $this->mdp=$mdp;
        $this->admin=$admin;
    }
/**
 * getteurs / setter
 */
    //id utilisateur
    public function getId(){
        return $this->id_utilisateur;
    }
    public function setID($id_utilisateur){
        $this->id_utilisateur=$id_utilisateur;
    }

    //nom utilisateur
    public function getNom(){
        return $this->nom;
    }
    public function setNom($nom){
        $this->nom=$nom;
    }

    //prenom utilisateur
    public function getPrenom(){
        return $this->prenom;
    }
    public function setPrenom($prenom){
        $this->prenom=$prenom;
    }


    //email utilisateur
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email=$email;
    }

    //username utilisateur
    public function getUsername(){
        return $this->username;
    }
    public function setUsername($username){
        $this->username=$username;
    }
    
    //mot de mdpe utilisateur
    public function getPass(){
        return $this->mdp;
    }
    public function setPass($mdp){
        $this->mdp=$mdp;
    }

    //admin
    public function getAdmin(){
        return $this-admin;
    }
    public function setAdmin($admin){
        $this->admin=$admin;
    }
    
/**
 * functions
 */
    //toString
    public function __toString(){
            $text="(".$this->getNom().")";
        return $text;
    }
}

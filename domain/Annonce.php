<?php
class Annonce{
    private $id_annonce; //int
    private $rubrique; //rubrique
    private $utilisateur; //utilisateur
    private $entete; //string
    private $corps; //string
    private $date_depot; //date
    private $date_validite; //date

    //construct
    public function __construct($entete='',$corps='',string $date_depot=null,
                string $date_validite=null,Rubrique $rubrique=NULL, Utilisateur $utilisateur=NULL,$id_annonce=-1){ 
        $this->id_annonce=$id_annonce;
        $this->rubrique=$rubrique;
        $this->utilisateur=$utilisateur;
        $this->entete=$entete;
        $this->corps=$corps;
        $this->date_depot=$date_depot;
        $this->date_validite=$date_validite;
    }

/**
 * getter / setter
 */
    //id annonce
    public function getId(){
        return $this->id_annonce;
    }
    public function setId($id_annonce){
        $this->id_annonce=$id_annonce;
    }
    
    //id rubrique
    public function getRubrique(){
        return $this->rubrique;
    }
    public function setRubrique($rubrique){
        $this->rubrique=$rubrique;
    }

    //id utilisateur
    public function getUtilisateur(){
        return $this->utilisateur;
    }
    public function setUtilisateur($utilisateur){
        $this->utilisateur=$utilisateur;
    }
    
    //entête annonce
    public function getEntete(){
        return $this->entete;
    }
    public function setEntete($entete){
        $this->entete=$entete;
    }
    
    //corp annonce
    public function getCorps(){
        return $this->corps;
    }
    public function setCorps($corps){
        $this->corps=$corps;
    }
   
    //Date dépot annonce
    public function getDate(){
        return $this->date_depot;
    }
    public function setDate($date_depot){
        $this->date_depot=$date_depot;
    }

    //Date annonce périmée
    public function getValide(){
        return $this->date_validite;
    }
    public function setIdValide($date_validite){
        $this->date_validite=$date_validite;
    }

/**
 * functions
 */
    //toString
    public function __toString(){
        $text="(".$this->getEntete().")";
    return $text;
    }
}   

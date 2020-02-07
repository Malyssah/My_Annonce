<?php

class Rubrique{
    private $id_rubrique; //int
    private $libelle; //string
    
    //construct
    public function __construct($libelle='',$id_rubrique=-1){
        $this->id_rubrique=$id_rubrique;
        $this->libelle=$libelle;
    }

/**
 * getteurs / setter
 */
public function getId(){
    return $this->id_rubrique;
}

public function setId($id_rubrique){
    $this->id_rubrique = $id_rubrique;
}

public function getLibelle(){
    return $this->libelle;
}

public function setLibelle($libelle){
    $this->libelle = $libelle;
}
    
/**
 * functions
 */
    //toString
    public function __toString(){
            $text="(".$this->getLibelle().")";
        return $text;
    }
}

<?php

interface AnnonceDAO{
    public function insert(Annonce $a);
    public function delete(Annonce $a);
    public function update(Annonce $a);
    public function getByCategory(Rubrique $ru);
    public function getByUser(Utilisateur $u);
    public function deletePerime();

    
}


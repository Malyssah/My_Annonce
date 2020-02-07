<?php

interface RubriqueDAO{

public function insert(Rubrique $r);
public function delete(Rubrique $r);
public function update(Rubrique $r);
public function getAll();

}


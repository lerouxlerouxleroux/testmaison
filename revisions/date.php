<?php

class Voiture(){

    //On d�finit d'alors les attributs.

    $marque;
   
    function __construct($marque){
        $this->marque = $marque;
    }

}

$ferrari = new Voiture("ferrari");

$lada = new Lada();

?>
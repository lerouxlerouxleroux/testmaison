<?php
abstract class Personne
{   
    private $_nom;
    private $_prenom;
    private $_age;
    function __construct(){}
    function setNom($nom)
    {
        $this->_nom = $nom;
    }
    function getNom()
    {
        return($this->_nom);
    }

    static function bonjour()
    {
        echo "BONJOUR";
    }

}

class Eleve extends Personne
{
    private $_classe;
}

//Déclaration de la classe qui défiit un objet
class Enseignant extends Personne
{
    private $_salaire;
}

//Notion d'héritage : pour que les élèves aient nom, prénom, âge + class et que les enseignants aient nom, prénom et âge + salaire.
$eleve = new Eleve();//Instantiation de l'objet
$eleve->setNom("Kevin");//Appel de méthode avec un argument (Kevin)
echo $eleve->getNom();

$enseignant1 = new Enseignant();
$enseignant1->setNom("Brice");//Appel de méthode avec un argument (Brice)
echo $enseignant1->getNom();

$enseignant2 = new Enseignant();
$enseignant2->setNom("Marcel");
echo $enseignant2->getNom();

$professeur = new Enseignant();

$professeur->setNom("Nicolas");
echo $professeur->getNom();

Eleve::bonjour();

?>

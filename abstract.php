<?php

abstract class Travailleur{
    abstract public function travailler();
}

class Employe extends Travailleur {

    public $prenom;
    public $nom ;
    protected $age;


    //construct
    public function __construct($prenom, $nom , $age){
        // var_dump("Je suis un constructeur");
        $this->prenom = $prenom;
        $this->nom = $nom ;
        $this->setAge($age);
    }
    public function presentation(){
        var_dump("Salut , je suis $this->nom $this->prenom et j'ai {$this->getAge()} ans");
    }
    public function setAge($age){
        if(is_int($age) && $age >=1 && $age <= 120){

        }else{
            throw new Exception("L'age de l'employé doit être un entier entre 1 et 120");
        }
    }
    public function getAge(){
        return $this->age;
    }
    public function travailler(){
        return "Je suis un employe et je travaille";
    }
}

class Patron extends Employe{
    public $voiture;
    public function __construct($prenom, $nom, $age, $voiture){
        parent::__construct($prenom, $nom, $age);
        $this->voiture = $voiture;
    }
    public function rouler(){

        var_dump("Je suis le patron et je roule avec une voiture");
    }
    public function presentation(){
        var_dump("Bonjour , je suis $this->nom $this->prenom et j'ai $this->age ans");
    }
    public function travailler(){
        return "Je suis le patron et je travaille aussi !";
    }
}
class Etudiant extends Travailleur{

    public function travailler(){
        return "Je suis un etudiant, et je revise";
    }
}
$employe = new Employe("Said", "Soumah", 28);

// $employe->prenom = "said";
// $employe->nom = "soumah";
// $employe->age = 28;

$employe2 = new Employe("Free", "Dev", 28);
// $employe2->prenom = "free";
// $employe2->nom = "way";
// $employe2->age = 28;

// //function presentation
// function presentation($nom, $prenom, $age){
//     var_dump("Bonjour , jsuis $nom $prenom et j'ai $age ans");
// }

// $employe->presentation($employe->nom, $employe->prenom, $employe->age);
// $employe2->presentation($employe2->nom, $employe2->prenom, $employe2->age);

$employe->presentation();
$employe2->presentation();


$patron = new Patron("SS", "TS", 44, "BMW");
$patron->rouler();
$patron->presentation();

$etudiant = new Etudiant();


faireTravailler($employe);
faireTravailler($patron);
faireTravailler($etudiant);
function faireTravailler(Travailleur $objet){
    var_dump("Travail encours :{$objet->travailler()}");
}
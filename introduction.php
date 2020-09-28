<?php
// une interface est une class qui ne peut etre instantié et aussi qui ne contient que des methode sans corps et toute class qui implement une interface doit aussi redefinir toutes ces methodes quelles contiennent 
interface Travailler{
    // methode interface sans corps
    public function travail();
}
// tout comme les interfaces mais les class abstract contient des methodes abstract et peut aussi contenir des methodes non abstract  mais on ne peut tout de même pas les instantiaé
abstract class Travailleur{
    public abstract function travail();
}
class Person extends Travailleur{
    // attributes
    protected $firstname;
    protected $lastname;
    private $old;
    // construct
    public function __construct($firstname, $lastname, $old){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->setOld($old);
    }
    // methode fullname
    public function fullname(){
        return $this->firstname." ".$this->lastname;
    }
    // methode dance
    public function dance(){
        var_dump($this->firstname." est entrain de danser");
    }
    // methode return old in nbr day
    public function getOld(){
        return $this->old*365;
    }
    // setOld
    public function setOld($old){
        if(!is_int($old) || $old < 0 ||  $old > 120){
            throw new Exception("It's not a old please enter a valable age");
        }else{
            $this->old = $old;
        }
    }
    // methode presentation
    public function presentation(){
        var_dump("Hello my name's $this->firstname $this->lastname and i'am $this->old years old ");
    }
    public function travail(){
        var_dump("Je suis un employé et je travail ...");
    }
}
class Etudiant implements Travailler{
    // redefinition  de la methode travail 
    public function travail(){
        var_dump("Je ne suis pas un employé mais je travail");
    }
}
// instantiation 
$person = new Person("Free", "Dev", 28);
echo"<pre>";
var_dump($person);
var_dump($person->fullname());
$person->dance();
echo $person->getOld()." Jours";
$person->presentation();
echo"</pre>";
// class Patron extends to class Person
class Patron extends Person{
    // attributes
    private $car;
    // constructor
    public function __construct($firstname, $lastname, $old, $car){
        // heritier du constructeur de base
        parent::__construct($firstname, $lastname, $old);
        $this->car = $car;
    }
    // redefinition de la methode presentation
    public function presentation(){
        var_dump("Hello my name's $this->firstname $this->lastname and i'am {$this->getOld()} years old ");
    }
}
$patron = new Patron("Said", "Soumah", 29, "BMW");

echo"<pre>";
var_dump($patron);
$patron->presentation();
echo "</pre>";

// function faireTravailler
function faireTravailler($object){
    var_dump("Faire Travailler: {$object->travail()}");
}
$etudiant = new Etudiant();
echo"<pre>";
faireTravailler($person);
faireTravailler($patron);
faireTravailler($etudiant);
echo"</pre>";
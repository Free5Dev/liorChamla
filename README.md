# local server in php 
php -S localhost:8000
# example en procedural sans passer par poo comme quoi c'est repetitif
<?php 

$firstName="Said";
$lastName="Soumah";
$old=28;

$firstName2="Free";
$lastName2="Dev";
$age=28;

function presentation($firstName, $lastName, $age){
    var_dump("Hello my name is $firstName - $lastName and i'am $age yes old");
}

presentation($firstName, $lastName, $old);
presentation($firstName2, $lastName2, $age);
# example avec la methode oriente object
<?php 

class Employe{
    // les variables en procedural sont appeler attributs en poo
    public $firstName;
    public $lastName;
    public $old;
    // les constructeurs sont appelés a chque fois qu'on instantie l'object
    public function __construct($firstName, $lastName, $old){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->old = $old;
    }
    function presentation(){
        var_dump("Hello my name is $this->firstName - $this->lastName and i'am $this->old yes old");
    }
    

}
// instatiation de l'objet employe
$employe1 = new Employe("Said", "Soumah", 28);
$employe1->presentation();

# Les setteurs et les getteurs
## D'abord on transforme l'attribut olld en private pour ne pas quil soit accessible hors class
1. private $old; 
## ensuites les setteurs avec verifications et getteurs pour renvoyer la valeur 
2. public function setAge($old){
        // si l'age n'est pas un entier ou est negatif on renvoie une erreur
        if(is_int($old) && $old >= 1 && $old <= 120){
            $this->old = $old;
        }else{
            throw new Exception("L'age doit etre un entier ou non négatif");
        }
    }
    // les getteurs renvoies la valeurs non accessibles hors de la class
    public function getAge(){
        return $this->old;
}
## Pour finir la configurationde old  au niveau du constructor on ajoute l'attribut en questions
3. $this->setAge($old);
# l'heritage en poo
class Patron extends Employe{
    public $voiture;
    // les constructeurs
    public function __construct($firstName, $lastName, $old, $voiture){
        //on herite du constructeur de employe
        parent::__construct($firstName, $lastName, $old);
        $this->voiture = $voiture;
    }
    //function rouler qui appartient au patron
    public function rouler(){
        var_dump("Bonjour je suis le patron, j'ai une voiture $this->voiture et je roule avec !");
    }
    //redefinition de methode
    function presentation(){
        var_dump("Bonjour de la part du patron my name is $this->firstName - $this->lastName and i'am $this->old yes old");
        // var_dump("Bonjour de la part du patron my name is $this->firstName - $this->lastName and i'am {$this->getAge()} yes old");
    }
}
$patron  = new Patron("Mr", "Soumah", 28, "Mercedez");

$patron->rouler();
$patron->presentation();

## mais dans la methode presentation comme old a une propriete privée du coup on modifi sa propriete en protected

# les interface ne peuvent pas etre instancié les et contient uniquem les methodes implements et à la difference des classes abstract contient en plus des methodes abstract mais aussi des methodes non abstract en plus les classes qui herite d'interface et de classe abstract doivent obligatoire avoir les meme method
<?php 
interface Travailler{
    public function travailleur();
}
class Employe implements Travailler{
    // les variables en procedural sont appeler attributs en poo
    public $firstName;
    public $lastName;
    protected $old;
    // les constructeurs sont appelés a chque fois qu'on instantie l'object
    public function __construct($firstName, $lastName, $old){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->setAge($old);
    }
    function presentation(){
        var_dump("Hello my name is $this->firstName - $this->lastName and i'am $this->old yes old");
    }
    // les setteurs permetttent de faire des verifications sur les valeurs renvoyées
    public function setAge($old){
        // si l'age n'est pas un entier ou est negatif on renvoie une erreur
        if(is_int($old) && $old >= 1 && $old <= 120){
            $this->old = $old;
        }else{
            throw new Exception("L'age doit etre un entier ou non négatif");
        }
    }
    // les getteurs renvoies la valeurs non accessibles hors de la class
    public function getAge(){
        return $this->old;
    }
    public function travailleur(){
        return "Je suis un employer et je travaille";
    }
    

}

class Patron extends Employe{
    public $voiture;
    // les constructeurs
    public function __construct($firstName, $lastName, $old, $voiture){
        //on herite du constructeur de employe
        parent::__construct($firstName, $lastName, $old);
        $this->voiture = $voiture;
    }
    //function rouler qui appartient au patron
    public function rouler(){
        var_dump("Bonjour je suis le patron, j'ai une voiture $this->voiture et je roule avec !");
    }
    function presentation(){
        var_dump("Bonjour de la part du patron my name is $this->firstName - $this->lastName and i'am $this->old yes old");
        // var_dump("Bonjour de la part du patron my name is $this->firstName - $this->lastName and i'am {$this->getAge()} yes old");
    }
    public function travailleur(){
        return "Je suis un patron et je travaille";
    }
    
}

class Etudiant implements Travailler{
    public function travailleur(){
        return "Je suis un étudiant et je revise";
    }
}

// instatiation de l'objet employe
$employe1 = new Employe("Said", "Soumah", 28);

$employe1->presentation();
echo "<br/>".$employe1->getAge()." <br/>";

$employe1->setAge(55);

$patron  = new Patron("Mr", "Soumah", 28, "Mercedez");

$patron->rouler();
$patron->presentation();

$etudiant = new Etudiant();
faireTravailler($employe1);
faireTravailler($patron);
faireTravailler($etudiant);
function faireTravailler(Travailler $object){
    var_dump("Travail encours: {$object->travailleur()}");
}


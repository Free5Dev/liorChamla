# Cours d'introduction au POO de Lior ChamLa

<?php 
    interface Travailler{
## methode interface sans corps
        public function travail();
    }
    class Etudiant implements Travailler{
## redefinition  de la methode travail 
        public function travail(){
            var_dump("Je ne suis pas un employé mais je travail");
        }
    }
    function faireTravailler(Travailler $object){
        var_dump("Faire Travailler: {$object->travail()}");
    }
## instantiation de la class etudiant
    $etudiant = new Etudiant();
## appel de la function faireTravailler
    faireTravailler($etudiant);
?>
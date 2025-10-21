<?php

require 'functions.php';

require 'router.php';

//conectamos nuestra MySQL database

class Person {
    public $name;
    public $age;

    public function respirar() //la visibilidad predeterminada es public pero mejor ponerlo siempre
    {
        echo $this->name . ' esta respirando';
    }
}

$person = new Person();

$person->name = "Alexandra"; //Al hacer referencia a una propiedad no uso el $
$person->age = 31;

dd($person->respirar());
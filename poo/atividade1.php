<?php
class Student{
    private $name;
    private $age;
    private $grade;

    public function __construct($name, $age, $grade) {
        $this->name= $name;
        $this->age = $age;
        $this->grade = $grade;
    }

    public function displayInfo(){
        echo "Nome:" . $this->name . "<br>";
         echo "Idade:" . $this->age . "<br>";
        echo "Serie:" . $this->grade . "<br>";
    }

}

$s = new Student("Andrea",16 , "3B");
$s->displayInfo(); 
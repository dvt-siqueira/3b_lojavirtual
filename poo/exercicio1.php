
<?php

class Student {
    // Atributos privados (Encapsulamento)
    private $name;
    private $age;
    private $grade;

    // Método Construtor para inicializar as propriedades
    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }


    // Método para exibir as informações do estudante
    public function displayInfo() {
        echo "Nome: " . $this->name . "<br>";
        echo "Idade: " . $this->age . "<br>";
        echo "Nota/Série: " . $this->grade . "<br>";
    }
}

// Instanciação (Criação do objeto) e teste da classe
$student = new Student("Andrea", 16, 10);
$student->displayInfo();

?>
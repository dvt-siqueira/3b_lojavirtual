<?php

// Superclasse (Classe Pai)
class Animal {
    protected $nome; // Atributo protegido: acessível apenas na classe pai e filhas 

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function falar() {
        echo "O animal faz um som.\n";
    }
}

// Subclasse (Classe Filha) que herda de Animal
class Cachorro extends Animal {
    // Herdará automaticamente a propriedade $nome e o método falar() 
    
    // Sobrescrita do método falar() para dar um comportamento específico 
    public function falar() {
        echo "O cachorro {$this->nome} late: Au Au!\n";
    }
   
}
 class Gato  extends Animal {
    // Herdará automaticamente a propriedade $nome e o método falar() 
    
    // Sobrescrita do método falar() para dar um comportamento específico 
    public function falar() {
        echo "O Gato {$this->nome} Mia: MiAu MiAu!\n";
    }
 }

// Instanciação e Utilização
$cachorro = new Cachorro("Rex");
$gato = new Gato("Felpudo");
$gato->falar(); // Saída: O cachorro Rex late: Au Au!
$cachorro->falar(); 
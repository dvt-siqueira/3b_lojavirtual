<?php
class Animal{
    protected $nome;
    public function __construct($nome)
    {
        $this->nome = $nome;
    }
    public function falar(){
        echo "O Animal faz um som.\n";
    }
    }
    class Cachorro extends Animal{
        public function falar(){
            echo "O Cachorro {$this->nome} late: Au Au!\n";
        }
    }
    class Gato extends Animal{
        public function falar(){
            echo "O gato {$this->nome} Mia: MiAu MiAu!\n";
        }
    }

    $cachorro =  new Cachorro("Rex");
    $cachorro->falar();
    $gato=new Gato("Bolinha");
    $gato->falar();
?>
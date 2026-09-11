<?php
class Animal{
    protected $nome;

    public function __construct($nome)
    {
        $this->nome = $nome;
    }
public function falar(){
    echo "o animal faz o som. \n";
}
}

class Cachorro extends Animal{
    public function falar(){
        echo " O cachorro {$this->nome} late: Au Au!\n";
    }
}

class Gato extends Animal{
    public function falar(){
        echo " O gato {$this->nome} mia: MiAu MiaAu!\n";
    }
}
$dog = new Cachorro("Rex");
$dog->falar();

$cat = new Gato("Felpudo");
$cat->falar();

?>
<?php
class veiculo{
private $marca;
private $modelo;
private $ano;

public function __construct($marca,$modelo, $ano){
$this->marca=$marca;
$this->modelo=$modelo;
$this->ano=$ano;
}
public function displayDetails(){
    echo "Marca:" . $this->marca . "<br>";
    echo "Modelo:" . $this->modelo . "<br>";
    echo "Ano:" . $this->ano . "<br>";
}

//exercicio 8
public function setAno($ano){
    if (is_numeric($ano)&& strlen((string)$ano) == 4){
        $this->ano=$ano;
    }
}


}
$v = new Veiculo("corsa","Chevrolet","2000");
$v->setAno(2010);
$v->displayDetails();

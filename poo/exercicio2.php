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

}
$v = new Veiculo("corsa","Chevrolet","2000");
$v->displayDetails();

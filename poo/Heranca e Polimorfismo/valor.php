<?php
class Configura{
    private $valor = 'Valor da SuperClasse';

    protected function ver(){
        return "Classe mae:". $this->valor . "\n";
    }
}

class Mostra extends Configura{
    protected $valor = ' Valor da subclasse';

    protected function ver(){
        return "Classe Filha:" . $this->valor . "\n";
    }
    public function testarEscopo(){
        echo self::ver();
        echo parent::ver();
    }
}
$objeto = new Mostra();
$objeto->testarEscopo();


?>
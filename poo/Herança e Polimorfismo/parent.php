<?php
class Configura{
    private $valor = 'VAlor da classe pai';

    protected function ver(){
        return "<br>SuperClasse: ". $this->valor;
    }
}
class Mostra extends Configura{
    protected $valor = 'Valor da Classe Filha';

    protected function ver(){
         return "<br>SubClasse: ". $this->valor;
    }
    public function testarEscopos(){
        echo self::ver();
        echo parent::ver();
    }
}
$objeto = new Mostra();
$objeto->testarEscopos();


?>
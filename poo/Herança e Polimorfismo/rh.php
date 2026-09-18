<?php
class Funcionario{
    protected $nome;
    public function __construct($nome){
        $this->nome=$nome;
    }
    public function trabalhar(){
        echo "{$this->nome} esta executando tarefas basicas";
    }
}
    class Gerente extends Funcionario{
        public function trabalhar(){
            echo "{$this->nome} esta gerenciando um Projeto ";
        }
    }
$gerente = new Gerente("Kevin");
$gerente->trabalhar();
$operador = new Funcionario("Jao");
$operador->trabalhar();
?>
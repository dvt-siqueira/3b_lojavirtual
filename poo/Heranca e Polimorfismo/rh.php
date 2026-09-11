<?php
class Funcionario{
    protected $nome;
    public function __construct($nome){
        $this->nome = $nome;
    }
    public function trabalhar(){
        echo "{$this->nome} está executando tarefas basicas.\n";
    }
}
class Gerente extends Funcionario{
    public function trabalhar()
    {
        echo"{$this->nome} está gerenciando projetos. \n";
    }
}
class Desenvolvedor extends Funcionario{
    public function trabalhar()
    {
        echo"{$this->nome} está programando em PHP. \n";
    }
}
function iniciarExpediente(Funcionario $funcionario){
    $funcionario->trabalhar();
}

$dev = new Desenvolvedor("Luan");
iniciarExpediente($dev);


$equipe = [
    new Gerente("Ana"),
    new Desenvolvedor("Maetus"),
    new Funcionario("Rodrigo")
];

foreach ($equipe as $membro){
    iniciarExpediente($membro);
}

?>
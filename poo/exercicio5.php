<?php
class Pessoa{
    private $nome;
    private $idade;

public function __construct($nome, $idade)
{
    $this->nome=$nome;
    $this->idade=$idade;
}
public function __toString()
{
    return "Nome" . $this->nome ."<br>" . "Idade" . $this->idade;
}

}
$p = new Pessoa("Davi", 16);
echo $p;
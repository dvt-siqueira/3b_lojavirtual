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

//exercicio 9
public function getIdade(){
    return $this->idade;
}
public function compararIdade (Pessoa $outraPessoa){
 if ($this->idade > $outraPessoa->getIdade()) {
        return $this->nome . " é mais velho que " . $outraPessoa->nome;
    } elseif ($this->idade < $outraPessoa->getIdade()) {
        return $this->nome . " é mais novo que " . $outraPessoa->nome;
    } else {
        return $this->nome . " e " . $outraPessoa->nome . " possuem a mesma idade";
    }
}





}
$p = new Pessoa("Davi", 16);
$p2 = new Pessoa("Joao", 17);
echo $p;
echo $p2->compararIdade($p);
<?php
class Preco
{
    private $valor;
    public function setValor($valor)
    {
        if ($valor < 0) {
            throw new Exception("Valor não pode ser negativo");
        } else {
            $this->valor = $valor;
        }
    }
    public function getValor()
    {
        return $this->valor;
    }
}

$p = new Preco();
$p->setValor(10);
echo "O preço do produto é: R$ " . $p->getValor();

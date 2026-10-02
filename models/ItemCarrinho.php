<?php
require_once __DIR__ . '/produtos.php';

class ItemCarrinho{
    private Produto $produto;
    private int $quantidade;
    public function __construct(Produto $produto, int $quantidade=1){
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }
    public function getProduto(): Produto  { return $this->produto;}
    public function getQuantidade(): int { return $this->quantidade;}
    public function SetQuantidade(int $quantidade): void{$this->quantidade = $quantidade;}

    public function getSubtotal(): float{
        return $this->produto->getPreco()*$this->quantidade;
    }
}

?>
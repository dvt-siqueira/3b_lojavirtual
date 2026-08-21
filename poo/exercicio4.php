<?php
class carrinho{
private $itens;
private $total;
public function __construct()
{
$this->itens=[];
$this->total;

}
public function addItem($item,$preco){
    $this->itens[$item]=$preco;
    $this->total +=$preco;
}
public function getTotal(){
   // if (count($this->itens)>3){
     //   return $this->total-$this->total*0.1;
   // }
    return $this->total;
}
public function getItem(){
    return $this->itens;
}

}

$cart = new carrinho();

$cart->addItem("Product 1", 20);
$cart->addItem("Product 2", 30);
$cart->addItem("Product 3", 10);
$cart->addItem("Product 4", 40);

$total = $cart->getTotal();
echo "Total cost: $" . $total;

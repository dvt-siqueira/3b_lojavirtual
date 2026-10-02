<?php
require_once 'models/produtos.php';
echo"<h2> TEste de Classe Produto</h2>";
$p1 = new Produto("Teclado",250.00,12,"RGB Switch Blue","teclado.jpg",1);

echo "Pooduto: " . $p1->getNome() . "<br>";
echo "Preço: " . $p1->getPreco() . "<br>";

$pBD = Produto::buscarPorId(18);
var_dump($pBD);

?>
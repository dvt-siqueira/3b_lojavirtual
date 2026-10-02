<?php
require_once 'models/Produtos.php';
require_once 'models/ItemCarrinho.php';
require_once 'models/Carrinho.php';

echo "<h2>🧪 Teste da Coleção Carrinho</h2>";

$p1 = new Produto("Teclado Mecânico", 200.00,1, "", "", 15);

$p2 = new Produto("Monitor 144Hz", 1200.00,1, "", "", 2);

$carrinho = new Carrinho();
$carrinho->adicionar(new ItemCarrinho($p1, 1));

$carrinho->adicionar(new ItemCarrinho($p2, 5));

// Adicionando o mesmo produto para testar a soma de quantidades
$carrinho->adicionar(new ItemCarrinho($p1, 10)); 

echo "<pre>";
print_r($carrinho->getItens());
echo "</pre>";

echo "Total de Itens: " . $carrinho->getQuantidadeTotal() . "<br>";
echo "<strong>Valor Total: R$ " . number_format($carrinho->calcularTotal(), 2, ',', '.') . "</strong>";

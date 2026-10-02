<?php
require_once 'models/Produtos.php';
require_once 'models/ItemCarrinho.php';

echo "<h2>🧪 Teste do ItemCarrinho</h2>";
$p1 = new Produto("Mouse",150.00,12,"16000 DPI","mouse.jpg,2");
$item = new ItemCarrinho($p1,3);
echo "Produto: " . $item->getProduto()->getNome() . "<br>";
echo "Quantidade: " . $item->getQuantidade() . "<br>";
echo "Preço Unitário: R$ " . number_format($item->getProduto()->getPreco(), 2, ',', '.') . "<br>";
echo "<strong>Subtotal: R$ " . number_format($item->getSubtotal(), 2, ',', '.') . "</strong>";
?>
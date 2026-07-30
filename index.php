<?php
require_once __DIR__ . '/admin/produtos/functions.php';
$produtos = buscarProdutos($pdo,$_GET['busca'] ?? '');
exibirCabecalho("PI3 Store - Home");
exibirNavbar();
?>

<main class="container">
    <div class="vitrine">
        <?php foreach ($produtos as $p) exibirCardProduto($p); ?>
            
        
</div>
</main>

<?php
exibirRodape();
?>
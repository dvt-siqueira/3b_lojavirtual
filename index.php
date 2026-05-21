<?php
require_once __DIR__ . '/admin/produtos/functions.php';
$produtos = buscarProdutos($pdo, $_GET['busca'] ?? '');

exibirCabecalho('Home || PI3 3B Store');

?>
<main class="container">
    <div class="vitrine">
       <?php // foreach ($produtos as $p);?>
    </div>
</div>
</main>
<?php exibirRodape();?>
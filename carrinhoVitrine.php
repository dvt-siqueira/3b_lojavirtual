<?php
require_once __DIR__ . '/models/produtos.php';
require_once __DIR__ . '/models/ItemCarrinho.php';
require_once __DIR__ . '/models/Carrinho.php';
require_once __DIR__ . '/controllers/CarrinhoController.php';

$controller = new CarrinhoController();

$acao=$_GET['acao']??'';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    if ($acao==='adicionar'){
        $produtoID = (int)($_POST['produto_id']??0);
        if($produtoID>0){
            $controller->adicionar($produtoID,1);
        }
    }elseif ($acao==='atualizar'){
        $produtoID = (int)($_POST['produto_id'] ?? 0);
        $quantidade = (int)($_POST['quantidade'] ?? 1);
        if ($produtoID >0 ){
            $controller->atualizar($produtoID, $quantidade);
        }
    }

}elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($acao === 'remover' && isset($_GET['id'])) {
        $controller->remover((int)$_GET['id']);
    } elseif ($acao === 'limpar') {
        $controller->limpar();
    }
}

$dados = $controller->obterDadosView();

require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Carrinho de Compras");
exibirNavbar();
?>

<main class="container page-cart">
    <h2 class="cart-title">Seu Carrinho de Compras</h2>

    <?php if (empty($dados['itens'])): ?>
        <div class="cart-empty">
            <i class="fa-solid fa-cart-shopping cart-empty-icon"></i>
            <p>Seu carrinho está vazio!</p>
            <a href="index.php" class="btn-primary">Voltar às compras</a>
        </div>
    <?php else: ?>
        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Foto</th>
                        <th>Preço Unitário</th>
                         
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['itens'] as $item): ?>
                        <tr>
                            <td class="product-cell">
                                <span class="product-name"><?= htmlspecialchars($item->getProduto()->getNome()) ?></span>
                            </td>
                            <td class="product-imagem">
                                <div class="product-image">
                                    <?php

                                    $caminho_imagem = 'assets/img/produtos/' . $item->getProduto()->getImagem();
                                    $verifica = $item->getProduto()->getImagem();
                                    echo $verifica;
                                    if (!empty($verifica)):
                                    ?>
                                        <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" alt="<?php echo htmlspecialchars($item->getProduto()->getImagem()); ?>">
                                    <?php else: ?>
                                        <i class="fa-solid fa-image"></i>
                                    <?php endif; ?>
                                </div>

                            </td>
                            <td>R$ <?= number_format($item->getProduto()->getPreco(), 2, ',', '.') ?></td>
                            <td>
                                <form action="carrinhoVitrine.php?acao=atualizar" method="POST" class="qty-form">
                                    <input type="hidden" name="produto_id" value="<?= $item->getProduto()->getId() ?>">
                                    <input type="number" name="quantidade" value="<?= $item->getQuantidade() ?>" min="1" class="qty-input">
                                    <button type="submit" class="btn-refresh" title="Atualizar quantidade">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="subtotal-cell">R$ <?= number_format($item->getSubtotal(), 2, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="carrinhoVitrine.php?acao=remover&id=<?= $item->getProduto()->getId() ?>" class="btn-remove" title="Remover item">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <div class="summary-actions">
                <a href="carrinhoVitrine.php?acao=limpar" class="btn-clear">
                    <i class="fa-solid fa-broom"></i> Esvaziar Carrinho
                </a>
                <a href="index.php" class="btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Continuar Comprando
                </a>
            </div>

            <div class="summary-total">
                <span>Total da Compra:</span>
                <strong>R$ <?= number_format($dados['total'], 2, ',', '.') ?></strong>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
exibirRodape();
?>
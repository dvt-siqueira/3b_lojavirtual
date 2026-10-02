<?php
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Login");
exibirNavbar();
?>
<body>
    <h1>Seu Carrinho de Compras</h1>

    <?php if (empty($dados['itens'])): ?>
        <p>Seu carrinho está vazio! <a href="index.php">Voltar às compras</a></p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados['itens'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item->getProduto()->getNome()) ?></td>
                        <td>R$ <?= number_format($item->getProduto()->getPreco(), 2, ',', '.') ?></td>
                        <td>
                            <form action="carrinho.php?acao=atualizar" method="POST" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= $item->getProduto()->getId() ?>">
                                <input type="number" name="quantidade" value="<?= $item->getQuantidade() ?>" min="1">
                                <button type="submit">Atualizar</button>
                            </form>
                        </td>
                        <td>R$ <?= number_format($item->getSubtotal(), 2, ',', '.') ?></td>
                        <td>
                            <a href="carrinho.php?acao=remover&id=<?= $item->getProduto()->getId() ?>">Remover</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total da Compra: R$ <?= number_format($dados['total'], 2, ',', '.') ?></h3>

        <a href="carrinho.php?acao=limpar">Esvaziar Carrinho</a> | 
        <a href="index.php">Continuar Comprando</a>
    <?php endif; ?>
</div>
<?php
exibirRodape();
?>
<?php
//requerer as classes e iniciar o objeto



require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Carrinho de Compras");
exibirNavbar();
?>

<main class="container page-cart">
    <h2 class="cart-title">Seu Carrinho de Compras</h2>

    <?php if (!empty($dados['itens'])): ?>
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
		//carregar dados dos produtos

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
                
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
exibirRodape();
?>
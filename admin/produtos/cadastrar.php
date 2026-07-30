<?php
require_once 'functions.php';
exibirCabecalho("Cadastrar Novo Produto - Admin");
exibirNavbar();
?>

<main class="container">
    <div class="page-header">
        <h1>Cadastrar Produto</h1>
        <a href="listar.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="form-container">
        <form action="salvar.php" method="post">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Ex: Teclado Mecânico">
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label for="preco">Preço (R$)</label>
                    <input type="number" id="preco" name="preco" class="form-control" step="0.01" required placeholder="0,00">
                </div>
                <div>
                    <label for="quantidade">Quantidade em Estoque</label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" required placeholder="0">
                </div>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição do Produto</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Detalhes sobre o produto..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class="fa-solid fa-save"></i> Salvar Produto
            </button>
        </form>
    </div>
</main>

<?php exibirRodape(); ?>

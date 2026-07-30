<?php
require_once 'functions.php';

// Buscar os dados atuais do produto para preencher o formulário
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $p = $stmt->fetch();

        if (!$p) {
            die("Produto não encontrado!");
        }
    } catch (PDOException $e) {
        die("Erro ao carregar produto: " . $e->getMessage());
    }
} else {
    header("Location: listar.php");
    exit;
}

exibirCabecalho("Editar Produto - Admin");
exibirNavbar();
?>

<main class="container">
    <div class="page-header">
        <h1>Editar Produto</h1>
        <a href="listar.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Cancelar
        </a>
    </div>

    <div class="form-container">
        <form action="atualizar.php" method="POST">
            <!-- Campo oculto para enviar o ID -->
            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">

            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($p['nome']); ?>" required>
            </div>

            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label for="preco">Preço (R$)</label>
                    <input type="number" id="preco" name="preco" class="form-control" step="0.01" value="<?php echo $p['preco']; ?>" required>
                </div>
                <div>
                    <label for="quantidade">Quantidade em Estoque</label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" value="<?php echo $p['quantidade']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição do Produto</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?php echo htmlspecialchars($p['descricao']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-success" style="width: 100%;">
                <i class="fa-solid fa-check"></i> Salvar Alterações
            </button>
        </form>
    </div>
</main>

<?php exibirRodape(); ?>

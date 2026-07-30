<?php
require_once 'functions.php';

$busca = $_GET['busca'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';

try {
    $sql = "SELECT id, nome, preco, quantidade FROM produtos WHERE 1=1";
    $params = [];

    if (!empty($busca)) {
        $sql .= " AND nome LIKE :busca";
        $params[':busca'] = "%$busca%";
    }
    if (!empty($preco_max)) {
        $sql .= " AND preco <= :preco_max";
        $params[':preco_max'] = "$preco_max";
    }

    $sql .= " ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar produtos: " . $e->getMessage());
}

exibirCabecalho("Listar Produtos - Admin");
exibirNavbar();
?>

<main class="container">
    <div class="page-header">
        <h1>Gestão de Produtos</h1>
        <a href="cadastrar.php" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Novo Produto
        </a>
    </div>

    <section class="form-container" style="max-width: 100%; margin: 20px 0;">
        <form method="get" action="listar.php" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label for="busca">Nome do Produto</label>
                <input type="text" name="busca" id="busca" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($busca); ?>">
            </div>
            
            <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label for="preco_max">Preço Máximo</label>
                <select name="preco_max" id="preco_max" class="form-control">
                    <option value="">Todos os preços</option>
                    <option value="50" <?php echo $preco_max == '50' ? 'selected' : ''; ?>>Até R$ 50,00</option>
                    <option value="100" <?php echo $preco_max == '100' ? 'selected' : ''; ?>>Até R$ 100,00</option>
                    <option value="200" <?php echo $preco_max == '200' ? 'selected' : ''; ?>>Até R$ 200,00</option>
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <a href="listar.php" class="btn">Limpar</a>
        </form>
    </section>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td>#<?php echo $p['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($p['nome']); ?></strong></td>
                            <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $p['quantidade']; ?> un.</td>
                            <td>
                                <div class="actions" style="justify-content: center;">
                                    <a href="editar.php?id=<?php echo $p['id']; ?>" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="excluir.php?id=<?php echo $p['id']; ?>" class="delete" title="Excluir" onclick="return confirm('Deseja realmente excluir este produto?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php exibirRodape(); ?>

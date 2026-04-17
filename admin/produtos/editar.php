<?php
require_once '../../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $p = $stmt->fetch();

    if (!$p) {
        die("Produto não encontrado!");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Editar Produto</title>
        <link rel="stylesheet"  href="../../css/styles.css">
    </head>
    <body>
        <div class= "container">
            <h1>Editar Produto</h1>
            <form action="atualizar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $p['nome']; ?>" required>

                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" value="<?php echo $p['preco']; ?>" required>

                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" value="<?php echo $p['quantidade']; ?>" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4"><?php echo $p['descricao']; ?></textarea>

                <button type="submit">Atualizar Produto</button>
            </form>
    </div>
    </body>
</html>
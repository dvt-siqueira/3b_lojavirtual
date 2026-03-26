<?php
require_once '../../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST["quantidade"];
    //preparar a comando SQL para inserir o produto
    $sql = "INSERT INTO produtos (nome, descricao, preco, quantidade)
 VALUES (:nome, :descricao, :preco, :quantidade)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => $preco,
            'quantidade' => $quantidade

        ]);

        $mensagem = "Produto salvo com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao salvar o produto: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto Cadastrado </title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Produto Cadastrado</h1>
        <p><?php echo $mensagem; ?></p>
        <a href="listar.php">Voltar para a lista de produtos</a>
        <a href="cadastrar.php">Cadastrar outro produto</a>
    </div>
</body>

</html>
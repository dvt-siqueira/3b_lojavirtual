<html>
<head>
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet"  href="../../css/styles.css">
</head>
<body>
    <H1>Cadastrar Produtos</H1>
    <form action="salvar.php" method="post">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4"></textarea>

        <button type="submit">Salvar Produto</button>
        <a href="http://localhost/3b_lojavirtual/admin/produtos/listar.php" target="_blank" style="text-decoration: none; padding: 10px; border-radius: 5px;">
    Listar Produto</a>
    </form>

</body>

</html>
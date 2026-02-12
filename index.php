<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Loja Virtual</title>
</head>
<body>

    <h1>Minha Loja Virtual</h1>

    <p>
        <?php
            echo "Bem-vindo à nossa loja!";
        ?>
    </p>

    <p>
    Acesso realizado às:
    <?php echo date("H:i:s"); ?>
</p>


<form method="get">
    <input type="text" name="nome">
    <button type="submit">Entrar</button>
</form>

<?php
    if (isset($_GET["nome"])) {
        echo "Olá, " . $_GET["nome"] . "! Seja bem-vindo!";
    }
?>
<a href="admin/produtos/cadastrar.php">Cadastrar Produto</a>
</body>
</html>
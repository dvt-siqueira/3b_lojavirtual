<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styles.css">
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
        echo "Olá, " . $_GET["nome"] . "! Seja bem-vindo!<br><br>";
    }
    ?>
    <a href="admin/produtos/cadastrar.php">Cadastrar Produto</a>
    <?php
    $contador = 1;
    while ($contador <= 5) {
        echo "Contagem: " . $contador . "<br>";
        $contador++; // Incrementa o contador para evitar um loop infinito
    }
    for ($i = 1; $i <= 5; $i++) {
        echo "Iteração: " . $i . "<br>";
    }

    $frutas = array("Maçã", "Banana", "Laranja");
    echo $frutas[0]; // Imprime "Maçã"
    echo $frutas[1]; // Imprime "Banana"
    echo $frutas[2] . "<br>"; // Imprime "Laranja"

    $produto = array(
        "nome" => "Camiseta",
        "preco" => 29.99,
        "descricao" => "Camiseta de algodão confortável"
    );
    $produto["preco"] = 24.99; // Atualiza o preço do produto
    echo "Produto: " . $produto["nome"] . "<br>";
    echo "Preço: R$ " . $produto["preco"] . "<br>";

    $produtos = [
        [
            "id" => 1,
            "nome" => "Teclado Mecanico",
            "preco" => 199.99,
            'estoque' => 10
        ],
        [
            "id" => 2,
            "nome" => "Mouse",
            "preco" => 30.99,
            'estoque' => 5
        ]
    ];
    echo "Produto 1: " . $produtos[0]["nome"] . " - R$ " . $produtos[0]["preco"] . "<br>";
    
    ?>
</body>

</html>
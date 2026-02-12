<html>
    <head>
        <title>Produto Salvo</title>
         <link rel="stylesheet" href="../../css/styles.css">
    </head>
    <body>
        <div class="container">
        <h1 id="sucesso">Prouto salvo com Sucesso</h1>
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST"){
                $nome = $_POST["nome"];
                $preco = $_POST["preco"];
                $descricao = $_POST["descricao"];

                echo "<p><Strong>Nome:</strong>".htmlspecialchars($nome)."</p>";
                echo "<p><strong>Preço:</strong> R$ " . number_format($preco, 2, ',', '.') . "</p>";
                echo "<p><Strong>Descrição:</strong>".htmlspecialchars($descricao)."</p>";


            }
?>
        </div>
    </body>
</html>
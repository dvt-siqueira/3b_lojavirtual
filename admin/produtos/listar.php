<html>
    <head>
        <title>Listar Produtos</title>
        <link rel="stylesheet"  href="../../css/styles.css">
        <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    </head>
    <body>
        <div class=container>
        <h1>Lista de Produtos</h1>
        <?php
        $produtos=[
            ["id"=>101, "nome"=>"Smartphone", "preco"=>1299.99, "estoque"=>5],
            ["id"=>102, "nome"=>"Notebook", "preco"=>3499.99, "estoque"=>2],
            ["id"=>103, "nome"=>"Tablet", "preco"=>899.99, "estoque"=>8]
        ];
        if(!empty($produtos)){
            echo "<table>";
            echo "<thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Estoque</th></tr></thead>";
            echo "<tbody>";
            foreach($produtos as $produto){
                echo "<tr>";
                echo "<td>" . $produto["id"] . "</td>";
                echo "<td>" . $produto["nome"] . "</td>";
                echo "<td>R$ " . number_format($produto["preco"], 2, ",", ".") . "</td>";
                echo "<td>" . $produto["estoque"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </body>
</html>
<html>

<head>
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
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
        require_once '../../config.php';
        try {
            $sql = "SELECT id, nome, preco, quantidade FROM produtos order by nome asc";
            $stmt = $pdo->query($sql);
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao listar produtos: " . $e->getMessage());
        }


        if (!empty($produtos)) {
            echo "<table>";
            echo "<thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Estoque</th></tr></thead>";
            echo "<tbody>";
            foreach ($produtos as $p) {
                echo "<tr>";
                echo "<td>" . $p["id"] . "</td>";
                echo "<td>" . $p["nome"] . "</td>";
                echo "<td>R$ " . number_format($p["preco"], 2, ",", ".") . "</td>";
                echo "<td>" . $p["quantidade"] . "</td>";
                echo "<td>";
                echo "<a href='editar.php?id=" . $p["id"] . "'>
                <i class='fa-solid fa-pen-to-square' style='color: #007bff;'></i>
                </a> | ";
                echo "<a href='excluir.php?id=" . $p["id"] . "' onclick=\"return confirm('Tem certeza?')\">
                <i class='fa-solid fa-trash-can' style='color: #dc3545;'></i>
                </a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
</body>

</html>
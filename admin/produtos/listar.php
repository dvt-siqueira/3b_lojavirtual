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
    <fieldset>
        <legend>Filtro de Produtos</legend>
    <form method="GET" action="listar.php">
        <input type="text" name="busca" 
        placeholder="Digite o nome do produto"
        value="<?php echo $_GET['busca'] ?? ''; ?>">
         <select name="preco_max">
            <option value="">Preço até...</option>
            <option value="50" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '50') ? 'selected' : ''; ?>>Até R$ 50,00</option>
            <option value="100" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '100') ? 'selected' : ''; ?>>Até R$ 100,00</option>
            <option value="500" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '500') ? 'selected' : ''; ?>>Até R$ 500,00</option>
        </select>
        <button type="submit">Filtrar</button>
    </fieldset>
    <div class=container>
        <h1>Lista de Produtos</h1>
        <?php
        require_once '../../config.php';
        try {
            $busca = $_GET['busca'] ?? '';

            $sql = "SELECT id, nome, preco, quantidade
            FROM produtos where 1=1";
            $params = [];
            if (!empty($busca)) {
                $sql .= " AND nome LIKE :busca";
                $params[':busca'] = "%$busca%";
            }
            $preco_max = $_GET['preco_max'] ?? '';
            if (!empty($preco_max)) {
            $sql .= " AND preco <= :preco_max";
            $params[':preco_max'] = $preco_max;
            }

            $sql .= " ORDER BY nome ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
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
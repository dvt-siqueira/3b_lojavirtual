<html>
<head>
    <link rel="stylesheet" href="../../css/style.css">
    <Title>Produto Salvo</Title>
</head>
<body>
    <div class="container">
        <?php
        require_once "../../config.php";
        require_once "../../models/produtos.php";

        $mensagem = "";
        $p = new Produto();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recebe os dados do formulário
            $nome       = $_POST["nome"] ?? '';
            $preco      = $_POST["preco"] ?? 0;
            $descricao  = $_POST["descricao"] ?? '';
            $quantidade = $_POST["quantidade"] ?? 0;

            // 1. Tenta realizar o upload da imagem
            if (isset($_FILES['foto']) && $p->fazerUpload($_FILES['foto'])) {
                $foto = $p->getImagem(); // Nome gerado pelo método fazerUpload()

                // 2. Prepara a query SQL com os Named Parameters
                $sql = "INSERT INTO produtos (nome, preco, descricao, quantidade, foto)
                        VALUES (:nome, :preco, :descricao, :quantidade, :foto)";
                
                $stmt = $pdo->prepare($sql);

                // 3. Executa a gravação no Banco de Dados
                try {
                    $stmt->execute([
                        ':nome'       => $nome,
                        ':preco'      => $preco,
                        ':descricao'  => $descricao,
                        ':quantidade' => $quantidade,
                        ':foto'       => $foto
                    ]);
                    $mensagem = "Produto '$nome' e foto salvos com sucesso!";
                } catch (PDOException $e) {
                    $mensagem = "Erro ao salvar no banco de dados: " . $e->getMessage();
                }
            } else {
                $mensagem = "Erro ao processar o upload da imagem. Verifique a extensão do arquivo.";
            }
        } else {
            $mensagem = "Requisição inválida.";
        }
        ?>

        <h1><?php echo $mensagem; ?></h1>
         <?php header("Location: listar.php?{$mensagem};"); ?>
    </div>
</body>
</html>
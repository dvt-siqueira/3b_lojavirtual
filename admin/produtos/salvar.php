<html>
<head>
    <link rel="stylesheet" href="../../css/style.css">
    <Title>Produto Salvo</Title>
</head>
<body>
    <div class="container">
        <h1 id="sucesso">Produto Salvo com Sucesso!</h1>
        <?php
        require_once "../../config.php";
        require_once "../../models/Produtos.php";
         $mensagem = "";
        $p = new Produto();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //recebe os dados do formulário
            $nome = $_POST["nome"];
            $preco = $_POST["preco"];
            $descricao = $_POST["descricao"];
            $quantidade= $_POST["quantidade"];

            if (isset($_FILES['foto']) && $p->fazerUpload($_FILES['foto'])) {
                $foto = $p->foto; // Nome gerado pelo método fazerUpload()

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
    </div>
</body>
</html>
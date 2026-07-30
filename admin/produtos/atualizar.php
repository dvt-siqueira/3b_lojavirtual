<?php
require_once '../../config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];

            try {
                // Preparar o comando SQL UPDATE
                $sql = "UPDATE produtos SET
                        nome = :nome,
                        preco = :preco,
                        quantidade = :quantidade,
                        descricao = :descricao
                        WHERE id = :id";

                $stmt = $pdo->prepare($sql);

                // Vincular os parâmetros (Bind) para evitar SQL Injection
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':preco', $preco);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Redirecionar com mensagem de sucesso
                    header("Location: listar.php?msg= Atualizado com Sucesso");
                    exit;
                }   else {
                    echo "Erro ao tentar atualizar o produto.";
                }

            } catch (PDOException $e) {
                die("Erro no banco de dados: " . $e->getMessage());
            }
        } else {
            header("Location: listar.php");
    }
?>
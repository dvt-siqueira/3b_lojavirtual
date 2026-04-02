<?php
require_once '../../config.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        header("Location: listar.php");
        exit();
    } catch (PDOException $e) {
        die("Erro ao excluir produto: " . $e->getMessage());
    }
} else {
    die("ID do produto não fornecido.");
}
?>
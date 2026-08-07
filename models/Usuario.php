<?php
require_once __DIR__ . '/../config.php';
class Usuario
{
    public $id;
    public $nome;
    public $email;
    public $senha;
    public function cadastrar($nome, $email, $senha)
    {
        global $pdo;
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios(nome,email,senha) VALUES (:n,:e,:s)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':n' => $nome, ':e' => $email, ':s' => $hash]);
    }
}

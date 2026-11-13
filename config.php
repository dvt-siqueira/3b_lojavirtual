<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = '3b_lojavirtual';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    //cria a conexao com o banco de dados usando PDO
    $pdo = new PDO($dsn, $username, $password, $options);
    // Configura o PHP para o fuso do Brasil
    date_default_timezone_set('America/Sao_Paulo');

    // FORÇA O MYSQL A USAR O FUSO DE BRASÍLIA (UTC-3)
    $pdo->exec("SET time_zone = '-03:00';");
} catch (PDOException $e) {
    //trata erros de conexão
    die("Erro de conexão: " . $e->getMessage());
}

<?php
require_once __DIR__ . '/../models/Endereco.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$acao = $_GET['acao'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'cadastrar') {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../login.php");
        exit();
    }

    $usuarioID = (int)$_SESSION['usuario_id'];
    $cep = $_POST['cep'] ?? '';
    $lagradouro = $_POST['lagradouro'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? null;
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $uf = $_POST['uf'] ?? '';

    $endereco = new Endereco(
        $usuarioID,
        $cep,
        $lagradouro,
        $numero,
        $complemento,
        $bairro,
        $cidade,
        $uf
    );
    if ($endereco->cadastrar()) {
        header("Location: ../cadastro_endereco.php?sucesso=1");
    } else {
        header("Location: ../cadastro_endereco.php?erro=Falha+ao+salvar");
    }
    exit();
}

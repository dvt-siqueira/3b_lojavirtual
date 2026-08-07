<?php
require_once __DIR__ . '/../models/Usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    if($u->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        header('Location: ../cadastro_usuario.php?success=1');
    } else {
        header('Location: ../cadastro_usuario.php?error=1');
    }
}
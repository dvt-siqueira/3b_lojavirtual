<?php
require_once __DIR__ . '/../models/Usuario.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = new Usuario();
    if($u->login($_POST['email'], $_POST['senha'])) {
        header("Location: ../index.php?sucesso=1");
        exit();
    } else {
        header("Location: ../login.php?erro=1");
        exit();
    }
}
    ?>
<?php
session_start();

// Remove apenas os dados do usuário
unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_nome']);

// Mantém o carrinho na sessão
header("Location: index.php?logout=1");
exit();
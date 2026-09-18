<?php
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Cadastro de Usuário");
exibirNavbar();
?>
<div class="container mt-4">
    <h2>Criar Conta</h2>
    <form class=" frm-usuario" method="POST" action="controllers/processar_cadastro.php">
    <input type="text" name="nome" placeholder="Nome" required class="form-control mb-2">
    <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
    <input type="password" name="senha" placeholder="Senha" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
<?php
exibirRodape();
?>
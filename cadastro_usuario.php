<?php
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 - Store - Cadastro de Usuário");
exibirNavBar();
?>
<div class="container mt-4">
<h2>Cadastro de Usuário</h2>
<form action="controllers/processar_cadastro.php"
method="POST" class="frm-usuario">
<input type="text" name="nome" placeholder="Nome"
required class="form-control mb-2">
<input type="email" name="email" placeholder="E-mail"
required class="form-control mb-2">
<input type="password" name="senha" placeholder="Senha"
required class="form-control mb-2">
<button type="submit" class="btn btn-primary">Cadastrar</button>
</form>
<?php
exibirRodape();
?>
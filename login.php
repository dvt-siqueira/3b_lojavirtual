<?php
require_once __DIR__ . '/admin/produtos/functions.php';
exibirCabecalho("PI3 Store - Login");
exibirNavbar();
?>
<div class="container mt-4">
    <h2>Login</h2>
    <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['erro']); ?>
        </div>
    <?php endif; ?>
    <form class=" frm-usuario" method="POST" action="controllers/processar_login.php">
    <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
    <input type="password" name="senha" placeholder="Senha" required class="form-control mb-2">
    
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="cadastro_usuario.php" class="btn btn-secondary">Criar Conta</a>

</form>
</div>
<?php
exibirRodape();
?>
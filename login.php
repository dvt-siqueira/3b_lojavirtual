<?php
require_once __DIR__ . '/admin/produtos/functions.php';

exibirCabecalho("PI3 Store- Login"); 
exibirNavbar();
?>
<div class="container mt-4">
    <h2>Login</h2>
    <?php if(isset($_GET['erro'])) echo "<p style='color:red'>Dados inválidos!</p>"; ?>
    
    <form action="controllers/processar_login.php" method="POST" class="frm-usuario">
        <input type="email" name="email" placeholder="E-mail" class="form-control mb-2" required>
        <input type="password" name="senha" placeholder="Senha" class="form-control mb-2" required>
        <button type="submit" class="btn btn-success">Entrar</button>
    </form>
</div>
<?php 
exibirRodape();
?>
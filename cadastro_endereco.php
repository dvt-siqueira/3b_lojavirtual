<?php
require_once __DIR__ . '/admin/produtos/functions.php';
require_once __DIR__ . '/services/ViaCEPService.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?erro=Faça+login+para+cadastrar+um+endereço");
    exit();
}

// Inicializamos as variáveis de formulário
$cep         = $_GET['cep_busca'] ?? '';
$logradouro  = '';
$bairro      = '';
$cidade      = '';
$uf          = '';
$erroCep     = '';


if (!empty($cep)) {
    $dadosEndereco = ViaCEPService::buscarEnderecoPorCep($cep);
    
    if ($dadosEndereco) {
        $logradouro = $dadosEndereco['logradouro'];
        $bairro     = $dadosEndereco['bairro'];
        $cidade     = $dadosEndereco['localidade'];
        $uf         = $dadosEndereco['uf'];
    } else {
        $erroCep = "CEP não encontrado ou inválido.";
    }
}

exibirCabecalho("PI3 Store - Cadastrar Endereço");
exibirNavbar();
?>

<main class="container page-cart" style="max-width: 600px; margin-top: 30px;">
    <h2>Cadastrar Endereço de Entrega</h2>

    <!-- Etapa A: Busca do CEP (Requisição GET) -->
    <form action="cadastro_endereco.php" method="GET" style="margin-bottom: 25px; background: #f8f9fa; padding: 15px; border-radius: 5px;">
        <label for="cep_busca"><strong>Buscar CEP (Consulta via API PHP):</strong></label>
        <div style="display: flex; gap: 10px; margin-top: 5px;">
            <input type="text" id="cep_busca" name="cep_busca" value="<?= htmlspecialchars($cep) ?>" placeholder="00000000" maxlength="8" required style="flex: 1; padding: 8px;">
            <button type="submit" class="btn-primary" style="padding: 8px 15px;">Buscar CEP</button>
        </div>
        <?php if ($erroCep): ?>
            <small style="color: red; margin-top: 5px; display: block;"><?= $erroCep ?></small>
        <?php endif; ?>
    </form>

    <!-- Etapa B: Salvar Endereço Completo (Requisição POST) -->
    <form action="controllers/EnderecoController.php?acao=cadastrar" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <input type="hidden" name="cep" value="<?= htmlspecialchars($cep) ?>">

        <div>
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" value="<?= htmlspecialchars($logradouro) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 2;">
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" style="width: 100%; padding: 8px;">
            </div>
        </div>

        <div>
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="<?= htmlspecialchars($bairro) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 3;">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($cidade) ?>" required style="width: 100%; padding: 8px;">
            </div>
            <div style="flex: 1;">
                <label for="uf">UF:</label>
                <input type="text" id="uf" name="uf" value="<?= htmlspecialchars($uf) ?>" maxlength="2" required style="width: 100%; padding: 8px;">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="padding: 10px; cursor: pointer;">Salvar Endereço</button>
    </form>
</main>

<?php exibirRodape(); ?>

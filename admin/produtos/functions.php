<?php
require_once __DIR__ . '/../../config.php';

function buscarProdutos($pdo, $busca = '')
{

    $sql = "SELECT * FROM produtos WHERE 1=1";
    $params = [];

    if (!empty($busca)) {
        $sql .= " AND (nome LIKE :busca_nome OR descricao LIKE :busca_desc)";
        $params[':busca_nome'] = "%$busca%";
        $params[':busca_desc'] = "%$busca%";
    }

    $sql .= " ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function exibirCabecalho($titulo = "PI3 Store")
{
    // Detecta se estamos na pasta admin ou na raiz para ajustar o caminho do CSS
    if (str_contains($_SERVER['PHP_SELF'], '/admin/')) {
        $basePath = '../../';
    } elseif (str_contains($_SERVER['PHP_SELF'], '/models/')) {
        $basePath = '../';
    } else {
        $basePath = '';
    }
?>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
    <?php
}

function exibirRodape()
{
    ?>
        <footer class="main-footer">
            <div class="container">
                <p>&copy; <?php echo date("Y"); ?> PI3 Store - Todos os direitos reservados</p>
            </div>
        </footer>
    </body>

    </html>
<?php
}

function exibirNavbar()
{
    if (str_contains($_SERVER['PHP_SELF'], '/admin/')) {
        $basePath = '../../';
    } elseif (str_contains($_SERVER['PHP_SELF'], '/models/')) {
        $basePath = '../';
    } else {
        $basePath = '';
    } ?>
    <header class="main-header">
        <div class="container header-flex">
            <a href="<?php echo $basePath; ?>index.php" class="logo">
                <i class="fa-solid fa-cart-shopping"></i> PI3<span>Store</span>
            </a>

            <form action="<?php echo $basePath; ?>index.php" method="GET" class="nav-search">
                <input type="text" name="busca" placeholder="O que você procura?">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <nav class="main-nav">
                <ul>
                    <li><a href="<?php echo $basePath; ?>index.php">Início</a></li>
                     <li><a href="<?php echo $basePath; ?>login.php">Login</a></li>
                    <li><a href="<?php echo $basePath; ?>admin/produtos/listar.php" class="btn-admin">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
<?php
}
/**
 * Componente: Card de Produto
 */
function exibirCardProduto($p)
{
?>
    <div class="product-card">
        <div class="product-image"><i class="fa-solid fa-image"></i></div>
        <div class="product-info">
            <h3><?php echo htmlspecialchars($p['nome']); ?></h3>
            <p class="price">
                R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
            </p>
            <button class="btn-buy">Comprar</button>
        </div>
    </div>
<?php
}
?>
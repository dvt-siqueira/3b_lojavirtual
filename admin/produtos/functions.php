<?php
require_once __DIR__ . '/../../config.php';
//Buscar Produtos
function buscarProdutos($pdo, $busca = ''  )
{
    $sql = "Select * from produtos where 1=1";
    $params = [];
    if(!empty($busca)){
        $sql .= " and nome like :busca";
        $params[':busca'] = "%$busca%";
    }
    $sql .= " order by id desc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function exibirCabecalho($Titulo ='PI3 3B Store')
{
    ?>
   <!DOCTYPE html>
   <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $Titulo?></title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body>
        <?php 
}

function exibirNavbar(){
    ?>
    <header class="main-header">
        <div class="container header-flex">
            <a href="index.php" class="logo">
        <i class="fa-solid fa-cart-shopping"></i>
        PI3<span>Store</span>
        </a>
        <form action="index.php" method="GET" class="nav-search">
            <input type="text" name="busca" placeholder="Buscar produtos...">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass">
            </i></button>
        </form>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Início</a></li>
                    <li><a href="admin/produtos/listar.php"
                    class="btn-admin">
                        Admin</a></li>
            </ul>
        </nav>
        </div>
    </header>
    <?php
}

function exibirRodape()
{
 
echo '<footer><p>&copy; 2023 PI3 3B Store. Todos os direitos reservados.</p></footer>';
echo '</body></html>';
    
}
?>
# Guia de Melhorias Visuais e Estruturais - PI3 Store

Este guia contém todas as alterações necessárias para modernizar o visual da loja e corrigir problemas de caminhos (paths) entre a Home e o Painel Administrativo.

---

## 1. Atualização do CSS (`css/style.css`)
Substitua o conteúdo do arquivo `css/style.css` para incluir os novos estilos de formulários, botões e tabelas.

```css
:root {
    --primary: #2563eb;
    --dark: #0f172a;
    --success: #10b981;
    --danger: #ef4444;
    --bg: #f8fafc;
    --border: #e2e8f0;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--dark); }

.container { 
    max-width: 1100px; 
    margin: 0 auto; 
    padding: 0 20px; 
}

/* HEADER & NAVBAR */
.main-header { 
    background: white; 
    padding: 15px 0; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
    position: sticky; top: 0; z-index: 1000;
    border-bottom: 1px solid var(--border);
}
.header-flex { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
.logo { font-size: 1.5rem; font-weight: 800; color: var(--primary); text-decoration: none; }
.logo span { color: var(--dark); }

.nav-search { flex: 1; max-width: 450px; display: flex; background: var(--bg); border: 1px solid var(--border); border-radius: 50px; padding: 5px 15px; }
.nav-search input { flex: 1; border: none; background: transparent; padding: 8px; outline: none; }
.nav-search button { border: none; background: transparent; color: #64748b; cursor: pointer; }

.main-nav ul { display: flex; align-items: center; gap: 10px; list-style: none; }
.main-nav a { text-decoration: none; color: #374151; font-size: 15px; font-weight: 500; padding: 10px 16px; border-radius: 10px; transition: 0.25s; }
.main-nav a:hover { background: #f3f4f6; }
.btn-admin { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white !important; }

/* VITRINE (INDEX) */
.vitrine { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px; padding: 40px 0; }
.product-card { background: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; transition: 0.3s; display: flex; flex-direction: column; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
.product-card:hover { transform: translateY(-5px); border-color: var(--primary); }
.product-image { height: 180px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: #cbd5e1; }
.product-info { padding: 20px; flex-grow: 1; text-align: center; }
.price { font-size: 1.4rem; font-weight: 800; color: var(--success); }

/* FORMS */
.form-container { background: white; padding: 30px; border-radius: 12px; border: 1px solid var(--border); max-width: 600px; margin: 40px auto; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
.form-control { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: 8px; font-size: 1rem; }
.form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }

/* BUTTONS */
.btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: 0.2s; }
.btn-primary { background: var(--primary); color: white; }
.btn-success { background: var(--success); color: white; }
.btn-danger { background: var(--danger); color: white; }
.btn-secondary { background: #64748b; color: white; }
.btn:hover { opacity: 0.9; }

/* TABLES */
.table-container { background: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden; margin: 30px 0; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border); }
th { background: #f8fafc; color: #64748b; font-size: 0.85rem; text-transform: uppercase; }
tr:hover td { background: #f1f5f9; }

.main-footer { background: white; padding: 40px 0; color: #64748b; border-top: 1px solid var(--border); margin-top: 40px; text-align: center; }
```

---

## 2. Padronização das Funções (`admin/produtos/functions.php`)
Este arquivo é o coração do projeto. Ele agora resolve o problema de caminhos automaticamente.

```php
<?php
// USO DE __DIR__ PARA RESOLVER CAMINHOS INDEPENDENTE DE ONDE O ARQUIVO É CHAMADO
require_once __DIR__ . '/../../config.php';

function buscarProdutos($pdo, $busca = '') {
    $sql = "SELECT * FROM produtos WHERE nome LIKE :busca OR descricao LIKE :busca ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':busca' => "%$busca%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function exibirCabecalho($titulo = "PI3 Store") {
    // Detecta profundidade da pasta para ajustar o caminho do CSS
    $basePath = (str_contains($_SERVER['PHP_SELF'], '/admin/')) ? '../../' : '';
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

function exibirNavbar() {
    $basePath = (str_contains($_SERVER['PHP_SELF'], '/admin/')) ? '../../' : '';
    ?>
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
                    <li><a href="<?php echo $basePath; ?>admin/produtos/listar.php" class="btn-admin">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php
}

function exibirRodape() {
    ?>
    <footer class="main-footer">
        <p>&copy; <?php echo date("Y"); ?> PI3 Store - Todos os direitos reservados</p>
    </footer>
    </body>
    </html>
    <?php
}

function exibirCardProduto($p) {
    ?>
    <div class="product-card">
        <div class="product-image"><i class="fa-solid fa-image"></i></div>
        <div class="product-info">
            <h3><?php echo htmlspecialchars($p['nome']); ?></h3>
            <p class="price">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></p>
            <button class="btn-primary" style="width:100%; margin-top:10px;">Comprar</button>
        </div>
    </div>
    <?php
}
```

---

## 3. Lista de Produtos (`admin/produtos/listar.php`)
Atualize para usar a nova estrutura de tabela e botões.

```php
<?php
require_once 'functions.php';
$busca = $_GET['busca'] ?? '';
$produtos = buscarProdutos($pdo, $busca);

exibirCabecalho("Gestão de Produtos");
exibirNavbar();
?>

<main class="container">
    <div style="display:flex; justify-content: space-between; align-items:center; margin-top:40px;">
        <h1>Produtos</h1>
        <a href="cadastrar.php" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td>#<?php echo $p['id']; ?></td>
                    <td><?php echo $p['nome']; ?></td>
                    <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $p['quantidade']; ?> un</td>
                    <td>
                        <a href="editar.php?id=<?php echo $p['id']; ?>" style="color: var(--primary); margin-right: 10px;"><i class="fa-solid fa-edit"></i></a>
                        <a href="excluir.php?id=<?php echo $p['id']; ?>" style="color: var(--danger);" onclick="return confirm('Excluir?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php exibirRodape(); ?>
```

---

## 4. Cadastro de Produtos (`admin/produtos/cadastrar.php`)
Interface de cadastro limpa e organizada.

```php
<?php
require_once 'functions.php';
exibirCabecalho("Novo Produto");
exibirNavbar();
?>

<main class="container">
    <div class="form-container">
        <h2>Novo Produto</h2>
        <form action="salvar.php" method="POST">
            <div class="form-group">
                <label>Nome do Produto</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div class="form-group">
                    <label>Preço</label>
                    <input type="number" step="0.01" name="preco" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Quantidade</label>
                    <input type="number" name="quantidade" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="descricao" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-success" style="width:100%">Salvar Produto</button>
        </form>
    </div>
</main>

<?php exibirRodape(); ?>
```

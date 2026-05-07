# 📘 Programação para Internet III
## 📅 Aula 08 — PHP: Funções, Escopo e Refatoração Profissional

---

# 🎯 Objetivos da Aula

- **Funções vs Includes:** Entender por que funções são mais poderosas que simples `includes`.
- **Domínio de Escopo:** Como usar variáveis globais e parâmetros de forma segura.
- **Componentização:** Criar um layout profissional onde o menu e o rodapé são "componentes" dinâmicos.
- **Padrão Profissional:** Implementar um **Menu de Navegação** com busca integrada e design moderno.

---

# 🏗️ 1. Funções de Layout: O Próximo Nível

Muitos programadores usam `include 'header.php'`. Mas e se uma página precisar de um título diferente? Ou se o menu precisar mudar se o usuário estiver logado?

É aqui que as **Funções de Layout** brilham. Elas permitem transformar pedaços de HTML em "Componentes Inteligentes".

| Recurso | `include 'header.php'` | `exibirHeader($titulo)` |
| :--- | :--- | :--- |
| **Reuso** | Sim | Sim |
| **Parâmetros** | Não (difícil) | **Sim (fácil)** |
| **Lógica Interna**| Limitada | **Poderosa** |
| **Organização** | Arquivos soltos | **Biblioteca centralizada** |

---

# 🚀 Passo 1: O "Cérebro" do Sistema (`functions.php`)

Nesta aula, nosso `functions.php` será a nossa central de componentes.

```php
<?php
require_once 'config.php';

// --- LÓGICA DE DADOS ---

function buscarProdutos($pdo, $busca = '') {
    function buscarProdutos($pdo, $busca = '') {
        $sql = "SELECT * FROM produtos WHERE 1=1";
        $params = [];

        if (!empty($busca)) {
            // IMPORTANTE: No PDO, marcadores nomeados (:busca) devem ser únicos se usados mais de uma vez
            $sql .= " AND (nome LIKE :busca_nome OR descricao LIKE :busca_desc)";
            $params[':busca_nome'] = "%$busca%";
            $params[':busca_desc'] = "%$busca%";
        }

        $sql .= " ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


// --- COMPONENTES DE LAYOUT (O PADRÃO PROFISSIONAL) ---

/**
 * Componente: Cabeçalho
 * Permite mudar o título da aba dinamicamente.
 */
function exibirCabecalho($titulo = "PI3 Store") {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body>
    <?php
}

/**
 * Componente: Menu de Navegação (Navbar)
 * O padrão profissional com busca e logo.
 */
function exibirNavbar() {
    ?>
    <header class="main-header">
        <div class="container header-flex">
            <a href="index.php" class="logo">
                <i class="fa-solid fa-cart-shopping"></i> PI3<span>Store</span>
            </a>

            <form action="index.php" method="GET" class="nav-search">
                <input type="text" name="busca" placeholder="O que você procura?">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="admin/produtos/listar.php" class="btn-admin">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php
}

/**
 * Componente: Card de Produto
 */
function exibirCardProduto($p) {
    ?>
    <div class="product-card">
        <div class="product-image"><i class="fa-solid fa-box"></i></div>
        <div class="product-info">
            <h3><?php echo htmlspecialchars($p['nome']); ?></h3>
            <p class="price">R$ <?php echo number_format($p['preco'], 2, ",", "."); ?></p>
        </div>
        <button class="btn-buy">Comprar</button>
    </div>
    <?php
}

function exibirRodape() {
    echo "<footer><p>&copy; " . date("Y") . " PI3 Store</p></footer></body></html>";
}
```

---

# 🎨 Passo 2: O Visual Profissional (`styles.css`)

Substitua o conteúdo do `css/styles.css` por este código moderno. Note como usamos a classe `.container` em todas as seções para manter o alinhamento perfeito.

```css
/* --- Variáveis e Reset --- */
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

/* --- Alinhamento Padrão (O segredo da largura igual) --- */
.container { 
    max-width: 1100px; 
    margin: 0 auto; 
    padding: 0 20px; 
}

/* --- Menu Profissional (Header) --- */
.main-header { 
    background: white; 
    padding: 15px 0; 
    box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
    position: sticky; top: 0; z-index: 1000;
    border-bottom: 1px solid var(--border);
}
.header-flex { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
.logo { font-size: 1.5rem; font-weight: 800; color: var(--primary); text-decoration: none; }
.nav-search { flex: 1; max-width: 450px; display: flex; background: var(--bg); border: 1px solid var(--border); border-radius: 50px; padding: 5px 15px; }
.nav-search input { flex: 1; border: none; background: transparent; padding: 8px; outline: none; }
.nav-search button { border: none; background: transparent; color: #64748b; cursor: pointer; }

/* --- Vitrine e Moldura dos Produtos --- */
.vitrine { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); 
    gap: 25px; 
    padding: 40px 0; 
}

/* Moldura do Produto */
.product-card { 
    background: white; 
    border-radius: 12px; 
    border: 1px solid var(--border); /* A Moldura */
    overflow: hidden; 
    transition: all 0.3s ease; 
    display: flex; 
    flex-direction: column;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.product-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); 
    border-color: var(--primary); /* A moldura brilha no hover */
}

.product-image { 
    height: 180px; 
    background: #f1f5f9; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 3.5rem; 
    color: #cbd5e1; 
}

.product-info { padding: 20px; flex-grow: 1; text-align: center; }
.product-info h3 { font-size: 1.1rem; margin-bottom: 10px; color: var(--dark); }
.price { font-size: 1.4rem; font-weight: 800; color: var(--success); }

.btn-buy { 
    width: 100%; 
    border: none; 
    background: var(--dark); 
    color: white; 
    padding: 12px; 
    font-weight: bold; 
    cursor: pointer; 
    transition: 0.3s; 
}
.btn-buy:hover { background: var(--primary); }

/* --- Rodapé Alinhado --- */
.main-footer { 
    background: white; 
    padding: 40px 0; 
    color: #64748b; 
    border-top: 1px solid var(--border); 
    margin-top: 40px;
    text-align: center;
}
```

---

# 🏠 Passo 3: A Nova index.php (Lógica de Componentes)

Mostre como o arquivo fica elegante:

```php
<?php
require_once 'functions.php';
$produtos = buscarProdutos($pdo, $_GET['busca'] ?? '');

exibirCabecalho("Home | PI3 Store");
exibirNavbar();
?>

<main class="container">
    <div class="vitrine">
        <?php foreach ($produtos as $p) exibirCardProduto($p); ?>
    </div>
</main>

<?php exibirRodape(); ?>
```

---

# 🧑‍💻 Desafio: "Parâmetro Dinâmico"

Peça para os alunos alterarem a função `exibirNavbar()` para receber um parâmetro `$corFundo`. Se a cor for passada, o menu muda de cor. Isso fixará o conceito de como funções são mais flexíveis que simples arquivos PHP de inclusão.

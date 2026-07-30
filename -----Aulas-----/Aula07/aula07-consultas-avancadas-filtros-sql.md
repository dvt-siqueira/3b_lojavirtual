# 📘 Programação para Internet III
## 📅 Aula 07 — Consultas Avançadas e Filtros SQL

---

# 🎯 Objetivos da Aula

- Aprender a utilizar filtros avançados no SQL com a cláusula `WHERE`.
- Utilizar operadores lógicos (`AND`, `OR`) para combinar múltiplos critérios de busca.
- Implementar a busca textual flexível com o operador `LIKE`.
- Filtrar intervalos de valores (como faixas de preço) com `BETWEEN`.
- Organizar a exibição dos dados com `ORDER BY` e limitar resultados com `LIMIT`.
- **Desafio Especial:** Transformar a página inicial (`index.php`) em uma vitrine profissional com sistema de busca funcional.

---

# 🔍 Refinando Buscas com SQL

Até agora, nossas consultas eram simples: `SELECT * FROM produtos`. Para um sistema real, precisamos que o usuário encontre exatamente o que procura.

## 1. Operadores Lógicos: AND e OR
Permitem combinar condições. 
- **AND:** Todas as condições devem ser verdadeiras.
- **OR:** Pelo menos uma das condições deve ser verdadeira.

```sql
-- Buscar produtos com preço acima de 100 E que tenham estoque
SELECT * FROM produtos WHERE preco > 100 AND quantidade > 0;

-- Buscar produtos da categoria 'Eletrônicos' OU 'Informática'
SELECT * FROM produtos WHERE categoria = 'Eletrônicos' OR categoria = 'Informática';
```

## 2. Busca Flexível: O Operador LIKE
O `LIKE` é usado para buscar padrões em textos. O símbolo `%` funciona como um "coringa" (representa qualquer sequência de caracteres).

```sql
-- Buscar produtos que COMEÇAM com "Smartphone"
SELECT * FROM produtos WHERE nome LIKE 'Smartphone%';

-- Buscar produtos que CONTÉM "Gamer" em qualquer parte do nome
SELECT * FROM produtos WHERE nome LIKE '%Gamer%';
```

## 3. Intervalos de Valores: BETWEEN
Ideal para filtros de preço ou datas.

```sql
-- Buscar produtos com preço entre 50 e 200 reais
SELECT * FROM produtos WHERE preco BETWEEN 50 AND 200;
```

---

# 🚀 Rotina Servidora de Busca: `processar_busca.php`

Para manter nosso código organizado, vamos criar um arquivo separado que processa a lógica de busca e retorna os dados para a `index.php`.

### Exemplo de Lógica de Busca Dinâmica:
```php
<?php
require_once "config.php";

// 1. Capturar os filtros vindos da URL (GET)
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$preco_min = isset($_GET['min']) ? $_GET['min'] : 0;
$preco_max = isset($_GET['max']) ? $_GET['max'] : 999999;

// 2. Construir a query SQL com os filtros
$sql = "SELECT * FROM produtos WHERE 1=1"; // 1=1 facilita a concatenação de ANDs

if (!empty($busca)) {
    $sql .= " AND (nome LIKE :busca OR descricao LIKE :busca)";
}

$sql .= " AND preco BETWEEN :min AND :max";
$sql .= " ORDER BY preco ASC";

$stmt = $pdo->prepare($sql);

// 3. Vincular os parâmetros com segurança
if (!empty($busca)) {
    $stmt->bindValue(':busca', '%' . $busca . '%');
}
$stmt->bindValue(':min', $preco_min);
$stmt->bindValue(':max', $preco_max);

$stmt->execute();
$produtos = $stmt->fetchAll();
?>
```

---

# 🎨 Vitrine Profissional: Transformando a `index.php`

Chegou a hora de sair do visual básico e criar algo que pareça um e-commerce real. Vamos usar **CSS Grid** e **Flexbox**.

### 1. Novo Layout (Estrutura)
- **Navbar:** Menu superior com logo e links rápidos.
- **Hero Section:** Um banner de destaque para promoções.
- **Filtros:** Uma barra lateral ou superior com campos de busca e preço.
- **Product Grid:** Uma grade de "Cards" (cartões) exibindo foto, nome e preço.

### 2. Dica de CSS para Cards:
```css
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    transition: transform 0.2s;
    background: white;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
```

---

# 🧑‍💻 Desafio da Aula: O Sistema Completo

## Passo 1: O Backend (`processar_busca.php`)
Implemente a rotina de busca descrita acima. Garanta que ela utilize **Prepared Statements** para evitar ataques de SQL Injection.

## Passo 2: O Frontend (`index.php`)
Integre o arquivo de busca na sua página inicial. Substitua a listagem simples por uma grade de cartões profissionais.

## Passo 3: Filtro de Preço Dinâmico
Adicione dois campos de `input type="number"` (Mínimo e Máximo) na sua barra de busca. Ao clicar em filtrar, os resultados devem ser atualizados respeitando a faixa de preço escolhida.

---

# 📌 Próxima Aula

- **Trabalhando com Categorias:** Criar uma tabela separada para categorias e realizar o relacionamento `JOIN` no SQL.
- **Carrinho de Compras (Introdução):** Como gerenciar os itens selecionados pelo usuário utilizando `Sessions` no PHP.

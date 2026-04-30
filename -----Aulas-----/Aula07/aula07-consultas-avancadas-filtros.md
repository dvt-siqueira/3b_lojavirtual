# 📘 Programação para Internet III
## 📅 Aula 07 — Consultas Avançadas e Filtros SQL

---

# 🎯 Objetivos da Aula

- Aprender a utilizar a cláusula `WHERE` com o operador `LIKE` para buscas textuais.
- Compreender o uso de operadores lógicos (`AND`, `OR`) em consultas complexas.
- Implementar filtros dinâmicos em uma página de listagem.
- Praticar a manipulação de parâmetros via método `GET` para filtrar dados no banco.

---

# 🔍 O Operador `LIKE` e Curingas

Para buscar textos que não são exatamente iguais, mas que "contêm" uma palavra, usamos o `LIKE` com o símbolo `%` (porcentagem).

- `LIKE 'Celular%'`: Começa com "Celular".
- `LIKE '%Samsung'`: Termina com "Samsung".
- `LIKE '%iPhone%'`: Contém "iPhone" em qualquer parte.

**Exemplo SQL:**
```sql
SELECT * FROM produtos WHERE nome LIKE '%Monitor%';
```

---

# 🛠️ Implementando Filtros no `listar.php`

Vamos transformar nossa listagem simples em uma ferramenta de busca poderosa. O processo consiste em:
1.  Criar um formulário HTML com o método `GET`.
2.  Capturar os valores digitados no PHP.
3.  Montar o SQL dinamicamente conforme os filtros preenchidos.

## 1. O Formulário de Busca
Adicione este código acima da tabela no seu `listar.php`:

```html
<fieldset>
    <legend>Filtros de Busca</legend>
    <form method="GET" action="listar.php">
        <input type="text" name="busca" placeholder="Digite o nome do produto..." value="<?php echo $_GET['busca'] ?? ''; ?>">
        
        <select name="preco_max">
            <option value="">Preço até...</option>
            <option value="50" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '50') ? 'selected' : ''; ?>>Até R$ 50,00</option>
            <option value="100" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '100') ? 'selected' : ''; ?>>Até R$ 100,00</option>
            <option value="500" <?php echo (isset($_GET['preco_max']) && $_GET['preco_max'] == '500') ? 'selected' : ''; ?>>Até R$ 500,00</option>
        </select>

        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</button>
        <a href="listar.php" class="btn-limpar">Limpar Filtros</a>
    </form>
</fieldset>
```

## 2. Lógica PHP Dinâmica
Agora, vamos alterar a forma como fazemos o `SELECT`. Observe como tratamos os parâmetros para evitar erros e ataques:

```php
<?php
require_once '../../config.php';

// 1. Pegar os dados do formulário (se existirem)
$busca = $_GET['busca'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';

// 2. Base da consulta SQL
$sql = "SELECT id, nome, preco, quantidade FROM produtos WHERE 1=1";
$params = [];

// 3. Adicionar filtros dinamicamente
if (!empty($busca)) {
    $sql .= " AND nome LIKE :busca";
    $params[':busca'] = "%$busca%";
}

if (!empty($preco_max)) {
    $sql .= " AND preco <= :preco_max";
    $params[':preco_max'] = $preco_max;
}

$sql .= " ORDER BY nome ASC";

// 4. Preparar e executar
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
```

---

# 💡 Dica de Ouro: O truque do `WHERE 1=1`

Usar `WHERE 1=1` é uma técnica comum entre programadores. Como `1=1` é sempre verdadeiro, ele não altera o resultado, mas permite que todos os outros filtros sejam adicionados com `AND`, sem que precisemos verificar se é o primeiro filtro ou não. Isso deixa o código muito mais limpo!

---

# 🧑‍💻 Desafios

## Desafio 1: Filtro de Estoque
Adicione um novo filtro (pode ser um `checkbox` ou `select`) para mostrar apenas produtos que estão com o estoque zerado (`quantidade = 0`).

## Desafio 2: Ordenação Dinâmica
Permita que o usuário escolha a ordem da listagem (Menor Preço, Maior Preço ou Alfabética) através de um campo `<select>`.

---

# 📌 Próxima Aula

- **Trabalhando com Categorias:** Vamos relacionar a tabela de produtos com uma tabela de categorias (Relacionamento 1:N).
- **JOIN SQL:** Aprender a unir dados de duas tabelas em uma única consulta.

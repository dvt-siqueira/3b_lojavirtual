# 📘 Programação para Internet III
## 📅 Aula 05 — Operações CRUD: Select (Consulta) e Listagem de Produtos

---

# 🎯 Objetivos da Aula

- Compreender a operação **Read (Consulta)** do acrônimo **CRUD**.
- Aprender o comando SQL `SELECT` para buscar dados em uma tabela.
- Utilizar o **PDO** para executar consultas e recuperar resultados do banco de dados MySQL.
- Transformar nossa página `listar.php`, substituindo dados manuais (arrays fixos) por dados reais do banco.
- Exibir os dados de forma dinâmica em uma tabela HTML.

---

# 🔍 O que é o CRUD? (Recapitulação)

**CRUD** é um acrônimo para as quatro operações fundamentais de um sistema que utiliza banco de dados:

1.  **C**reate (Criar/Inserir): Comando `INSERT` (Vimos na Aula 04).
2.  **R**ead (Ler/Consultar): Comando `SELECT` (**Assunto de hoje!**).
3.  **U**pdate (Atualizar/Editar): Comando `UPDATE`.
4.  **D**elete (Excluir/Remover): Comando `DELETE`.

---

# 📑 SQL: O comando SELECT

Para buscar informações no banco de dados, utilizamos o `SELECT`.

## Sintaxe Básica:

```sql
-- Buscar todas as colunas de todos os produtos
SELECT * FROM produtos;

-- Buscar apenas nome e preço de todos os produtos
SELECT nome, preco FROM produtos;

-- Buscar produtos com preço maior que 100
SELECT * FROM produtos WHERE preco > 100;

-- Buscar produtos e ordenar pelo nome (A-Z)
SELECT * FROM produtos ORDER BY nome ASC;
```

---

# 🔌 PDO: Buscando Dados com PHP

No PHP, usamos o objeto `$pdo` (que criamos no `config.php`) para executar a consulta.

Existem duas formas principais no PDO:
1.  **`$pdo->query($sql)`**: Usado para consultas simples, sem variáveis externas.
2.  **`$pdo->prepare($sql)`**: Recomendado quando a consulta depende de dados vindos do usuário (filtros, buscas), por ser mais seguro.

### Exemplo de busca completa:

```php
// 1. Define o comando SQL
$sql = "SELECT * FROM produtos";

// 2. Executa a consulta
$stmt = $pdo->query($sql);

// 3. Recupera todos os dados como um Array
$produtos = $stmt->fetchAll();
```

---

# 🛠️ Mão na Massa: Refatorando o `listar.php`

Na Aula 03, criamos o arquivo `listar.php` com uma lista de produtos "fake" (um array fixo). Hoje, vamos conectá-lo ao banco de dados.

## 1. Ajuste no `config.php`
Antes de começar, abra o seu arquivo `config.php` na raiz do projeto. Se ele tiver um `echo "Conexão bem-sucedida!";`, remova ou comente essa linha para que ela não apareça no topo da sua lista de produtos.

## 2. Editando `admin/produtos/listar.php`
Substitua o código atual pelo seguinte:

```php
<?php
// 1. Incluir o arquivo de conexão
require_once "../../config.php";

// 2. Preparar e executar a consulta SQL
try {
    $sql = "SELECT * FROM produtos ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    
    // 3. Buscar todos os resultados e armazenar no array $produtos
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos - Admin</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn-novo { display: inline-block; padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciar Produtos</h1>
        
        <a href="cadastrar.php" class="btn-novo">+ Cadastrar Novo Produto</a>

        <?php if (count($produtos) > 0): ?>
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
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['nome']); ?></td>
                            <td>R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $p['quantidade'] ?? 'N/A'; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $p['id']; ?>">Editar</a> | 
                                <a href="excluir.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum produto encontrado no banco de dados.</p>
        <?php endif; ?>
    </div>
</body>
</html>
```

---

# 🧑‍💻 Desafios

## Desafio 1: Ordenação Personalizada
No arquivo `listar.php`, altere a consulta SQL para que os produtos sejam exibidos do **mais caro para o mais barato** (`ORDER BY preco DESC`).

## Desafio 2: Filtro de Busca (Extra)
Tente adicionar um pequeno formulário de busca no topo da página `listar.php` com um campo de texto. Quando o usuário digitar um nome e clicar em "Buscar", a tabela deve mostrar apenas os produtos que contenham aquele nome (Dica: Use `WHERE nome LIKE :busca` e `prepare()`).

## Desafio 3: Contador de Itens
Exiba, acima da tabela, a frase: *"Total de produtos cadastrados: X"*, onde X é a quantidade de itens presentes no array `$produtos`.

---

# 📌 Próxima Aula

- **Update (Edição):** Criar a página `editar.php` e aprender a atualizar registros existentes no banco de dados.
- **Delete (Exclusão):** Criar o arquivo `excluir.php` para remover produtos com segurança.
- **Integração:** Melhorar a navegação entre as páginas do sistema administrativo.

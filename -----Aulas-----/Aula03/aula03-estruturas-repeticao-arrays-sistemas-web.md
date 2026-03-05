# 📘 Programação para Internet III
## 📅 Aula 03 — Estruturas de Repetição e Arrays

---

# 🎯 Objetivos da Aula

- Entender e aplicar as principais **estruturas de repetição** (laços) em PHP: `while`, `for` e `foreach`.
- Compreender o conceito de **Arrays** em PHP (vetores e matrizes).
- Aprender a declarar, manipular e percorrer arrays.
- Aplicar estruturas de repetição e arrays para exibir listas de dados, simulando a listagem de produtos da nossa loja virtual.
- Entender a importância e aplicação dessas estruturas em sistemas web dinâmicos.

---

# 🔄 Estruturas de Repetição (Laços)

As estruturas de repetição permitem executar um bloco de código várias vezes, o que é fundamental para processar listas de dados, como produtos em um e-commerce ou registros de um banco de dados.

## `while`

O laço `while` executa um bloco de código **enquanto** uma condição for verdadeira.

```php
<?php
    $contador = 1;
    while ($contador <= 5) {
        echo "Contagem: " . $contador . "<br>";
        $contador++; // Incrementa o contador para evitar um loop infinito
    }
?>
```

## `for`

O laço `for` é ideal quando sabemos o número exato de vezes que queremos repetir um bloco de código. Ele possui três partes: inicialização, condição e incremento/decremento.

```php
<?php
    for ($i = 1; $i <= 5; $i++) {
        echo "Iteração: " . $i . "<br>";
    }
?>
```

## `foreach` (Com Arrays)

O laço `foreach` é especialmente projetado para iterar sobre elementos de arrays, tornando o código mais legível e conciso. Veremos ele em ação na seção de Arrays.

---

# 📦 Arrays em PHP

Arrays são estruturas de dados que permitem armazenar múltiplos valores em uma única variável. Em PHP, os arrays são muito flexíveis e podem conter diferentes tipos de dados.

## Tipos de Arrays

### Arrays Indexados (Numéricos)

Os elementos são acessados por um índice numérico (começando do 0).

```php
<?php
    $frutas = array("Maçã", "Banana", "Laranja");
    // ou $frutas = ["Maçã", "Banana", "Laranja"]; (sintaxe mais moderna)

    echo $frutas[0] . "<br>"; // Saída: Maçã
    echo $frutas[1] . "<br>"; // Saída: Banana

    // Adicionando um novo elemento
    $frutas[] = "Morango";
    echo $frutas[3] . "<br>"; // Saída: Morango
?>
```

### Arrays Associativos

Os elementos são acessados por chaves (strings) em vez de índices numéricos. São muito úteis para representar estruturas de dados com nomes significativos, como um registro de produto.

```php
<?php
    $produto = array(
        "nome" => "Camiseta Gamer",
        "preco" => 89.90,
        "quantidade" => 50
    );
    // ou $produto = ["nome" => "Camiseta Gamer", "preco" => 89.90, "quantidade" => 50];

    echo "Nome do Produto: " . $produto["nome"] . "<br>";
    echo "Preço: R$ " . $produto["preco"] . "<br>";

    // Alterando um valor
    $produto["preco"] = 79.90;
    echo "Novo Preço: R$ " . $produto["preco"] . "<br>";
?>
```

### Arrays Multidimensionais

Um array pode conter outros arrays, criando estruturas como matrizes. Isso é perfeito para armazenar uma lista de produtos, onde cada produto é um array associativo.

```php
<?php
    $produtos = [
        [
            "id" => 1,
            "nome" => "Teclado Mecânico",
            "preco" => 250.00,
            "estoque" => 15
        ],
        [
            "id" => 2,
            "nome" => "Mouse Gamer",
            "preco" => 120.00,
            "estoque" => 30
        ],
        [
            "id" => 3,
            "nome" => "Monitor UltraWide",
            "preco" => 1800.00,
            "estoque" => 5
        ]
    ];

    echo "Nome do primeiro produto: " . $produtos[0]["nome"] . "<br>";
    echo "Preço do segundo produto: R$ " . $produtos[1]["preco"] . "<br>";
?>
```

---

# 🌐 Aplicação em Sistemas Web com PHP (Loja Virtual)

Agora vamos juntar as estruturas de repetição com arrays para exibir dinamicamente uma lista de produtos, como faríamos na nossa loja virtual.

## Percorrendo um Array com `foreach`

O `foreach` é a forma mais comum e elegante de percorrer arrays em PHP.

```php
<?php
    $produtos = [
        ["id" => 1, "nome" => "Fone de Ouvido", "preco" => 99.90, "estoque" => 20],
        ["id" => 2, "nome" => "Webcam Full HD", "preco" => 149.90, "estoque" => 10],
        ["id" => 3, "nome" => "Microfone USB", "preco" => 180.00, "estoque" => 12]
    ];

    echo "<h2>Lista de Produtos</h2>";
    echo "<ul>";
    foreach ($produtos as $produto) {
        echo "<li>";
        echo "ID: " . $produto["id"] . " - ";
        echo "Nome: " . $produto["nome"] . " - ";
        echo "Preço: R$ " . number_format($produto["preco"], 2, ',', '.') . " - ";
        echo "Estoque: " . $produto["estoque"];
        echo "</li>";
    }
    echo "</ul>";
?>
```

## Exibindo Produtos em uma Tabela HTML

Para uma listagem mais organizada, podemos usar uma tabela HTML.

```php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Produtos</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Reutilizando nosso CSS -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Produtos Disponíveis</h1>

        <?php
            // Exemplo de array de produtos (futuramente virá do banco de dados)
            $produtos = [
                ["id" => 101, "nome" => "Smartphone X", "preco" => 1200.00, "estoque" => 50],
                ["id" => 102, "nome" => "Notebook Ultra", "preco" => 3500.00, "estoque" => 25],
                ["id" => 103, "nome" => "Smartwatch Z", "preco" => 450.00, "estoque" => 70],
                ["id" => 104, "nome" => "Fone Bluetooth", "preco" => 180.00, "estoque" => 100]
            ];

            if (!empty($produtos)) {
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Estoque</th></tr></thead>";
                echo "<tbody>";
                foreach ($produtos as $produto) {
                    echo "<tr>";
                    echo "<td>" . $produto["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($produto["nome"]) . "</td>";
                    echo "<td>R$ " . number_format($produto["preco"], 2, ',', '.') . "</td>";
                    echo "<td>" . $produto["estoque"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Nenhum produto cadastrado.</p>";
            }
        ?>
    </div>
</body>
</html>
```

> **Observação:** No exemplo acima, o array `$produtos` está "hardcoded" (definido diretamente no código). Em um sistema real, esses dados viriam de um **banco de dados**, que é o assunto da nossa próxima aula!

---

# 🧑‍💻 Desafios

## Desafio 1
Crie um array associativo chamado `$cliente` com as chaves `"nome"`, `"email"` e `"cidade"`. Preencha com seus dados e exiba cada um deles usando `echo`.

## Desafio 2
Usando o array multidimensional `$produtos` do exemplo "Percorrendo um Array com `foreach`", crie um novo laço para exibir apenas os nomes dos produtos que custam mais de R$ 150,00.

## Desafio 3
Modifique o exemplo da "Tabela HTML" para adicionar uma coluna "Ação" com um botão "Ver Detalhes" para cada produto. Por enquanto, o botão pode ser um link `<a>` sem destino (`href="#"`).

---

# 📌 Próxima Aula

- Introdução ao **MySQL** e **phpMyAdmin**.
- Criação do nosso **banco de dados** `lojavirtual` e da tabela `produtos`.
- Conexão do PHP com o MySQL usando `mysqli`.
- Inserir (INSERT) os dados do formulário de cadastro de produtos no banco de dados.
- Apresentar o conceito de CRUD (Create, Read, Update, Delete) com foco no "Create".

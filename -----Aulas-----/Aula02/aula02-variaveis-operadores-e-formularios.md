# 📘 Programação para Internet III
## 📅 Aula 02 — Variáveis, Operadores e Formulário de Cadastro

---

# 🎯 Objetivos da Aula

- Revisar e aprofundar o uso de **variáveis** em PHP.
- Entender e aplicar os principais **operadores aritméticos** e de **concatenação**.
- Introduzir as **estruturas de decisão** (`if`, `else`).
- Construir a primeira tela do nosso sistema: o **formulário de cadastro de produtos**.
- Aprender a enviar dados de um formulário para outro arquivo PHP usando o método **POST**.
- Receber e exibir os dados enviados pelo formulário.

---

# 🧠 Revisão e Aprofundamento

## Variáveis

Em PHP, variáveis começam com `$` e não precisam de um tipo definido.

```php
<?php
    $nomeProduto = "Camiseta Branca"; // String
    $preco = 59.90;                   // Float (número com casas decimais)
    $quantidade = 100;                // Integer (número inteiro)
    $disponivel = true;               // Boolean (verdadeiro/falso)
?>
```

### 💡 Desafio Rápido: Variáveis
> Crie três variáveis: `$nomeAluno` com o seu nome, `$idadeAluno` com a sua idade e `$curso` com o nome 'Programação para Internet III'. Use `echo` para imprimir uma frase como: "Meu nome é [NOME], tenho [IDADE] anos e estou no curso de [CURSO]."

---

## Operadores

- **Concatenação (`.`):** Usado para juntar strings.
- **Aritméticos:** `+` (soma), `-` (subtração), `*` (multiplicação), `/` (divisão).

```php
<?php
    $nomeCompleto = "João" . " " . "Silva";
    $total = 5 + 3 * 2; // O resultado é 11 (precedência de operadores)
?>
```

### 💡 Desafio Rápido: Operadores
> Declare duas variáveis numéricas, `$nota1 = 8;` e `$nota2 = 6;`. Calcule a média dessas duas notas e armazene em uma variável `$media`. Em seguida, exiba a frase: "A média do aluno é: [MEDIA]."

---

# 🛤️ Estruturas de Decisão (if/else)

Permitem que o código tome decisões.

```php
<?php
    $idade = 18;

    if ($idade >= 18) {
        echo "Maior de idade.";
    } else {
        echo "Menor de idade.";
    }
?>
```

## Estrutura `elseif`

O `elseif` é usado para aninhar múltiplas condições. Ele é executado se a condição do `if` inicial for falsa e a sua própria condição for verdadeira.

```php
<?php
    $media = 6.5;

    if ($media >= 7) {
        echo "Aluno Aprovado!";
    } elseif ($media >= 5) {
        echo "Aluno em Recuperação.";
    } else {
        echo "Aluno Reprovado.";
    }
?>
```

## Estrutura `switch`

O `switch` é uma alternativa ao uso de múltiplos `if/elseif/else`. Ele compara uma variável com diferentes valores (casos).

```php
<?php
    $categoria = "fruta";

    switch ($categoria) {
        case "fruta":
            echo "A categoria é fruta.";
            break;
        case "legume":
            echo "A categoria é legume.";
            break;
        case "verdura":
            echo "A categoria é verdura.";
            break;
        default:
            echo "Categoria desconhecida.";
    }
?>
```
> O `break` é essencial para parar a execução após um caso ser correspondido. Se omitido, o código continuará executando os próximos casos. O `default` é opcional e funciona como o `else`.

### 💡 Desafio Rápido: if/else
> Crie uma variável `$quantidadeEstoque` com um valor (ex: 5). Use uma estrutura `if/else` para verificar se a quantidade é maior que zero. Se for, exiba "Produto disponível em estoque.". Senão, exiba "Produto esgotado.".

---

# 🛍️ Criando o Formulário de Produtos

Vamos criar a estrutura de pastas para organizar nosso painel administrativo. Dentro da pasta `lojavirtual`, crie:

```
lojavirtual/
├── admin/
│   └── produtos/
└── index.php
```

1.  **Crie o arquivo `cadastrar.php`** dentro de `lojavirtual/admin/produtos/`.
2.  Este arquivo conterá um formulário HTML com um estilo básico.

## `lojavirtual/admin/produtos/cadastrar.php`

```php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <h1>Cadastrar Novo Produto</h1>

    <form action="salvar.php" method="post">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4"></textarea>

        <button type="submit">Salvar Produto</button>
    </form>

</body>
</html>
```

---

# 📨 Recebendo os Dados com POST

Quando o formulário é enviado, os dados vão para o arquivo `salvar.php`. A variável superglobal `$_POST` é um array associativo que contém os dados enviados.

1.  **Crie o arquivo `salvar.php`** dentro de `lojavirtual/admin/produtos/`.
2.  Este arquivo irá receber e exibir os dados.

## `lojavirtual/admin/produtos/salvar.php`

```php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produto Salvo</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    
    <div class="container">
        <h1 id="sucesso">Produto Salvo com Sucesso!</h1>

        <?php
            // Verifica se os dados foram enviados via POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Pega os valores do formulário
                $nome = $_POST["nome"];
                $preco = $_POST["preco"];
                $descricao = $_POST["descricao"];

                // Exibe os dados recebidos (por enquanto)
                echo "<p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";
                echo "<p><strong>Preço:</strong> R$ " . number_format($preco, 2, ',', '.') . "</p>";
                echo "<p><strong>Descrição:</strong> " . htmlspecialchars($descricao) . "</p>";
            } else {
                echo "<p>Erro: Nenhum dado foi enviado.</p>";
            }
        ?>

        <br>
        <a href="cadastrar.php">Voltar ao Cadastro</a>
    </div>

</body>
</html>
```

> **Funções utilizadas:**
> - `htmlspecialchars()`: Converte caracteres especiais em entidades HTML. Isso previne ataques de Cross-Site Scripting (XSS).
> - `number_format()`: Formata um número, útil para exibir preços.

---

# 🎨 Estilos Globais (`styles.css`)

Para manter o código HTML mais limpo e facilitar a manutenção visual, movemos os estilos CSS para um arquivo separado (`styles.css`). Ele será carregado por ambos os arquivos PHP.

## `lojavirtual/css/styles.css`

```css
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
    padding: 20px;
}
h1 {
    color: #0056b3;
}
form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    max-width: 500px;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
input[type="text"],
input[type="number"],
textarea {
    width: calc(100% - 16px);
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
}
button {
    background-color: #0056b3;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button:hover {
    background-color: #004494;
}
#sucesso {
    color: #28a745;
}
.container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    max-width: 500px;
}
p {
    font-size: 1.1em;
}
strong {
    color: #0056b3;
}
a {
    color: #0056b3;
    text-decoration: none;
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
}
```

---

# 🧑‍💻 Desafios

## Desafio 1
Adicione um campo "Quantidade em Estoque" (`quantidade`) no formulário e exiba o valor dele no arquivo `salvar.php`.

## Desafio 2
No arquivo `salvar.php`, use um `if` para verificar se o preço do produto é maior que R$ 100,00. Se for, exiba a mensagem "Este é um item de alto valor!".

---

# 📌 Próxima Aula

- Introdução ao **MySQL** e **phpMyAdmin**.
- Criação do nosso **banco de dados** e da tabela `produtos`.
- Conexão do PHP com o MySQL.
- Inserir (INSERT) os dados do formulário no banco de dados de verdade.

# 📘 Programação para Internet III
## 📅 Aula 04 — Introdução ao SQL e PDO (PHP Data Objects)

---

# 🎯 Objetivos da Aula

- Compreender o que é um **Banco de Dados Relacional** e o papel do **SQL**.
- Aprender os comandos básicos de SQL: `CREATE DATABASE`, `CREATE TABLE` e `INSERT`.
- Conhecer o **PDO (PHP Data Objects)** e entender por que ele é mais seguro e flexível que o `mysqli`.
- Configurar uma **conexão segura** entre o PHP e o MySQL.
- Implementar a **persistência de dados**: salvar os produtos do nosso formulário diretamente no banco de dados.

---

# 🗄️ O que é SQL?

**SQL (Structured Query Language)** é a linguagem padrão para interagir com Bancos de Dados Relacionais (como MySQL, PostgreSQL, SQL Server).

## Comandos Principais (DDL e DML)

1.  **CREATE DATABASE:** Cria o banco de dados.
2.  **CREATE TABLE:** Cria uma tabela para armazenar dados (ex: produtos, usuários).
3.  **INSERT:** Insere novos registros na tabela.
4.  **SELECT:** Consulta os dados armazenados.

---

# 🔌 PDO (PHP Data Objects)

O **PDO** é uma interface do PHP para acessar bancos de dados. 

### Por que usar PDO em vez de mysqli?
- **Portabilidade:** Funciona com diversos bancos de dados (MySQL, PostgreSQL, SQLite, etc.) sem mudar quase nada no código.
- **Segurança:** Facilita o uso de **Prepared Statements**, que protegem o sistema contra ataques de **SQL Injection**.
- **Orientação a Objetos:** Segue os padrões modernos de desenvolvimento.

---

# 🛠️ Mão na Massa - Parte 1: O Banco de Dados

Abra o **phpMyAdmin** (geralmente em `http://localhost/phpmyadmin`) e execute os seguintes comandos na aba "SQL":

```sql
-- 1. Criar o banco de dados
CREATE DATABASE 3b_lojavirtual;

-- 2. Usar o banco de dados
USE 3b_lojavirtual;

-- 3. Criar a tabela de produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    descricao TEXT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

# 🛠️ Mão na Massa - Parte 2: Conexão com PDO

Para organizar melhor, vamos criar um arquivo separado apenas para a conexão.

## 1. Crie o arquivo `config.php`
Crie este arquivo na raiz da pasta do seu projeto (`3b_lojavirtual/config.php`).

```php
<?php
// Configurações do banco de dados
$host = 'localhost';
$db   = '3b_lojavirtual';
$user = 'root';
$pass = ''; // No XAMPP a senha padrão é vazia
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Cria a conexão
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Caso ocorra erro na conexão, exibe a mensagem
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}
?>
```

---

# 🛠️ Mão na Massa - Parte 3: Salvando no Banco

Agora, vamos alterar o nosso `salvar.php` para que ele não apenas mostre os dados, mas os salve no banco de dados.

## Alterando `admin/produtos/salvar.php`

```php
<?php
// 1. Inclui o arquivo de conexão
require_once "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Recebe os dados do formulário
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $descricao = $_POST["descricao"];

    // 3. Prepara o comando SQL (usando prepared statements para segurança)
    $sql = "INSERT INTO produtos (nome, preco, descricao) VALUES (:nome, :preco, :descricao)";
    $stmt = $pdo->prepare($sql);

    // 4. Executa o comando passando os valores
    try {
        $stmt->execute([
            ':nome' => $nome,
            ':preco' => $preco,
            ':descricao' => $descricao
        ]);
        $mensagem = "Produto cadastrado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar produto: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Cadastro</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $mensagem; ?></h1>
        <p><a href="cadastrar.php">Cadastrar outro produto</a></p>
        <p><a href="listar.php">Ver lista de produtos</a></p>
    </div>
</body>
</html>
```

---

# 🧑‍💻 Desafios

## Desafio 1
No `phpMyAdmin`, insira manualmente um produto usando o comando `INSERT` na aba SQL.

## Desafio 2
Adicione o campo `quantidade` (estoque) na tabela `produtos` do banco de dados (usando o comando `ALTER TABLE` ou recriando a tabela) e atualize o código PHP para salvar esse novo campo.

## Desafio 3 (Extra)
Pesquise e explique: O que é **SQL Injection** e como o uso de `:nome` (bind parameters) no PDO ajuda a evitar esse problema?

---

# 📌 Próxima Aula

- **Read (Consulta):** Criar a página `listar.php` para buscar os produtos do banco e exibir em uma tabela.
- **Update (Edição):** Aprender a editar um produto já cadastrado.
- **Delete (Exclusão):** Remover produtos do sistema.

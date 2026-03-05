# 📘 Programação para Internet III  
## 📅 Aula 01 — Apresentação do Projeto, PHP, XAMPP e GitHub

---

# 🎯 Objetivos da Aula

- Apresentar o projeto do ano: **Sistema de Loja Virtual**
- Entender o que é PHP e para que ele serve
- Configurar e testar o **XAMPP**
- Entender a pasta **htdocs**
- Criar o primeiro projeto PHP
- Executar o projeto no navegador usando `localhost`
- Criar o repositório no **GitHub**
- Criar os primeiros testes em PHP

---

# 🛒 O Projeto do Ano

Durante o ano, vamos desenvolver:

> 🛍️ **Um sistema de vendas (Loja Virtual)**

Ele terá:

- Cadastro de produtos  
- Carrinho de compras  
- Finalização de pedido  
- Área administrativa  
- Login de usuários  
- Banco de dados  
- Organização profissional  

> 🎓 Ao final do ano, você terá um **sistema real no portfólio**.

---

# 🖥️ O que é o XAMPP?

XAMPP é um pacote que instala:

- Apache (servidor)
- PHP (linguagem)
- MySQL (banco de dados)

> ⚠️ PHP **só funciona** corretamente através de um servidor como o XAMPP.

---

# 📂 A Pasta Mais Importante: `htdocs`

Quando você instala o XAMPP, ele cria a pasta:

```
C:\xampp\htdocs
```

> 📌 **Todo projeto PHP TEM que ficar dentro dessa pasta.**

---

# 🏗️ Criando o Projeto

Dentro de:

```
C:\xampp\htdocs
```

Crie a pasta:

```
lojavirtual
```

---

# ▶️ Testando o Servidor

1. Abra o **XAMPP Control Panel**
2. Clique em **Start** no Apache
3. Acesse no navegador:

```
http://localhost
```

Se a página do XAMPP abrir → ✅ servidor funcionando.

---

# 🌐 Testando o Nosso Projeto

Acesse:

```
http://localhost/lojavirtual
```

---

# 📄 Criando o Primeiro Arquivo

Crie o arquivo:

```
index.php
```

---

# 🐘 Primeiro Teste com PHP

```php
<?php
    echo "Olá! Esse texto veio do PHP!";
?>
```

---

# 🧩 Misturando PHP com HTML

```php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Loja Virtual</title>
</head>
<body>

    <h1>Minha Loja Virtual</h1>

    <p>
        <?php
            echo "Bem-vindo à nossa loja!";
        ?>
    </p>

</body>
</html>
```

---

# 🕒 Teste Dinâmico

```php
<p>
    Acesso realizado às:
    <?php echo date("H:i:s"); ?>
</p>
```

---

# 🧍 Trabalhando com Variáveis

```php
<?php
    $nomeLoja = "Loja do 3º Ano";
    echo "Bem-vindo à " . $nomeLoja;
?>
```

---

# 📥 Entrada de Dados

```html
<form method="get">
    <input type="text" name="nome">
    <button type="submit">Entrar</button>
</form>

<?php
    if (isset($_GET["nome"])) {
        echo "Olá, " . $_GET["nome"] . "! Seja bem-vindo!";
    }
?>
```

---

# 🧑‍💻 GitHub e Versionamento

- Criar conta no GitHub
- Criar repositório `lojavirtual-php`
- No VS Code:

```
git init
git add .
git commit -m "Primeira versão do projeto"
```

---

# 🧑‍💻 Desafios

## Desafio 1
Mostrar o nome da loja usando variável.

## Desafio 2
Mostrar a hora de acesso.

## Desafio 3
Boas-vindas com nome digitado.

---

# 📌 Próxima Aula

Variáveis, operadores e estruturas de decisão  
Primeira tela de cadastro de produtos.

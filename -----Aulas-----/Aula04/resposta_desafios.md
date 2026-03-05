# 🏁 Resolução dos Desafios — Aula 04
## Introdução ao SQL e PDO

Este arquivo contém as soluções sugeridas para os desafios propostos na aula 04.

---

### **Desafio 1: Inserção Manual via SQL**
Para inserir um produto manualmente pelo **phpMyAdmin**, execute o seguinte comando na aba **SQL**:

```sql
INSERT INTO produtos (nome, preco, descricao) 
VALUES ('Mouse Gamer Óptico', 89.90, 'Mouse com 3200 DPI e luzes LED');
```

---

### **Desafio 2: Adicionando o campo "Quantidade" (Estoque)**

**Passo 1: Alterar a tabela no Banco de Dados**
No phpMyAdmin, execute:
```sql
ALTER TABLE produtos ADD COLUMN quantidade INT NOT NULL DEFAULT 0;
```

**Passo 2: Atualizar o formulário (`cadastrar.php`)**
Adicione o novo campo HTML:
```html
<label for="quantidade">Quantidade:</label>
<input type="number" id="quantidade" name="quantidade" required>
```

**Passo 3: Atualizar o processo de salvamento (`salvar.php`)**
```php
// 1. Receber o valor
$quantidade = $_POST["quantidade"];

// 2. Atualizar o SQL
$sql = "INSERT INTO produtos (nome, preco, descricao, quantidade) 
        VALUES (:nome, :preco, :descricao, :quantidade)";

// 3. Passar o parâmetro no execute
$stmt->execute([
    ':nome' => $nome, 
    ':preco' => $preco, 
    ':descricao' => $descricao,
    ':quantidade' => $quantidade
]);
```

---

### **Desafio 3: O que é SQL Injection e como o PDO protege o sistema?**

*   **O que é SQL Injection?** 
    É um ataque onde o usuário envia comandos SQL maliciosos através de campos do formulário. Se o código PHP apenas "juntar" o texto do usuário com o comando SQL (concatenação), o banco de dados pode acabar executando ordens perigosas, como apagar tabelas ou vazar dados de outros usuários.

*   **Como o PDO (Prepared Statements) protege?**
    O PDO separa o **comando SQL** dos **dados**. Quando usamos `:nome` (placeholders), o banco de dados recebe primeiro o "esqueleto" da consulta. Depois, o PDO envia os dados separadamente. O banco de dados garante que o que foi enviado pelo usuário seja tratado estritamente como **texto** e nunca como parte do comando, impedindo a execução de códigos maliciosos.

---

**Nota para o Professor:** 
Incentive os alunos a testarem nomes de produtos com aspas simples (ex: `Chave d'água`) para observarem que o PDO lida com isso automaticamente, sem erros de sintaxe ou riscos de segurança.

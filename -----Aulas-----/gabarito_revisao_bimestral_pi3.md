# Gabarito - Roteiro de Revisão (Aulas 01 a 06)
**Disciplina:** Programação para Internet III (PHP & MySQL)

Este documento contém as respostas esperadas para o roteiro de revisão. Compare com suas respostas para verificar seu nível de compreensão.

---

### **Módulo 1: Fundamentos e Formulários**

1. **Diferença de Métodos:** 
   O método `POST` é preferível para enviar dados sensíveis (senhas), grandes volumes de informação ou arquivos, pois os dados não ficam visíveis na URL do navegador, ao contrário do método `GET`. Além disso, o `POST` não possui limite de caracteres.

2. **Captura de Dados:**
   ```php
   $nome = $_POST['usuario_nome'];
   echo "Bem-vindo, " . $nome . "!";
   ```

3. **Operadores:**
   O operador `=` é de **atribuição** (ex: `$x = 10;` define que x vale 10). 
   O operador `==` é de **comparação** (ex: `if ($x == 10)` verifica se o valor de x é igual a 10).

---

### **Módulo 2: Estruturas de Controle e Arrays**

4. **Laço While:**
   ```php
   <?php
       $i = 10;
       while ($i >= 1) {
           echo $i . " ";
           $i--; // Decremento
       }
   ?>
   ```

5. **Arrays Associativos:**
   ```php
   echo $aluno['nota'];
   ```

---

### **Módulo 3: Banco de Dados e SQL**

6. **Inserção de Dados:**
   ```sql
   INSERT INTO produtos (nome, preco, estoque) VALUES ('Teclado Mecânico', 250.00, 10);
   ```

7. **Configuração PDO:**
   O PHP lançará uma **PDOException** (exceção). Se não houver um bloco `try/catch` para tratar o erro, a execução do script será interrompida e uma mensagem de erro de conexão será exibida (dependendo das configurações de erro do servidor).

---

### **Módulo 4: Listagem e Segurança**

8. **Exibição Condicional:**
   ```php
   if ($p['estoque'] == 0) {
       echo "Indisponível";
   } else {
       echo $p['estoque'];
   }
   ```

9. **Segurança XSS:**
   Serve para evitar ataques de **Cross-Site Scripting (XSS)**. Ela converte caracteres especiais (como `<` e `>`) em entidades HTML, impedindo que códigos maliciosos inseridos por usuários sejam executados como scripts reais no navegador de outros visitantes.

---

### **Módulo 5: Update, Delete e Parâmetros**

10. **Parâmetros via URL:** 
    A superglobal `$_GET` (especificamente `$_GET['id']`).

11. **Lógica de Deleção:**
    Todos os registros da tabela seriam apagados permanentemente, pois o banco de dados não saberia qual linha específica você deseja remover.

12. **Redirecionamento:**
    Para garantir que o processamento do script seja interrompido imediatamente. Sem o `exit;`, o PHP pode continuar executando o código que está abaixo do `header()`, o que pode causar erros de lógica ou processamento desnecessário no banco de dados.

---

### **Módulo Bônus: Desafio Prático de SQL**

13. **SQL:**
    ```sql
    SELECT * FROM produtos WHERE preco > 100 AND estoque < 5 ORDER BY nome ASC;
    ```
